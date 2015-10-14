<?php

namespace Drupal\uniplugin\DefinitionToPlugin\Chained;

use Drupal\uniplugin\ReflectionUtil;
use Drupal\uniplugin\UniPlugin\Broken\BrokenUniPlugin;
use Drupal\uniplugin\UniPlugin\Contextual\FactoryContextualUniPlugin;
use Drupal\uniplugin\UniPlugin\UniPluginInterface;

class PluginFactoryDefinitionToPlugin implements ChainedDefinitionToPluginInterface {

  /**
   * Gets the handler object, or a fallback object for broken / missing handler.
   *
   * @param mixed $pluginFactory
   * @param array $definition
   *
   * @return null|\Drupal\uniplugin\UniPlugin\Candidate\UniPluginCandidateInterface
   */
  function argDefinitionGetPlugin($pluginFactory, array $definition) {

    $reflFactory = ReflectionUtil::callbackGetReflection($pluginFactory);

    if (NULL === $reflFactory) {
      return BrokenUniPlugin::createFromMessage(
        '$definition[plugin_factory] of type ' . gettype($pluginFactory) . ' is not callable.');
    }

    $reflParams = $reflFactory->getParameters();

    if (empty($reflParams)) {
      // We are only interested in plugin factories that actually require
      // contextual parameters.
      return NULL;
    }

    $args = isset($definition['plugin_factory_arguments'])
      ? $definition['plugin_factory_arguments']
      : array();

    $missingArgs = array();

    foreach ($reflParams as $i => $reflParam) {
      if (!array_key_exists($i, $args)) {
        $missingArgs[$i] = $reflParam;
      }
    }

    if (count($missingArgs)) {
      return new FactoryContextualUniPlugin($pluginFactory, $args, $missingArgs);
    }

    try {
      $plugin = call_user_func_array($pluginFactory, $args);
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
