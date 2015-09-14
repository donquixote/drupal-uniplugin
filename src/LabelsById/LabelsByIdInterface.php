<?php

namespace Drupal\uniplugin\LabelsById;

interface LabelsByIdInterface {

  /**
   * @return string[]
   *   Format: $[$plugin_id] = $label
   */
  function getLabelsById();
}
