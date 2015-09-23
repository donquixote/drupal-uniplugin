<?php

namespace Drupal\uniplugin\IdToOptionLabel;

use Drupal\uniplugin\IdToLabel\IdToLabelInterface;
use Drupal\uniplugin\IdToPlugin\IdToPluginInterface;
use Drupal\uniplugin\UniPlugin\ConfigurableUniPluginInterface;

class IdToOptionLabel implements IdToOptionLabelInterface {

  /**
   * @var \Drupal\uniplugin\IdToLabel\IdToLabelInterface
   */
  private $idToLabel;

  /**
   * @var \Drupal\uniplugin\IdToPlugin\IdToPluginInterface
   */
  private $idToPlugin;

  /**
   * IdToOptionLabel constructor.
   *
   * @param \Drupal\uniplugin\IdToLabel\IdToLabelInterface $idToLabel
   * @param \Drupal\uniplugin\IdToPlugin\IdToPluginInterface $idToPlugin
   */
  function __construct(IdToLabelInterface $idToLabel, IdToPluginInterface $idToPlugin) {
    $this->idToLabel = $idToLabel;
    $this->idToPlugin = $idToPlugin;
  }

  /**
   * @param string $id
   *
   * @return string|null
   */
  function idGetOptionLabel($id) {
    $label = $this->idToLabel->idGetLabel($id);
    if (!isset($label)) {
      return NULL;
    }
    $plugin = $this->idToPlugin->idGetPlugin($id);
    if ($plugin instanceof ConfigurableUniPluginInterface) {
      $label .= '…';
    }
    return $label;
  }

}
