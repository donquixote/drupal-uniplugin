<?php

namespace Drupal\uniplugin\PluginConfToHandler;

use Drupal\uniplugin\UniPlugin\UniPluginInterface;

interface PluginConfToHandlerInterface {

  /**
   * @param \Drupal\uniplugin\UniPlugin\UniPluginInterface $plugin
   * @param array $conf
   *
   * @return object
   */
  function pluginConfGetHandler(UniPluginInterface $plugin, array $conf);

}
