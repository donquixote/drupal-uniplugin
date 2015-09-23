<?php

namespace Drupal\uniplugin\PluginTypeDIC;

use Drupal\uniplugin\DefinitionsById\DefinitionsByIdInterface;

class DiscoveryObjectPluginTypeDIC extends PluginTypeServiceContainerBase {

  /**
   * @var \Drupal\uniplugin\DefinitionsById\DefinitionsByIdInterface
   */
  private $discovery;

  /**
   * DiscoveryObjectPluginTypeDIC constructor.
   *
   * @param \Drupal\uniplugin\DefinitionsById\DefinitionsByIdInterface $discovery
   */
  function __construct(DefinitionsByIdInterface $discovery) {
    $this->discovery = $discovery;
  }

  /**
   * @return \Drupal\uniplugin\DefinitionsById\DefinitionsByIdInterface
   *
   * @see \Drupal\uniplugin\PluginTypeDIC\PluginTypeServiceContainerBase::pluginDefinitionDiscovery
   */
  protected function get_pluginDefinitionDiscovery() {
    return $this->discovery;
  }
}
