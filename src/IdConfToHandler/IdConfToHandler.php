<?php

namespace Drupal\uniplugin\IdConfToHandler;

use Drupal\uniplugin\Handler\BrokenUniHandler;
use Drupal\uniplugin\IdToPlugin\IdToPluginInterface;
use Drupal\uniplugin\PluginConfToHandler\PluginConfToHandlerInterface;

class IdConfToHandler implements IdConfToHandlerInterface {

  /**
   * @var \Drupal\uniplugin\IdToPlugin\IdToPluginInterface
   */
  private $idToPlugin;

  /**
   * @var \Drupal\uniplugin\PluginConfToHandler\PluginConfToHandlerInterface
   */
  private $pluginConfToHandler;

  /**
   * @param \Drupal\uniplugin\IdToPlugin\IdToPluginInterface $idToPlugin
   * @param \Drupal\uniplugin\PluginConfToHandler\PluginConfToHandlerInterface $pluginConfToHandler
   */
  function __construct(IdToPluginInterface $idToPlugin, PluginConfToHandlerInterface $pluginConfToHandler) {
    $this->idToPlugin = $idToPlugin;
    $this->pluginConfToHandler = $pluginConfToHandler;
  }

  /**
   * @param string $plugin_id
   * @param array $configuration
   *
   * @return object|null
   */
  function idConfGetHandler($plugin_id, array $configuration = NULL) {
    $plugin = $this->idToPlugin->idGetPlugin($plugin_id);
    if (NULL === $plugin) {
      return BrokenUniHandler::createFromMessage('Plugin is NULL.')
        ->setPluginId($plugin_id)
        ->setPluginConfiguration($configuration);
    }
    $handler = $this->pluginConfToHandler->pluginConfGetHandler($plugin, $configuration);
    if ($handler instanceof BrokenUniHandler) {
      $handler->setPluginId($plugin_id);
    }
    return $handler;
  }
}
