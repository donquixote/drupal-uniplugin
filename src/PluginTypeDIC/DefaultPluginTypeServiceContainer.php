<?php

namespace Drupal\uniplugin\PluginTypeDIC;

use Drupal\uniplugin\DefinitionsById\DefinitionsByIdDiscovery;

/**
 * Specific implementation of PluginTypeServiceContainerBase, which uses a
 * hook-based plugin discovery.
 */
class DefaultPluginTypeServiceContainer extends PluginTypeServiceContainerBase {

  /**
   * @var string
   */
  private $discoveryHook;

  /**
   * @var array
   */
  private $discoveryHookArguments;

  /**
   * @param string $hook
   * @param array $arguments
   */
  function __construct($hook, array $arguments = array()) {
    $this->discoveryHook = $hook;
    $this->discoveryHookArguments = $arguments;
  }

  /**
   * @return \Drupal\uniplugin\DefinitionsById\DefinitionsByIdDiscovery
   *
   * @see PluginTypeServiceContainerBase::pluginDefinitionDiscovery
   */
  protected function get_pluginDefinitionDiscovery() {
    return new DefinitionsByIdDiscovery($this->discoveryHook, $this->discoveryHookArguments);
  }

}
