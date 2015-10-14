<?php

namespace Drupal\uniplugin\UniPlugin;

use Drupal\uniplugin\Handler\BrokenUniHandler;
use Drupal\uniplugin\ReflectionUtil;
use Drupal\uniplugin\UniPlugin\OptionHandler\OptionHandlerInterface;

class HandlerClassConfigurableUniPlugin implements ConfigurableUniPluginInterface {

  /**
   * @var string
   */
  private $class;

  /**
   * @var \Drupal\uniplugin\UniPlugin\OptionHandler\OptionHandlerInterface[]
   */
  private $constructorArgumentHandlers;

  /**
   * Argument handlers for simple, one-param setters.
   *
   * @var \Drupal\uniplugin\UniPlugin\OptionHandler\OptionHandlerInterface[]
   */
  private $setterArgumentHandlers = array();

  /**
   * @param string $class
   * @param string[] $setterMethodLabels
   *
   * @return null|static
   */
  static function createFromClass($class, array $setterMethodLabels = array()) {
    if (!class_exists($class)) {
      return NULL;
    }
    $reflectionClass = new \ReflectionClass($class);
    $constructorArgumentHandlers = ReflectionUtil::reflectionClassGetConstructorArgumentHandlers($reflectionClass);
    if (FALSE === $constructorArgumentHandlers) {
      return NULL;
    }
    $setterArgumentHandlers = array();
    foreach ($setterMethodLabels as $methodName => $label) {
      if (!$reflectionClass->hasMethod($methodName)) {
        continue;
      }
      $method = $reflectionClass->getMethod($methodName);
      $setterArgumentHandler = ReflectionUtil::reflectionFunctionGetSingleArgumentHandler($method);
      if (FALSE === $setterArgumentHandler) {
        continue;
      }
      $setterArgumentHandlers[$methodName] = $setterArgumentHandler;
    }
    if (!count($constructorArgumentHandlers) && !count($setterArgumentHandlers)) {
      return new HandlerClassUniPlugin($class);
    }
    $plugin = new static($class, $constructorArgumentHandlers);
    foreach ($setterArgumentHandlers as $methodName => $setterArgumentHandler) {
      $plugin->addSimpleSetter($methodName, $setterArgumentHandler);
    }
    return $plugin;
  }

  /**
   * DynamicConfigurableUniPlugin constructor.
   *
   * @param string $class
   * @param \Drupal\uniplugin\UniPlugin\OptionHandler\OptionHandlerInterface[] $constructorArgumentHandlers
   */
  function __construct($class, array $constructorArgumentHandlers) {
    $this->class = $class;
    $this->constructorArgumentHandlers = $constructorArgumentHandlers;
  }

  /**
   * @param string $methodName
   * @param \Drupal\uniplugin\UniPlugin\OptionHandler\OptionHandlerInterface $argumentHandler
   */
  function addSimpleSetter($methodName, OptionHandlerInterface $argumentHandler) {
    $this->setterArgumentHandlers[$methodName] = $argumentHandler;
  }

  /**
   * Builds a settings form for the plugin configuration.
   *
   * @param array $conf
   *   Current configuration. Will be empty if not configured yet.
   *
   * @return array
   *   A sub-form array to configure the plugin.
   *
   * @see \views_handler::options_form()
   */
  function confGetForm(array $conf) {
    $form = array();
    foreach ($this->constructorArgumentHandlers as $key => $argumentHandler) {
      $value = array_key_exists($key, $conf) ? $conf[$key] : NULL;
      $form[$key] = $argumentHandler->settingBuildForm($value);
    }
    foreach ($this->setterArgumentHandlers as $methodName => $argumentHandler) {
      $value = array_key_exists($methodName, $conf) ? $conf[$methodName] : NULL;
      $form[$methodName] = $argumentHandler->settingBuildForm($value);
    }
    return $form;
  }

  /**
   * @param array $conf
   *   Plugin configuration.
   * @param string $pluginLabel
   *   Label from the plugin definition.
   *
   * @return string|null
   */
  function confGetSummary(array $conf, $pluginLabel = NULL) {
    if (!class_exists($this->class)) {
      return t('Broken handler: Missing class @class.', array('@class' => $this->class));
    }
    $pieces = array();
    foreach ($this->constructorArgumentHandlers as $key => $argumentHandler) {
      $value = array_key_exists($key, $conf) ? $conf[$key] : NULL;
      $pieces[] = $argumentHandler->settingBuildSummary($value);
    }
    foreach ($this->setterArgumentHandlers as $methodName => $argumentHandler) {
      if (!isset($conf[$methodName])) {
        continue;
      }
      $pieces[] = $argumentHandler->settingBuildSummary($conf[$methodName]);
    }
    return implode('<br/>', $pieces);
  }

  /**
   * Gets a handler object that does the business logic.
   *
   * @param array $conf
   *   Configuration for the handler object creation, if this plugin is
   *   configurable.
   *
   * @return object|null
   *   The handler object, or NULL.
   *   Plugins should return handlers of a specific type, but they are not
   *   technically required to do this. This is why an additional check should
   *   be performed for everything returned from a plugin.
   *
   * @throws \Exception
   */
  function confGetHandler(array $conf = NULL) {
    if (!class_exists($this->class)) {
      return BrokenUniHandler::createFromMessage('Class @class does not exist.', array('@class' => $this->class))
        ->setPlugin($this);
    }
    $args = array();
    foreach ($this->constructorArgumentHandlers as $key => $argumentHandler) {
      $value = array_key_exists($key, $conf) ? $conf[$key] : NULL;
      $args[] = $argumentHandler->settingBuildArgument($value);
    }
    $reflectionClass = new \ReflectionClass($this->class);
    $handler = $reflectionClass->newInstanceArgs($args);
    foreach ($this->setterArgumentHandlers as $methodName => $argumentHandler) {
      if (!$reflectionClass->hasMethod($methodName)) {
        // Plugin definition out of date.
        // @todo Complain somehow.
        continue;
      }
      $reflectionMethod = $reflectionClass->getMethod($methodName);
      $arg = $argumentHandler->settingBuildArgument($conf[$methodName]);
      $reflectionMethod->invokeArgs($handler, array($arg));
    }
    return $handler;
  }
}
