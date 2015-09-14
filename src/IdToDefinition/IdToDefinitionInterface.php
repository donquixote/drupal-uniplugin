<?php

namespace Drupal\uniplugin\IdToDefinition;

interface IdToDefinitionInterface {

  /**
   * @param string $id
   *
   * @return array|null
   */
  function idGetDefinition($id);

}
