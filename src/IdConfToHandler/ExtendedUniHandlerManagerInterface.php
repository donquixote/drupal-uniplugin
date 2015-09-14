<?php
namespace Drupal\uniplugin\IdConfToHandler;

interface ExtendedUniHandlerManagerInterface {

  /**
   * @param array $settings
   * @param string $key
   *
   * @return object|null
   */
  function settingsKeyGetHandler(array $settings, $key);

  /**
   * @param array $settings
   *
   * @return object|null
   */
  function settingsGetHandler(array $settings);

  /**
   * @param string $plugin_id
   * @param array $conf
   *
   * @return object
   */
  function idConfGetHandler($plugin_id, array $conf = NULL);
}
