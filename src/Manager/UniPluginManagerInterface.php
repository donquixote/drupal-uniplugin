<?php

namespace Drupal\uniplugin\Manager;

/**
 * Bundles all relevant outward-facing functionality of a plugin type.
 */
interface UniPluginManagerInterface {

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
   * @return string
   *   A label describing the plugin.
   */
  function settingsGetLabel(array $settings);

  /**
   * @param array $settings
   *   Format: array('plugin_id' => :string, 'plugin_options' => :array)
   *
   * @return object
   *   The handler object for the given plugin id and plugin options.
   *   This needs to be further type-checked before it can be used.
   */
  function settingsGetHandler(array $settings);

}
