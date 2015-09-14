<?php

namespace Drupal\uniplugin\UniPlugin;

use Drupal\uniplugin\Handler\BrokenUniHandler;

/**
 * Plugin where the handler object is created by instantiating a handler class.
 */
class HandlerClassUniPlugin implements UniPluginInterface {

  /**
   * @var string
   */
  private $class;

  /**
   * @var array
   */
  private $arguments;

  /**
   * @param string $class
   * @param array $arguments
   */
  function __construct($class, array $arguments = array()) {
    $this->class = $class;
    $this->arguments = $arguments;
  }

  /**
   * @param array $configuration
   *
   * @return object|\Drupal\uniplugin\Handler\BrokenUniHandlerInterface
   *
   * @throws \Exception
   */
  function confGetHandler(array $configuration = NULL) {
    $class = $this->class;
    if (!class_exists($class)) {
      return BrokenUniHandler::createFromMessage('Class @class does not exist.', array('@class' => $class))
        ->setPlugin($this);
    }
    if (empty($this->arguments)) {
      return new $class();
    }
    else {
      $arguments = $this->arguments;
      $reflection_class = new \ReflectionClass($class);
      return $reflection_class->newInstanceArgs($arguments);
    }
  }
}
