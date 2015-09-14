<?php

namespace Drupal\uniplugin\DefinitionToLabel;

use Drupal\uniplugin\DefinitionToPlugin\DefinitionToPluginInterface;
use Drupal\uniplugin\UniPlugin\ConfigurableUniPluginInterface;

class DefinitionToLabel implements DefinitionToLabelInterface {

  /**
   * @var \Drupal\uniplugin\DefinitionToPlugin\DefinitionToPluginInterface
   */
  private $definitionToPlugin;

  /**
   * DefinitionToLabel constructor.
   *
   * @param \Drupal\uniplugin\DefinitionToPlugin\DefinitionToPluginInterface $definitionToPlugin
   */
  function __construct(DefinitionToPluginInterface $definitionToPlugin) {
    $this->definitionToPlugin = $definitionToPlugin;
  }

  /**
   * @param array $definition
   * @param string|null $else
   *
   * @return string|null
   */
  function definitionGetLabel(array $definition, $else = NULL) {
    $label = isset($definition['label'])
      ? $definition['label']
      : $else;
    $plugin = $this->definitionToPlugin->definitionGetPlugin($definition);
    if ($plugin instanceof ConfigurableUniPluginInterface) {
      $label .= '…';
    }
    return $label;
  }
}
