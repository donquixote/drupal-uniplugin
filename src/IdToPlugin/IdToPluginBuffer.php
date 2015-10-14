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
   * @param string $id
   *
   * @return \Drupal\uniplugin\UniPlugin\UniPluginInterface|null
   */
  function idGetPlugin($id) {
    return array_key_exists($id, $this->plugins)
      ? $this->plugins[$id]
      : $this->plugins[$id] = $this->decorated->idGetPlugin($id);
  }
}
