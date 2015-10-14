<?php

namespace Drupal\uniplugin;

use Drupal\uniplugin\DefinitionsById\DefinitionsByIdFromType;
use Drupal\uniplugin\DefinitionsByTypeAndId\DefinitionsByTypeAndIdDiscovery;
use Drupal\uniplugin\PluginTypeDIC\DiscoveryObjectPluginTypeDIC;
use Drupal\uniplugin\TypeContext\UniPluginTypeContextInterface;
use Drupal\uniplugin\TypeToDefinitionsById\TypeToDefinitionsById;

class UniPluginHub {

  /**
   * @var \Drupal\uniplugin\TypeToDefinitionsById\TypeToDefinitionsByIdInterface|null
   */
  private $typeToDefinitionsById;

  /**
   * @var \Drupal\uniplugin\PluginTypeDIC\PluginTypeServiceContainerBase[]
   *   Format: $[$interface] = $pluginTypeDIC
   */
  private $uniPluginTypeDICs = array();

  /**
   * @param $interface
   *
   * @return \Drupal\uniplugin\HandlerMap\UniHandlerMapInterface
   */
  function interfaceGetHandlerMap($interface) {
    return $this->interfaceGetPluginTypeDIC($interface)->handlerMap;
  }

  /**
   * @param string $interface
   * @param \Drupal\uniplugin\TypeContext\UniPluginTypeContextInterface $context
   *
   * @return \Drupal\uniplugin\HandlerMap\UniHandlerMapInterface
   */
  function interfaceContextGetHandlerMap($interface, UniPluginTypeContextInterface $context) {
    return $this->interfaceGetPluginTypeDIC($interface)->contextToHandlerMap->contextGetHandlerMap($context);
  }

  /**
   * @param string $interface
   *
   * @return \Drupal\uniplugin\PluginTypeDIC\PluginTypeServiceContainerBase
   */
  function interfaceGetPluginTypeDIC($interface) {
    if (array_key_exists($interface, $this->uniPluginTypeDICs)) {
      return $this->uniPluginTypeDICs[$interface];
    }
    else {
      $discovery = new DefinitionsByIdFromType($this->getTypeToDefinitionsById(), $interface);
      return $this->uniPluginTypeDICs[$interface] = new DiscoveryObjectPluginTypeDIC($discovery);
    }
  }

  /**
   * @return \Drupal\uniplugin\TypeToDefinitionsById\TypeToDefinitionsByIdInterface
   */
  private function getTypeToDefinitionsById() {
    if (NULL !== $this->typeToDefinitionsById) {
      return $this->typeToDefinitionsById;
    }
    else {
      /* @see hook_uniplugin_info() */
      $definitionsByTypeAndId = new DefinitionsByTypeAndIdDiscovery('uniplugin_info');
      // @todo Re-enable the cache.
      return $this->typeToDefinitionsById = new TypeToDefinitionsById($definitionsByTypeAndId);
    }
  }

}
