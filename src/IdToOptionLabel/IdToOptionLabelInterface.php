<?php

namespace Drupal\uniplugin\IdToOptionLabel;

interface IdToOptionLabelInterface {

  /**
   * @param string $id
   *
   * @return string|null
   */
  function idGetOptionLabel($id);

}
