<?php

namespace Drupal\uniplugin\IdToLabel;

interface IdToLabelInterface {

  /**
   * @param string $id
   *
   * @return string|null
   */
  function idGetLabel($id);

}
