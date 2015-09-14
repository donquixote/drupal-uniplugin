<?php

namespace Drupal\uniplugin\DefinitionToPlugin\Chained;

use Drupal\uniplugin\UniPlugin\HandlerFactoryUniPlugin;

class HandlerFactoryDefinitionToPlugin implements ChainedDefinitionToPluginInterface {

  /**
   * @param mixed $handler_factory
   * @param array $definition
   *
   * @return \Drupal\uniplugin\UniPlugin\UniPluginInterface
   */
  function argDefinitionGetPlugin($handler_factory, array $definition) {
    $args = isset($definition['handler_factory_arguments'])
      ? $definition['handler_factory_arguments']
      : array();
    return new HandlerFactoryUniPlugin($handler_factory, $args);
  }
}
