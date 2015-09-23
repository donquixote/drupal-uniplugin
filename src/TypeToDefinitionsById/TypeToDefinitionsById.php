<?php

namespace Drupal\uniplugin\TypeToDefinitionsById;

use Drupal\uniplugin\DefinitionsByTypeAndId\DefinitionsByTypeAndIdInterface;

class TypeToDefinitionsById implements TypeToDefinitionsByIdInterface {

  /**
   * @var \Drupal\uniplugin\DefinitionsByTypeAndId\DefinitionsByTypeAndIdInterface
   */
  private $definitionsByTypeAndId;

  /**
   * @var array[][]|null
   */
  private $buffer;

  /**
   * TypeToDefinitionsById constructor.
   *
   * @param \Drupal\uniplugin\DefinitionsByTypeAndId\DefinitionsByTypeAndIdInterface $definitionsByTypeAndId
   */
  function __construct(DefinitionsByTypeAndIdInterface $definitionsByTypeAndId) {
    $this->definitionsByTypeAndId = $definitionsByTypeAndId;
  }

  /**
   * @param string $type
   *   The plugin type.
   *
   * @return array[]
   *   Format: $[$pluginId] = $pluginDefinition
   */
  public function typeGetDefinitionsById($type) {
    if (NULL === $this->buffer) {
      $this->buffer = $this->definitionsByTypeAndId->getDefinitionsByTypeAndId();
    }
    return isset($this->buffer[$type])
      ? $this->buffer[$type]
      : array();
  }

}
