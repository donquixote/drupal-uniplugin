<?php

namespace Drupal\uniplugin\UniPlugin;

use Drupal\uniplugin\ReflectionUtil;

class HandlerFactoryConfigurableUniPlugin implements ConfigurableUniPluginInterface {

  /**
   * @var \ReflectionMethod
   */
  private $reflectionMethod;

  /**
   * @var \Drupal\uniplugin\UniPlugin\OptionHandler\PluginTypeOptionHandler[]
   */
  private $argumentHandlers;

  /**
   * @param string $class
   * @param string $methodName
   *
   * @return \Drupal\uniplugin\UniPlugin\HandlerFactoryUniPlugin|null|static
   */
  static function createFromStaticMethod($class, $methodName) {
    $reflectionMethod = new \ReflectionMethod($class, $methodName);
    $argumentHandlers = ReflectionUtil::reflectionFunctionGetArgumentHandlers($reflectionMethod);
    if (FALSE === $argumentHandlers) {
      return NULL;
    }
    if (!count($argumentHandlers)) {
      return new HandlerFactoryUniPlugin($class . '::' . $methodName);
    }
    return new static($reflectionMethod, $argumentHandlers);
  }

  /**
   * HandlerFactoryConfigurableUniPlugin constructor.
   *
   * @param \ReflectionMethod $reflectionMethod
   * @param \Drupal\uniplugin\UniPlugin\OptionHandler\PluginTypeOptionHandler[] $argumentHandlers
   */
  function __construct(\ReflectionMethod $reflectionMethod, array $argumentHandlers) {
    $this->reflectionMethod = $reflectionMethod;
    $this->argumentHandlers = $argumentHandlers;
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
    foreach ($this->argumentHandlers as $key => $argumentHandler) {
      $value = array_key_exists($key, $conf) ? $conf[$key] : NULL;
      $form[$key] = $argumentHandler->settingBuildForm($value);
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
    $pieces = array();
    foreach ($this->argumentHandlers as $key => $argumentHandler) {
      $value = array_key_exists($key, $conf) ? $conf[$key] : NULL;
      $pieces[] = $argumentHandler->settingBuildSummary($value);
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
    $args = array();
    foreach ($this->argumentHandlers as $key => $argumentHandler) {
      $value = array_key_exists($key, $conf) ? $conf[$key] : NULL;
      $args[] = $argumentHandler->settingBuildArgument($value);
    }
    return $this->reflectionMethod->invokeArgs(NULL, $args);
  }
}
