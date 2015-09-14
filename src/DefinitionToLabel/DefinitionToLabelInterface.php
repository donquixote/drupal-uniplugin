<?php

namespace Drupal\uniplugin\DefinitionToLabel;

interface DefinitionToLabelInterface {

  /**
   * @param array $definition
   * @param string|null $else
   *
   * @return string|null
   */
  function definitionGetLabel(array $definition, $else = NULL);

}
