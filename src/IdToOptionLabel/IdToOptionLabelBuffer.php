<?php

namespace Drupal\uniplugin\IdToOptionLabel;

class IdToOptionLabelBuffer implements IdToOptionLabelInterface {

  /**
   * @var \Drupal\uniplugin\IdToOptionLabel\IdToOptionLabelInterface
   */
  private $idToOptionLabel;

  /**
   * @var string[]
   */
  private $labels = array();

  /**
   * IdToOptionLabelBuffer constructor.
   *
   * @param \Drupal\uniplugin\IdToOptionLabel\IdToOptionLabelInterface $idToOptionLabel
   */
  function __construct(IdToOptionLabelInterface $idToOptionLabel) {
    $this->idToOptionLabel = $idToOptionLabel;
  }

  /**
   * @param string $id
   *
   * @return string|null
   */
  function idGetOptionLabel($id) {
    return array_key_exists($id, $this->labels)
      ? $this->labels[$id]
      : $this->labels[$id] = $this->idToOptionLabel->idGetOptionLabel($id);
  }
}
