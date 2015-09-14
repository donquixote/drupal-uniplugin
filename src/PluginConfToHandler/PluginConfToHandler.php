<?php

namespace Drupal\uniplugin\PluginConfToHandler;

use Drupal\uniplugin\Handler\BrokenUniHandler;
use Drupal\uniplugin\UniPlugin\UniPluginInterface;

class PluginConfToHandler implements PluginConfToHandlerInterface {

  /**
   * @param \Drupal\uniplugin\UniPlugin\UniPluginInterface $plugin
   * @param array $conf
   *
   * @return object
   */
  function pluginConfGetHandler(UniPluginInterface $plugin, array $conf) {

    try {
      $handler = $plugin->confGetHandler($conf);
    }
    catch (\Exception $e) {
      return BrokenUniHandler::createFromMessage('Exception in $plugin->confGetHandler().')
        ->setPlugin($plugin)
        ->setPluginConfiguration($conf)
        ->setException($e);
    }

    if (!is_object($handler)) {
      return BrokenUniHandler::createFromMessage('Handler returned by $plugin->confGetHandler() is not an object.')
        ->setPlugin($plugin)
        ->setPluginConfiguration($conf)
        ->setNonObjectHandler($handler);
    }

    return $handler;
  }
}
