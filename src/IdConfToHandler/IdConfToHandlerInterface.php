<?php

namespace Drupal\uniplugin\IdConfToHandler;

interface IdConfToHandlerInterface {

  /**
   * @param string $plugin_id
   * @param array $configuration
   *
   * @return object
   */
  function idConfGetHandler($plugin_id, array $configuration = NULL);

}
