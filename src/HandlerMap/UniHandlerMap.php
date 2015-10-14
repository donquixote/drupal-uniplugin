<?php

namespace Drupal\uniplugin\HandlerMap;

use Drupal\uniplugin\Handler\BrokenUniHandler;
use Drupal\uniplugin\IdConfToHandler\IdConfToHandler;
use Drupal\uniplugin\IdConfToSummary\IdConfToSummary;
use Drupal\uniplugin\IdToLabel\IdToLabelInterface;
use Drupal\uniplugin\IdToPlugin\IdToPluginInterface;
use Drupal\uniplugin\LabelsByModuleAndId\LabelsByModuleAndIdInterface;
use Drupal\uniplugin\PluginConfToHandler\PluginConfToHandler;

use Drupal\uniplugin\Uikit\UniPluginUikitElementType;

class UniHandlerMap implements UniHandlerMapInterface {

  /**
   * @var \Drupal\uniplugin\IdConfToSummary\IdConfToSummaryInterface
   */
  private $idConfToSummary;

  /**
   * @var \Drupal\uniplugin\IdConfToHandler\IdConfToHandlerInterface
   */
  private $idConfToHandler;

  /**
   * @var
   */
  private $idToPlugin;

  /**
   * @var
   */
  private $labelsByModuleAndId;

  /**
   * UniHandlerMap constructor.
   *
   * @param \Drupal\uniplugin\IdToPlugin\IdToPluginInterface $idToPlugin
   * @param \Drupal\uniplugin\LabelsByModuleAndId\LabelsByModuleAndIdInterface $labelsByModuleAndId
   * @param \Drupal\uniplugin\IdToLabel\IdToLabelInterface $idToLabel
   */
  function __construct(IdToPluginInterface $idToPlugin, LabelsByModuleAndIdInterface $labelsByModuleAndId, IdToLabelInterface $idToLabel) {
    $this->idToPlugin = $idToPlugin;
    $this->labelsByModuleAndId = $labelsByModuleAndId;
    $this->idConfToSummary = new IdConfToSummary($idToLabel, $idToPlugin);
    $pluginConfToHandler = new PluginConfToHandler();
    $this->idConfToHandler = new IdConfToHandler($idToPlugin, $pluginConfToHandler);
  }

  /**
   * @param array $conf
   *
   * @return array
   */
  function confGetForm(array $conf) {
    return array(
      '#type' => UIKIT_ELEMENT_TYPE,
      UIKIT_K_TYPE_OBJECT => new UniPluginUikitElementType($this->labelsByModuleAndId, $this->idToPlugin),
      '#default_value' => $conf,
    );
  }

  /**
   * @param array $settings
   *
   * @return string
   */
  function confGetSummary(array $settings) {
    if (!isset($settings['plugin_id'])) {
      return t('No plugin selected.');
    }
    $id = $settings['plugin_id'];
    $conf = isset($settings['plugin_options'])
      ? $settings['plugin_options']
      : array();
    $summary = $this->idConfToSummary->idConfGetSummary($id, $conf);
    if (!isset($summary)) {
      return t('Missing plugin');
    }
    return $summary;
  }

  /**
   * @param array $conf
   *
   * @return object
   */
  function confGetHandler(array $conf) {
    if (!isset($settings['plugin_id'])) {
      return BrokenUniHandler::createFromMessage('No plugin id in settings.');
    }
    $conf = isset($settings['plugin_options'])
      ? $settings['plugin_options']
      : array();
    return $this->idConfToHandler->idConfGetHandler($settings['plugin_id'], $conf);
  }
}
