<?php

namespace Drupal\uniplugin\LabelsById;

use Drupal\uniplugin\DefinitionsById\DefinitionsByIdInterface;

use Drupal\uniplugin\IdToOptionLabel\IdToOptionLabelInterface;

class LabelsById implements LabelsByIdInterface {

  /**
   * @var \Drupal\uniplugin\DefinitionsById\PluginDefinitionBufferInterface
   */
  private $definitionsById;

  /**
   * @var \Drupal\uniplugin\IdToOptionLabel\IdToOptionLabelInterface
   */
  private $idToOptionLabel;

  /**
   * LabelsById constructor.
   *
   * @param \Drupal\uniplugin\DefinitionsById\DefinitionsByIdInterface $definitionsById
   * @param \Drupal\uniplugin\IdToOptionLabel\IdToOptionLabelInterface $idToOptionLabel
   */
  function __construct(DefinitionsByIdInterface $definitionsById, IdToOptionLabelInterface $idToOptionLabel) {
    $this->definitionsById = $definitionsById;
    $this->idToOptionLabel = $idToOptionLabel;
  }

  /**
   * @return string[]
   *   Format: $[$plugin_id] = $label
   */
  function getLabelsById() {
    $definitions = $this->definitionsById->getDefinitionsById();
    $labelsById = array();
    foreach ($definitions as $id => $definition) {
      $labelsById[$id] = $this->idToOptionLabel->idGetOptionLabel($id);
    }
    return $labelsById;
  }
}
