<?php

namespace Drupal\uniplugin\DefinitionToPlugin\Chained;

use Drupal\uniplugin\UniPlugin\Broken\BrokenUniPlugin;
use Drupal\uniplugin\UniPlugin\UniPluginInterface;

class PluginFactoryDefinitionToPlugin implements ChainedDefinitionToPluginInterface {

  /**
   * Gets the handler object, or a fallback object for broken / missing handler.
   *
   * @param mixed $plugin_factory
   * @param array $definition
   *
   * @return \Drupal\uniplugin\UniPlugin\UniPluginInterface
   */
  function argDefinitionGetPlugin($plugin_factory, array $definition) {

    if (!is_callable($plugin_factory)) {
      return BrokenUniPlugin::createFromMessage(
        '$definition[plugin_factory] is not callable.');
    }

    $args = isset($definition['plugin_factory_arguments'])
      ? $definition['plugin_factory_arguments']
      : array();

    try {
      $plugin = call_user_func_array($plugin_factory, $args);
    }
    catch (\Exception $e) {
      return BrokenUniPlugin::createFromMessage('Exception in plugin factory.')
        ->setException($e);
    }

    if (!$plugin instanceof UniPluginInterface) {
      return BrokenUniPlugin::createFromMessage(
        '$definition[plugin_factory] did not return a valid plugin object.')
        ->setInvalidPlugin($plugin);
    }

    return $plugin;
  }
}
