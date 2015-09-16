<?php

namespace Drupal\uniplugin\IdToLabel;

class IdToLabelBuffer implements IdToLabelInterface {

  /**
   * @var \Drupal\uniplugin\IdToLabel\IdToLabelInterface
   */
  private $idToLabel;

  /**
   * @var string[]
   */
  private $labels = array();

  /**
   * IdToLabelBuffer constructor.
   *
   * @param \Drupal\uniplugin\IdToLabel\IdToLabelInterface $idToLabel
   */
  function __construct(IdToLabelInterface $idToLabel) {
    $this->idToLabel = $idToLabel;
  }

  /**
   * @param string $id
   *
   * @return string
   */
  function idGetLabel($id) {
    return array_key_exists($id, $this->labels)
      ? $this->labels[$id]
      : $this->labels[$id] = $this->idToLabel->idGetLabel($id);
  }
}
