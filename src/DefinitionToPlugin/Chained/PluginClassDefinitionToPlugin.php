<?php

namespace Drupal\uniplugin\DefinitionToPlugin\Chained;

use Drupal\uniplugin\UniPlugin\Broken\BrokenUniPlugin;
use Drupal\uniplugin\UniPlugin\UniPluginInterface;

class PluginClassDefinitionToPlugin implements ChainedDefinitionToPluginInterface {

  /**
   * Gets the handler object, or a fallback object for broken / missing handler.
   *
   * @param mixed $plugin_class
   * @param array $definition
   *
   * @return \Drupal\uniplugin\UniPlugin\UniPluginInterface
   */
  function argDefinitionGetPlugin($plugin_class, array $definition) {

    if (!class_exists($plugin_class)) {
      return BrokenUniPlugin::createFromMessage(
        '$definition[plugin_class] is not an existing class.');
    }

    if (!empty($definition['plugin_class_arguments'])) {
      $reflection_class = new \ReflectionClass($plugin_class);
      try {
        $plugin = $reflection_class->newInstanceArgs($definition['plugin_class_arguments']);
      }
      catch (\Exception $e) {
        return BrokenUniPlugin::createFromMessage(
          'Exception while instantiating $definition[plugin_class] with arguments.')
          ->setException($e);
      }
    }
    else {
      try {
        $plugin = new $plugin_class();
      }
      catch (\Exception $e) {
        return BrokenUniPlugin::createFromMessage(
          'Exception while instantiating $definition[plugin_class].')
          ->setException($e);
      }
    }

    if (!$plugin instanceof UniPluginInterface) {
      return BrokenUniPlugin::createFromMessage(
        '$definition[plugin_class] instance is not a valid plugin object.')
        ->setInvalidPlugin($plugin);
    }

    return $plugin;
  }
}
