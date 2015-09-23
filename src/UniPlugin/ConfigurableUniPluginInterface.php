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
   *   A sub-form array to configure the plugin.
   *
   * @see \views_handler::options_form()
   */
  function settingsForm(array $conf);

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
