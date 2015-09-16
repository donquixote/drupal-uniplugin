<?php

namespace Drupal\uniplugin\DefinitionsById;

/**
 * Buffers the plugins for a specific
 */
class DefinitionsByIdBuffer implements DefinitionsByIdMapInterface {

  /**
   * @var array[]|null
   */
  private $definitions;

  /**
   * @var \Drupal\uniplugin\DefinitionsById\DefinitionsByIdInterface
   */
  private $decorated;

  /**
   * @param \Drupal\uniplugin\DefinitionsById\DefinitionsByIdInterface $decorated
   */
  function __construct(DefinitionsByIdInterface $decorated) {
    $this->decorated = $decorated;
  }

  /**
   * @param string $id
   *
   * @return array|null
   */
  function idGetDefinition($id) {
    $definitions = $this->getDefinitionsById();
    return isset($definitions[$id])
      ? $definitions[$id]
      : NULL;
  }

  /**
   * @return array[]
   *   Array of all plugin definitions for this plugin type.
   */
  function getDefinitionsById() {
    return isset($this->definitions)
      ? $this->definitions
      : $this->definitions = $this->decorated->getDefinitionsById();
  }
}
