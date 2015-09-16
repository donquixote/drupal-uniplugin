<?php

namespace Drupal\uniplugin\DefinitionsById;

class DefinitionsByIdCache implements DefinitionsByIdInterface {

  const CACHE_BIN = 'cache';

  /**
   * @var \Drupal\uniplugin\DefinitionsById\DefinitionsByIdInterface
   */
  private $decorated;

  /**
   * @var string
   */
  private $cid;

  /**
   * @param \Drupal\uniplugin\DefinitionsById\DefinitionsByIdInterface $decorated
   * @param string $cid
   *   Cache id.
   */
  function __construct(DefinitionsByIdInterface $decorated, $cid) {
    $this->decorated = $decorated;
    $this->cid = $cid;
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
    if ($cache = cache_get($this->cid, self::CACHE_BIN)) {
      return $cache->data;
    }
    $definitions = $this->decorated->getDefinitionsById();
    cache_set($this->cid, $definitions, self::CACHE_BIN);
    return $definitions;
  }
}
