<?php

namespace Drupal\uniplugin\DefinitionsById;

use Drupal\uniplugin\TypeToDefinitionsById\TypeToDefinitionsByIdInterface;

class DefinitionsByIdFromType implements DefinitionsByIdInterface {

  /**
   * @var \Drupal\uniplugin\TypeToDefinitionsById\TypeToDefinitionsByIdInterface
   */
  private $typeToDefinitionsById;

  /**
   * @var string
   */
  private $type;

  /**
   * WickedDefinitionsByIdDiscovery constructor.
   *
   * @param \Drupal\uniplugin\TypeToDefinitionsById\TypeToDefinitionsByIdInterface $typeToDefinitionsById
   * @param string $type
   */
  function __construct(TypeToDefinitionsByIdInterface $typeToDefinitionsById, $type) {
    $this->typeToDefinitionsById = $typeToDefinitionsById;
    $this->type = $type;
  }

  /**
   * @return array[]
   *   Array of all plugin definitions for this plugin type.
   */
  function getDefinitionsById() {
    return $this->typeToDefinitionsById->typeGetDefinitionsById($this->type);
  }

}
