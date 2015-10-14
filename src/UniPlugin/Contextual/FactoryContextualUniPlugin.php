<?php

namespace Drupal\uniplugin\UniPlugin\Contextual;

use Drupal\uniplugin\Handler\BrokenUniHandler;
use Drupal\uniplugin\TypeContext\UniPluginTypeContextInterface;
use Drupal\uniplugin\UniPlugin\Broken\BrokenUniPlugin;
use Drupal\uniplugin\UniPlugin\UniPluginInterface;

class FactoryContextualUniPlugin implements ContextualUniPluginInterface {

  /**
   * @var callable
   */
  private $factory;

  /**
   * @var \mixed[]
   */
  private $args;

  /**
   * @var \ReflectionParameter[]
   */
  private $missingArgs;

  /**
   * FactoryContextualUniPlugin constructor.
   *
   * @param callable $factory
   * @param mixed[] $args
   * @param \ReflectionParameter[] $missingArgs
   */
  function __construct($factory, array $args, array $missingArgs) {
    $this->factory = $factory;
    $this->args = $args;
    $this->missingArgs = $missingArgs;
  }

  /**
   * @param \Drupal\uniplugin\TypeContext\UniPluginTypeContextInterface $context
   *
   * @return \Drupal\uniplugin\UniPlugin\UniPluginInterface|null
   */
  function contextGetPlugin(UniPluginTypeContextInterface $context) {

    $args = array();

    for ($i = 0; TRUE; ++$i) {
      if (array_key_exists($i, $this->args)) {
        $args[$i] = $this->args[$i];
      }
      elseif (array_key_exists($i, $this->missingArgs)) {
        $paramName = $this->missingArgs[$i]->getName();
        if (!$context->paramNameHasValue($paramName)) {
          return NULL;
        }
        $args[$i] = $context->paramNameGetValue($paramName);
      }
      else {
        break;
      }
    }

    try {
      $plugin = $this->argsInvokeFactory($args);
    }
    catch (\Exception $e) {
      return BrokenUniPlugin::createFromMessage('Exception in plugin factory.')
        ->setException($e);
    }

    if (!$plugin instanceof UniPluginInterface) {
      return BrokenUniPlugin::createFromMessage(
        '$definition[plugin_factory] did not return a valid plugin object.')
        ->setInvalidPlugin($plugin);
    }

    return $plugin;
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
    return new BrokenUniHandler('Missing context.');
  }

  /**
   * @param array $args
   *
   * @return mixed|null|\Drupal\uniplugin\UniPlugin\UniPluginInterface
   */
  protected function argsInvokeFactory(array $args) {
    return call_user_func_array($this->factory, $args);
  }

}
