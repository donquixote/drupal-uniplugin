<?php

namespace Drupal\uniplugin\IdConfToSummary;

interface IdConfToSummaryInterface {

  /**
   * @param string $id
   * @param array $conf
   *
   * @return string|null
   */
  function idConfGetSummary($id, array $conf);
}
