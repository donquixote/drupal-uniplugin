<?php

namespace Drupal\uniplugin\UniPlugin\OptionHandler;

use Drupal\uniplugin\HandlerMap\UniHandlerMapInterface;

class PluginTypeOptionHandler implements OptionHandlerInterface {

  /**
   * @var \Drupal\uniplugin\HandlerMap\UniHandlerMapInterface
   */
  private $manager;

  /**
   * @var string
   */
  private $label;

  /**
   * PluginTypeOptionHandler constructor.
   *
   * @param \Drupal\uniplugin\HandlerMap\UniHandlerMapInterface $handlerMap
   * @param string $label
   */
  function __construct(UniHandlerMapInterface $handlerMap, $label) {
    $this->manager = $handlerMap;
    $this->label = $label;
  }

  /**
   * @param mixed $setting
   *
   * @return mixed
   */
  function settingBuildForm($setting) {
    if (!is_array($setting)) {
      $setting = array();
    }
    $form = $this->manager->confGetForm($setting);
    $form['#title'] = $this->label;
    return $form;
  }

  /**
   * @param mixed $setting
   *
   * @return string
   */
  function settingBuildSummary($setting) {
    if (!is_array($setting)) {
      return $this->label . ': ' . t('Invalid setting.');
    }
    return $this->label . ': ' . $this->manager->confGetSummary($setting);
  }

  /**
   * @param mixed $setting
   *
   * @return mixed
   */
  function settingBuildArgument($setting) {
    if (!is_array($setting)) {
      return NULL;
    }
    return $this->manager->confGetHandler($setting);
  }
}
