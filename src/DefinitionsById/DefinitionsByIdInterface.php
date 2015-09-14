<?php

namespace Drupal\uniplugin\DefinitionsById;

interface DefinitionsByIdInterface {

  /**
   * @return array[]
   *   Array of all plugin definitions for this plugin type.
   */
  function getDefinitionsById();

}
