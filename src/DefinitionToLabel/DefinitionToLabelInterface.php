<?php

namespace Drupal\uniplugin\DefinitionToLabel;

interface DefinitionToLabelInterface {

  /**
   * @param array $definition
   * @param string $else
   *
   * @return string
   */
  function definitionGetLabel(array $definition, $else);

}
