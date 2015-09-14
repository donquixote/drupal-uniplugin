<?php

namespace Drupal\uniplugin\IdToPlugin;

interface IdToPluginInterface {

  /**
   * @param string $plugin_id
   *
   * @return \Drupal\uniplugin\UniPlugin\UniPluginInterface|null
   */
  function idGetPlugin($plugin_id);

}
