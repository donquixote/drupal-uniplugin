<?php

namespace Drupal\uniplugin\DefinitionToPlugin\Chained;

use Drupal\uniplugin\UniPlugin\FixedHandlerUniPlugin;

class HandlerObjectDefinitionToPlugin implements ChainedDefinitionToPluginInterface {

  /**
   * @param mixed $handler
   * @param array $definition
   *
   * @return \Drupal\uniplugin\UniPlugin\FixedHandlerUniPlugin|null
   */
  function argDefinitionGetPlugin($handler, array $definition) {
    if (!is_object($handler)) {
      return NULL;
    }
    return new FixedHandlerUniPlugin($handler);
  }
}
