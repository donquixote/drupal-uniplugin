<?php

namespace Drupal\uniplugin\IdToPlugin;

interface IdToPluginInterface {

  /**
   * @param string $id
   *
   * @return \Drupal\uniplugin\UniPlugin\Candidate\UniPluginCandidateInterface|null
   */
  function idGetPlugin($id);

}
