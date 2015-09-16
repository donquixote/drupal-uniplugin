<?php

namespace Drupal\uniplugin\IdToLabel;

interface IdToLabelInterface {

  /**
   * @param string $id
   *
   * @return string
   */
  function idGetLabel($id);

}
