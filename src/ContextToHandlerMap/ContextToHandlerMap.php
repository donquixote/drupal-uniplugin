<?php

namespace Drupal\uniplugin\ContextToHandlerMap;

use Drupal\uniplugin\HandlerMap\UniHandlerMap;
use Drupal\uniplugin\IdToLabel\IdToLabelInterface;
use Drupal\uniplugin\IdToPlugin\ContextualIdToPlugin;
use Drupal\uniplugin\IdToPlugin\IdToPluginInterface;
use Drupal\uniplugin\LabelsByModuleAndId\LabelsByModuleAndIdInterface;
use Drupal\uniplugin\TypeContext\UniPluginTypeContextInterface;

class ContextToHandlerMap implements ContextToHandlerMapInterface {

  /**
   * @var \Drupal\uniplugin\IdToPlugin\IdToPluginInterface
   */
  private $idToPlugin;

  /**
   * @var \Drupal\uniplugin\LabelsByModuleAndId\LabelsByModuleAndIdInterface
   */
  private $labelsByModuleAndId;

  /**
   * @var \Drupal\uniplugin\IdToLabel\IdToLabelInterface
   */
  private $idToLabel;

  /**
   * ContextToHandlerMap constructor.
   *
   * @param \Drupal\uniplugin\IdToPlugin\IdToPluginInterface $idToPlugin
   * @param \Drupal\uniplugin\LabelsByModuleAndId\LabelsByModuleAndIdInterface $labelsByModuleAndId
   * @param \Drupal\uniplugin\IdToLabel\IdToLabelInterface $idToLabel
   */
  function __construct(IdToPluginInterface $idToPlugin, LabelsByModuleAndIdInterface $labelsByModuleAndId, IdToLabelInterface $idToLabel) {
    $this->idToPlugin = $idToPlugin;
    $this->labelsByModuleAndId = $labelsByModuleAndId;
    $this->idToLabel = $idToLabel;
  }

  /**
   * @param \Drupal\uniplugin\TypeContext\UniPluginTypeContextInterface $context
   *
   * @return \Drupal\uniplugin\HandlerMap\UniHandlerMapInterface
   */
  function contextGetHandlerMap(UniPluginTypeContextInterface $context) {
    $idToPlugin = new ContextualIdToPlugin($this->idToPlugin, $context);
    return new UniHandlerMap($idToPlugin, $this->labelsByModuleAndId, $this->idToLabel);
  }

}
