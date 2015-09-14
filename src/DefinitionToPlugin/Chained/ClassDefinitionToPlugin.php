<?php

namespace Drupal\uniplugin\DefinitionToPlugin\Chained;

use Drupal\uniplugin\UniPlugin\FixedHandlerUniPlugin;
use Drupal\uniplugin\UniPlugin\Broken\BrokenUniPlugin;
use Drupal\uniplugin\UniPlugin\UniPluginInterface;

class ClassDefinitionToPlugin implements ChainedDefinitionToPluginInterface {

  /**
   * @param mixed $class
   * @param array $definition
   *
   * @return \Drupal\uniplugin\UniPlugin\UniPluginInterface
   */
  function argDefinitionGetPlugin($class, array $definition) {

    if (!class_exists($class)) {
      return BrokenUniPlugin::createFromMessage(
        '$definition[class] is not an existing class.');
    }

    if (!empty($definition['class_arguments'])) {
      $reflection_class = new \ReflectionClass($class);
      $pluginOrHandler = $reflection_class->newInstanceArgs($definition['class_arguments']);
    }
    else {
      $pluginOrHandler = new $class();
    }

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
