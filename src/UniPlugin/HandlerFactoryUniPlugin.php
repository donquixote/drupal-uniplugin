<?php

namespace Drupal\uniplugin\UniPlugin;

use Drupal\uniplugin\Handler\BrokenUniHandler;

/**
 * Plugin where the handler object is created by calling a handler factory.
 */
class HandlerFactoryUniPlugin implements UniPluginInterface {

  /**
   * @var mixed|callable
   */
  private $factory;

  /**
   * @var array
   */
  private $args;

  /**
   * @param mixed|callable $factory
   * @param array $args
   */
  function __construct($factory, array $args) {
    $this->factory = $factory;
    $this->args = $args;
  }

  /**
   * @param array $configuration
   *
   * @return object|\Drupal\uniplugin\Handler\BrokenUniHandlerInterface
   */
  function confGetHandler(array $configuration = NULL) {
    $factory = $this->factory;
    if (!is_callable($factory)) {
      return BrokenUniHandler::createFromMessage('Handler factory is not callable.')
        ->setPlugin($this)
        ->setPluginConfiguration($configuration);
    }
    $handler = call_user_func_array($factory, $this->args);
    if (!is_object($handler)) {
      return BrokenUniHandler::createFromMessage('Handler factory did not return an object.')
        ->setPlugin($this)
        ->setPluginConfiguration($configuration)
        ->setNonObjectHandler($handler);
    }
    return $handler;
  }
}
