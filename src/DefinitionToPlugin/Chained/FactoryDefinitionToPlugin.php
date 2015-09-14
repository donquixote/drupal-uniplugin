<?php

namespace Drupal\uniplugin\DefinitionToPlugin\Chained;

use Drupal\uniplugin\UniPlugin\FixedHandlerUniPlugin;
use Drupal\uniplugin\UniPlugin\Broken\BrokenUniPlugin;
use Drupal\uniplugin\UniPlugin\UniPluginInterface;

class FactoryDefinitionToPlugin implements ChainedDefinitionToPluginInterface {

  /**
   * @param mixed $factory
   * @param array $definition
   *
   * @return \Drupal\uniplugin\UniPlugin\UniPluginInterface
   */
  function argDefinitionGetPlugin($factory, array $definition) {
    if (!is_callable($factory)) {
      return BrokenUniPlugin::createFromMessage(
        '$definition[factory] is not callable.');
    }
    $args = isset($definition['factory_arguments'])
      ? $definition['factory_arguments']
      : array();
    if (!is_array($args)) {
      return BrokenUniPlugin::createFromMessage('$definition[factory_arguments] must be an array or NULL.');
    }
    $pluginOrHandler = call_user_func_array($factory, $args);

    if ($pluginOrHandler instanceof UniPluginInterface) {
      return $pluginOrHandler;
    }
    elseif (is_object($pluginOrHandler)) {
      return new FixedHandlerUniPlugin($pluginOrHandler);
    }
    else {
      return BrokenUniPlugin::createFromMessage(
        '$definition[factory] did not return an object.')
        ->setInvalidPlugin($pluginOrHandler);
    }
  }
}
