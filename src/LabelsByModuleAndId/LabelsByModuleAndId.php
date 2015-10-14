<?php

namespace Drupal\uniplugin\LabelsByModuleAndId;

use Drupal\uniplugin\DefinitionsById\DefinitionsByIdInterface;

use Drupal\uniplugin\IdToLabel\IdToLabelInterface;

class LabelsByModuleAndId implements LabelsByModuleAndIdInterface {

  /**
   * @var \Drupal\uniplugin\DefinitionsById\DefinitionsByIdMapInterface
   */
  private $definitionsById;

  /**
   * @var \Drupal\uniplugin\IdToLabel\IdToLabelInterface
   */
  private $idToLabel;

  /**
   * LabelsByModuleAndId constructor.
   *
   * @param \Drupal\uniplugin\DefinitionsById\DefinitionsByIdInterface $definitionsById
   * @param \Drupal\uniplugin\IdToLabel\IdToLabelInterface $idToLabel
   */
  function __construct(DefinitionsByIdInterface $definitionsById, IdToLabelInterface $idToLabel) {
    $this->definitionsById = $definitionsById;
    $this->idToLabel = $idToLabel;
  }

  /**
   * @return string[][]
   *   Format: $[$module][$plugin_id] = $label
   */
  function getLabelsByModuleAndId() {
    $definitions = $this->definitionsById->getDefinitionsById();
    $labels_by_module = array();
    foreach ($definitions as $id => $definition) {
      $label = $this->idToLabel->idGetLabel($id);
      $module = isset($definition['module'])
        ? $definition['module']
        : '';
      $labels_by_module[$module][$id] = $label;
    }
    return $labels_by_module;
  }
}
