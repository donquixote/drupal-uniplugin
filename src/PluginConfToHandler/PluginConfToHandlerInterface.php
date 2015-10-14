<?php

namespace Drupal\uniplugin\PluginConfToHandler;

use Drupal\uniplugin\UniPlugin\Candidate\UniPluginCandidateInterface;

interface PluginConfToHandlerInterface {

  /**
   * @param \Drupal\uniplugin\UniPlugin\Candidate\UniPluginCandidateInterface $plugin
   * @param array $conf
   *
   * @return object
   */
  function pluginConfGetHandler(UniPluginCandidateInterface $plugin, array $conf);

}
