<?php

namespace Drupal\uniplugin\UniPlugin;

/**
 * Plugin with an already instantiated handler object.
 */
class FixedHandlerUniPlugin implements UniPluginInterface {

  /**
   * @var object
   */
  private $handler;

  /**
   * @param object
   */
  function __construct($handler) {
    $this->handler = $handler;
  }

  /**
   * @param array $configuration
   *
   * @return object|null
   */
  function confGetHandler(array $configuration = NULL) {
    return $this->handler;
  }
}
