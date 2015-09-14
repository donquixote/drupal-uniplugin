<?php

namespace Drupal\uniplugin\LabelsByModuleAndId;

interface LabelsByModuleAndIdInterface {

  /**
   * @return string[][]
   *   Format: $[$module][$plugin_id] = $label
   */
  function getLabelsByModuleAndId();
}
