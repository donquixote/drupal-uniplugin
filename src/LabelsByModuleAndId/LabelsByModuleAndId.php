<?php

namespace Drupal\uniplugin\LabelsByModuleAndId;

use Drupal\uniplugin\DefinitionsById\DefinitionsByIdInterface;

use Drupal\uniplugin\IdToOptionLabel\IdToOptionLabelInterface;

class LabelsByModuleAndId implements LabelsByModuleAndIdInterface {

  /**
   * @var \Drupal\uniplugin\DefinitionsById\DefinitionsByIdMapInterface
   */
  private $definitionsById;

  /**
   * @var \Drupal\uniplugin\IdToOptionLabel\IdToOptionLabelInterface
   */
  private $idToOptionLabel;

  /**
   * LabelsByModuleAndId constructor.
   *
   * @param \Drupal\uniplugin\DefinitionsById\DefinitionsByIdInterface $definitionsById
   * @param \Drupal\uniplugin\IdToOptionLabel\IdToOptionLabelInterface $idToOptionLabel
   */
  function __construct(DefinitionsByIdInterface $definitionsById, IdToOptionLabelInterface $idToOptionLabel) {
    $this->definitionsById = $definitionsById;
    $this->idToOptionLabel = $idToOptionLabel;
  }

  /**
   * @return string[][]
   *   Format: $[$module][$plugin_id] = $label
   */
  function getLabelsByModuleAndId() {
    $definitions = $this->definitionsById->getDefinitionsById();
    $labels_by_module = array();
    foreach ($definitions as $id => $definition) {
      $label = $this->idToOptionLabel->idGetOptionLabel($id);
      $module = isset($definition['module'])
        ? $definition['module']
        : '';
      $labels_by_module[$module][$id] = $label;
    }
    return $labels_by_module;
  }
}
