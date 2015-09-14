<?php

namespace Drupal\uniplugin\IdConfToHandler;

use Drupal\uniplugin\Handler\BrokenUniHandler;

class ExtendedUniHandlerManager implements ExtendedUniHandlerManagerInterface {

  /**
   * @var \Drupal\uniplugin\IdConfToHandler\IdConfToHandlerInterface
   */
  private $decorated;

  /**
   * @param \Drupal\uniplugin\IdConfToHandler\IdConfToHandlerInterface $decorated
   *
   * @return static
   */
  public static function create(IdConfToHandlerInterface $decorated) {
    return new static($decorated);
  }

  /**
   * @param \Drupal\uniplugin\IdConfToHandler\IdConfToHandlerInterface $decorated
   */
  function __construct(IdConfToHandlerInterface $decorated) {
    $this->decorated = $decorated;
  }

  /**
   * @param array $settings
   * @param string $key
   *
   * @return object|null
   */
  function settingsKeyGetHandler(array $settings, $key) {
    if (!isset($settings[$key])) {
      return BrokenUniHandler::createFromMessage('No settings for @key.', array('@key' => $key));
    }
    return $this->settingsGetHandler($settings[$key]);
  }

  /**
   * @param array $settings
   *
   * @return object
   */
  function settingsGetHandler(array $settings) {
    if (!isset($settings['plugin_id'])) {
      return BrokenUniHandler::createFromMessage('No plugin id in settings.');
    }
    $conf = isset($settings['plugin_options'])
      ? $settings['plugin_options']
      : array();
    return $this->decorated->idConfGetHandler($settings['plugin_id'], $conf);
  }

  /**
   * @param string $plugin_id
   * @param array $conf
   *
   * @return object
   */
  function idConfGetHandler($plugin_id, array $conf = NULL) {
    return $this->decorated->idConfGetHandler($plugin_id, $conf);
  }

}
