<?php

namespace Drupal\uniplugin\Manager;

use Drupal\uikit\FormElement\UikitElementTypeInterface;
use Drupal\uikit\FormElement\Decorator\UikitElementTypeTitleDecorator;
use Drupal\uniplugin\Handler\BrokenUniHandler;
use Drupal\uniplugin\IdConfToHandler\IdConfToHandlerInterface;
use Drupal\uniplugin\IdToLabel\IdToLabelInterface;

/**
 * Default implementation for UniPluginManagerInterface.
 */
class UniPluginManager implements UniPluginManagerInterface {

  /**
   * @var \Drupal\uikit\FormElement\UikitElementTypeInterface
   */
  private $uikitElementType;

  /**
   * @var \Drupal\uniplugin\IdToLabel\IdToLabelInterface
   */
  private $idToLabel;

  /**
   * @var \Drupal\uniplugin\IdConfToHandler\IdConfToHandlerInterface
   */
  private $idConfToHandler;

  /**
   * FormHelper constructor.
   *
   * @param \Drupal\uikit\FormElement\UikitElementTypeInterface $uikitElementType
   * @param \Drupal\uniplugin\IdConfToHandler\IdConfToHandlerInterface $idConfToHandler
   * @param \Drupal\uniplugin\IdToLabel\IdToLabelInterface $idToLabel
   */
  public function __construct(
    UikitElementTypeInterface $uikitElementType,
    IdConfToHandlerInterface $idConfToHandler,
    IdToLabelInterface $idToLabel
  ) {
    $this->uikitElementType = $uikitElementType;
    $this->idConfToHandler = $idConfToHandler;
    $this->idToLabel = $idToLabel;
  }

  /**
   * @param string|null $title
   *   (optional) Title to give to the element, if it does not have one already.
   *
   * @return \Drupal\uikit\FormElement\UikitElementTypeInterface
   */
  function getUikitElementType($title = NULL) {
    return isset($title)
      ? new UikitElementTypeTitleDecorator($this->uikitElementType, $title)
      : $this->uikitElementType;
  }

  /**
   * @param array $settings
   *
   * @return string
   */
  function settingsGetLabel(array $settings) {
    if (!isset($settings['plugin_id'])) {
      return '?';
    }
    return $this->idToLabel->idGetLabel($settings['plugin_id']);
  }

  /**
   * @param array $settings
   *
   * @return object
   */
  function settingsGetHandler(array $settings) {
    if (!isset($settings['plugin_id'])) {
      return BrokenUniHandler::createFromMessage('No plugin id in settings.');
    }
    $conf = isset($settings['plugin_options'])
      ? $settings['plugin_options']
      : array();
    return $this->idConfToHandler->idConfGetHandler($settings['plugin_id'], $conf);
  }
}
