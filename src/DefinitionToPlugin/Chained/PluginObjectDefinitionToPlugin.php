<?php

namespace Drupal\uniplugin\DefinitionToPlugin\Chained;

use Drupal\uniplugin\UniPlugin\Broken\BrokenUniPlugin;
use Drupal\uniplugin\UniPlugin\UniPluginInterface;

class PluginObjectDefinitionToPlugin implements ChainedDefinitionToPluginInterface {

  /**
   * Gets the handler object, or a fallback object for broken / missing handler.
   *
   * @param mixed $plugin
   * @param array $definition
   *
   * @return \Drupal\uniplugin\UniPlugin\UniPluginInterface
   */
  function argDefinitionGetPlugin($plugin, array $definition) {
    if (!$plugin instanceof UniPluginInterface) {
      return BrokenUniPlugin::createFromMessage('$definition[plugin] is not a valid plugin object.')
        ->setInvalidPlugin($plugin);
    }
    return $plugin;
  }
}
