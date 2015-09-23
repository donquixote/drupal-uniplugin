<?php

namespace Drupal\uniplugin\TypeToDefinitionsById;

interface TypeToDefinitionsByIdInterface {

  /**
   * @param string $type
   *   The plugin type.
   *
   * @return array[]
   *   Format: $[$pluginId] = $pluginDefinition
   */
  public function typeGetDefinitionsById($type);

}
