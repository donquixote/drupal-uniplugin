<?php

namespace Drupal\uniplugin\Manager;

interface UniPluginManagerBaseInterface {

  /**
   * Gets the element type object to be used in a uikit form element, that
   * allows to choose and configure a plugin of this type.
   *
   * @return \Drupal\uikit\FormElement\UikitElementTypeInterface
   */
  function getUikitElementType();

  /**
   * @param array $settings
   *   Format: array('plugin_id' => :string, 'plugin_options' => :array)
   *
   * @return string|null
   */
  function settingsGetSummary(array $settings);

}
