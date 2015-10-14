<?php

namespace Drupal\uniplugin\DefinitionsById;

/**
 * Mixes the result from different sources for definitions.
 */
class DefinitionsByIdMixer implements DefinitionsByIdInterface {

  /**
   * @var \Drupal\uniplugin\DefinitionsById\DefinitionsByIdInterface[]
   */
  private $sources = array();

  /**
   * @param \Drupal\uniplugin\DefinitionsById\DefinitionsByIdInterface $source
   *
   * @return $this
   */
  function addSource(DefinitionsByIdInterface $source) {
    $this->sources[] = $source;
    return $this;
  }

  /**
   * @return array[]
   *   Array of all plugin definitions for this plugin type.
   */
  function getDefinitionsById() {
    $definitionsById = array();
    foreach ($this->sources as $source) {
      $definitionsById += $source->getDefinitionsById();
    }
    return $definitionsById;
  }
}
