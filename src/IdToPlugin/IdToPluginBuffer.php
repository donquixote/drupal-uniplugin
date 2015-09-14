<?php

namespace Drupal\uniplugin\IdToPlugin;

class IdToPluginBuffer implements IdToPluginInterface {

  /**
   * @var \Drupal\uniplugin\IdToPlugin\IdToPluginInterface
   */
  private $decorated;

  /**
   * @var \Drupal\uniplugin\UniPlugin\UniPluginInterface[]
   */
  private $plugins = array();

  /**
   * @param \Drupal\uniplugin\IdToPlugin\IdToPluginInterface $pluginManager
   */
  function __construct(IdToPluginInterface $pluginManager) {
    $this->decorated = $pluginManager;
  }

  /**
   * @param string $plugin_id
   *
   * @return \Drupal\uniplugin\UniPlugin\UniPluginInterface|null
   */
  function idGetPlugin($plugin_id) {
    return array_key_exists($plugin_id, $this->plugins)
      ? $this->plugins[$plugin_id]
      : $this->plugins[$plugin_id] = $this->decorated->idGetPlugin($plugin_id);
  }
}
