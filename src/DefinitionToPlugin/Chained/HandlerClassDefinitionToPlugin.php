<?php

namespace Drupal\uniplugin\DefinitionToPlugin\Chained;

use Drupal\uniplugin\UniPlugin\HandlerClassUniPlugin;

class HandlerClassDefinitionToPlugin implements ChainedDefinitionToPluginInterface {

  /**
   * @param mixed $handler_class
   * @param array $definition
   *
   * @return \Drupal\uniplugin\UniPlugin\UniPluginInterface
   */
  function argDefinitionGetPlugin($handler_class, array $definition) {
    $args = isset($definition['handler_class_arguments'])
      ? $definition['handler_class_arguments']
      : array();
    return new HandlerClassUniPlugin($handler_class, $args);
  }
}
