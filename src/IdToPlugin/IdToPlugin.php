<?php

namespace Drupal\uniplugin\IdToPlugin;

use Drupal\uniplugin\IdToDefinition\IdToDefinitionInterface;
use Drupal\uniplugin\DefinitionToPlugin\DefinitionToPluginInterface;

class IdToPlugin implements IdToPluginInterface {

  /**
   * @var \Drupal\uniplugin\IdToDefinition\IdToDefinitionInterface
   */
  private $idToDefinition;

  /**
   * @var \Drupal\uniplugin\DefinitionToPlugin\DefinitionToPluginInterface
   */
  private $definitionToPlugin;

  /**
   * @param \Drupal\uniplugin\IdToDefinition\IdToDefinitionInterface $idToDefinition
   * @param \Drupal\uniplugin\DefinitionToPlugin\DefinitionToPluginInterface $definitionToPlugin
   */
  function __construct(IdToDefinitionInterface $idToDefinition, DefinitionToPluginInterface $definitionToPlugin) {
    $this->idToDefinition = $idToDefinition;
    $this->definitionToPlugin = $definitionToPlugin;
  }

  /**
   * @param string $id
   *
   * @return \Drupal\uniplugin\UniPlugin\UniPluginInterface|null
   */
  function idGetPlugin($id) {
    $definition = $this->idToDefinition->idGetDefinition($id);
    return isset($definition)
      ? $this->definitionToPlugin->definitionGetPlugin($definition)
      : NULL;
  }
}
