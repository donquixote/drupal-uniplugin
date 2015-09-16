<?php

namespace Drupal\uniplugin\DefinitionToLabel;

class DefinitionToLabel implements DefinitionToLabelInterface {

  /**
   * @param array $definition
   * @param string $else
   *
   * @return string
   */
  function definitionGetLabel(array $definition, $else) {
    return isset($definition['label'])
      ? $definition['label']
      : $else;
  }
}
