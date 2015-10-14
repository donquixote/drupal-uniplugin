<?php

namespace Drupal\uniplugin\UniPlugin;

use Drupal\uniplugin\Configurable\UniConfigurableInterface;

interface ConfigurableUniPluginInterface extends UniPluginInterface, UniConfigurableInterface {

  /**
   * @param array $conf
   *   Plugin configuration.
   * @param string $pluginLabel
   *   Label from the plugin definition.
   *
   * @return string|null
   */
  function confGetSummary(array $conf, $pluginLabel = NULL);

}
