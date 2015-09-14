<?php

namespace Drupal\uniplugin\LabelsByModuleAndId;

use Drupal\uniplugin\DefinitionsById\DefinitionsByIdInterface;
use Drupal\uniplugin\DefinitionToLabel\DefinitionToLabelInterface;

class LabelsByModuleAndId implements LabelsByModuleAndIdInterface {

  /**
   * @var \Drupal\uniplugin\DefinitionsById\PluginDefinitionBufferInterface
   */
  private $definitionsById;

  /**
   * @var \Drupal\uniplugin\DefinitionToLabel\DefinitionToLabelInterface
   */
  private $definitionToLabel;

  /**
   * LabelsByModuleAndId constructor.
   *
   * @param \Drupal\uniplugin\DefinitionsById\DefinitionsByIdInterface $definitionsById
   * @param \Drupal\uniplugin\DefinitionToLabel\DefinitionToLabelInterface $definitionToLabel
   */
  function __construct(DefinitionsByIdInterface $definitionsById, DefinitionToLabelInterface $definitionToLabel) {
    $this->definitionsById = $definitionsById;
    $this->definitionToLabel = $definitionToLabel;
  }

  /**
   * @return string[][]
   *   Format: $[$module][$plugin_id] = $label
   */
  function getLabelsByModuleAndId() {
    $definitions = $this->definitionsById->getDefinitionsById();
    $labels_by_module = array();
    foreach ($definitions as $id => $definition) {
      $label = $this->definitionToLabel->definitionGetLabel($definition, $id);
      $module = isset($definition['module'])
        ? $definition['module']
        : '';
      $labels_by_module[$module][$id] = $label;
    }
    return $labels_by_module;
  }
}
