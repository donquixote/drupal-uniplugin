<?php

namespace Drupal\uniplugin\DefinitionToLabel;

class DefinitionToLabel implements DefinitionToLabelInterface {

  /**
   * @param array $definition
   * @param string|null $else
   *
   * @return string|null
   */
  function definitionGetLabel(array $definition, $else = NULL) {
    return isset($definition['label'])
      ? $definition['label']
      : $else;
  }
}
