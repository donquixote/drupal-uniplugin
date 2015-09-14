<?php


namespace Drupal\uniplugin\DIC;

abstract class ServiceContainerBase {

  /**
   * @var mixed[]
   */
  protected $services = array();

  /**
   * @param string $key
   *
   * @return mixed
   *
   * @throws \RuntimeException
   */
  function __get($key) {
    if (array_key_exists($key, $this->services)) {
      return $this->services[$key];
    }
    $method = 'get_' . $key;
    $service = $this->$method();
    if (NULL === $service) {
      throw new \RuntimeException(format_string('Method "!class::@method()" returned NULL', array(
        '!class' => static::class,
        '@method' => $method,
      )));
    }
    return $this->services[$key] = $service;
  }

  /**
   * @param string $key
   * @param object $service
   *
   * @throws \RuntimeException
   */
  function __set($key, $service) {
    if (isset($this->services[$key])) {
      throw new \RuntimeException("Service '$key' already set.");
    }
    $this->services[$key] = $service;
  }
}
