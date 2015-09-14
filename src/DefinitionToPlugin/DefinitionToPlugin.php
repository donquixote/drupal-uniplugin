<?php

namespace Drupal\uniplugin\DefinitionToPlugin;

use Drupal\uniplugin\DefinitionToPlugin\Chained\ClassDefinitionToPlugin;
use Drupal\uniplugin\DefinitionToPlugin\Chained\FactoryDefinitionToPlugin;
use Drupal\uniplugin\DefinitionToPlugin\Chained\HandlerClassDefinitionToPlugin;
use Drupal\uniplugin\DefinitionToPlugin\Chained\HandlerFactoryDefinitionToPlugin;
use Drupal\uniplugin\DefinitionToPlugin\Chained\HandlerObjectDefinitionToPlugin;
use Drupal\uniplugin\DefinitionToPlugin\Chained\PluginClassDefinitionToPlugin;
use Drupal\uniplugin\DefinitionToPlugin\Chained\PluginFactoryDefinitionToPlugin;
use Drupal\uniplugin\DefinitionToPlugin\Chained\PluginObjectDefinitionToPlugin;
use Drupal\uniplugin\UniPlugin\Broken\BrokenUniPlugin;
use Drupal\uniplugin\UniPlugin\UniPluginInterface;

class DefinitionToPlugin implements DefinitionToPluginInterface {

  /**
   * @var \Drupal\uniplugin\DefinitionToPlugin\Chained\ChainedDefinitionToPluginInterface[]
   */
  private $chain = array();

  /**
   * @return static
   */
  static function createDefault() {
    return new static(array(
      'plugin' => new PluginObjectDefinitionToPlugin(),
      'plugin_factory' => new PluginFactoryDefinitionToPlugin(),
      'plugin_class' => new PluginClassDefinitionToPlugin(),
      'handler' => new HandlerObjectDefinitionToPlugin(),
      'handler_factory' => new HandlerFactoryDefinitionToPlugin(),
      'handler_class' => new HandlerClassDefinitionToPlugin(),
      'factory' => new FactoryDefinitionToPlugin(),
      'class' => new ClassDefinitionToPlugin(),
    ));
  }

  /**
   * ChainedDefinitionToPlugin constructor.
   *
   * @param \Drupal\uniplugin\DefinitionToPlugin\Chained\ChainedDefinitionToPluginInterface[] $chain
   */
  function __construct(array $chain) {
    $this->chain = $chain;
  }

  /**
   * Gets the handler object, or a fallback object for broken / missing handler.
   *
   * @param array $definition
   *
   * @return \Drupal\uniplugin\UniPlugin\UniPluginInterface
   */
  function definitionGetPlugin(array $definition) {

    foreach ($this->chain as $key => $definitionToPlugin) {
      if (isset($definition[$key])) {
        $plugin = $definitionToPlugin->argDefinitionGetPlugin($definition[$key], $definition);
        if ($plugin instanceof UniPluginInterface) {
          if ($plugin instanceof BrokenUniPlugin) {
            $plugin->setPluginDefinition($definition);
          }
          return $plugin;
        }
      }
    }

    return BrokenUniPlugin::createFromMessage(
      'The definition does not contain sufficient information to obtain a plugin object.')
      ->setPluginDefinition($definition);
  }
}
