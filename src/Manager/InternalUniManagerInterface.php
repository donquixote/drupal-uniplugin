<?php

namespace Drupal\uniplugin\Manager;

/**
 * Bundles all relevant outward-facing functionality of a plugin type.
 */
interface InternalUniManagerInterface {

  /**
   * Gets the element type object to be used in a uikit form element, that
   * allows to choose and configure a plugin of this type.
   *
   * @param string|null $defaultTitle
   *   (optional) Title to give to the element, if it does not have one already.
   *
   * @return \Drupal\uikit\FormElement\UikitElementTypeInterface
   */
  function getUikitElementType($defaultTitle = NULL);

  /**
   * @param array $settings
   *   Format: array('plugin_id' => :string, 'plugin_options' => :array)
   *
   * @return string
   */
  function settingsGetSummary(array $settings);

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
