<?php

namespace Drupal\uniplugin\UniPlugin;

interface ConfigurableUniPluginInterface extends UniPluginInterface {

  /**
   * Builds a settings form for the plugin configuration.
   *
   * @param array $conf
   *   Current configuration. Will be empty if not configured yet.
   *
   * @return array
   *
   * @see \views_handler::options_form()
   */
  function settingsForm(array $conf);

  /**
   * Validation callback for the settings form.
   *
   * @param array $conf
   * @param array $form
   * @param array $form_state
   *
   * @see \views_handler::options_validate()
   */
  function settingsFormValidate(array $conf, array &$form, array &$form_state);

  /**
   * @param array $conf
   *   Plugin configuration.
   * @param string $pluginLabel
   *   Label from the plugin definition.
   *
   * @return string|null
   */
  function confGetSummary(array $conf, $pluginLabel);

}
