<?php

namespace Drupal\uniplugin\IdToLabel;

use Drupal\uniplugin\DefinitionToLabel\DefinitionToLabelInterface;
use Drupal\uniplugin\IdToDefinition\IdToDefinitionInterface;

class IdToLabel implements IdToLabelInterface {

  /**
   * @var \Drupal\uniplugin\IdToDefinition\IdToDefinitionInterface
   */
  private $idToDefinition;

  /**
   * @var \Drupal\uniplugin\DefinitionToLabel\DefinitionToLabelInterface
   */
  private $definitionToLabel;

  /**
   * IdToLabel constructor.
   *
   * @param \Drupal\uniplugin\IdToDefinition\IdToDefinitionInterface $idToDefinition
   * @param \Drupal\uniplugin\DefinitionToLabel\DefinitionToLabelInterface $definitionToLabel
   */
  function __construct(IdToDefinitionInterface $idToDefinition, DefinitionToLabelInterface $definitionToLabel) {
    $this->idToDefinition = $idToDefinition;
    $this->definitionToLabel = $definitionToLabel;
  }

  /**
   * @param string $id
   *
   * @return string|null
   */
  function idGetLabel($id) {
    $definition = $this->idToDefinition->idGetDefinition($id);
    return isset($definition)
      ? $this->definitionToLabel->definitionGetLabel($definition)
      : NULL;
  }

}
