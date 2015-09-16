<?php

namespace Drupal\uniplugin\IdConfToSummary;

use Drupal\uniplugin\IdToLabel\IdToLabelInterface;
use Drupal\uniplugin\IdToPlugin\IdToPluginInterface;
use Drupal\uniplugin\UniPlugin\ConfigurableUniPluginInterface;

class IdConfToSummary implements IdConfToSummaryInterface {

  /**
   * @var \Drupal\uniplugin\IdToLabel\IdToLabelInterface
   */
  private $idToLabel;

  /**
   * @var \Drupal\uniplugin\IdToPlugin\IdToPluginInterface
   */
  private $idToPlugin;

  /**
   * IdConfToSummary constructor.
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
   * @param array $conf
   *
   * @return string
   */
  function idConfGetSummary($id, array $conf) {
    $label = $this->idToLabel->idGetLabel($id);
    $plugin = $this->idToPlugin->idGetPlugin($id);
    if (!$plugin instanceof ConfigurableUniPluginInterface) {
      return $label;
    }
    $options_summary = $plugin->confGetSummary($conf, $label);
    if (NULL === $options_summary) {
      return $label;
    }
    return $label . ': ' . $options_summary;
  }
}
