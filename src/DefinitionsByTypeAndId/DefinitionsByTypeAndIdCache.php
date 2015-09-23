<?php

namespace Drupal\uniplugin\DefinitionsByTypeAndId;

class DefinitionsByTypeAndIdCache implements DefinitionsByTypeAndIdInterface {

  const CACHE_BIN = 'cache';

  /**
   * @var \Drupal\uniplugin\DefinitionsByTypeAndId\DefinitionsByTypeAndIdInterface
   */
  private $decorated;

  /**
   * @var string
   */
  private $cid;

  /**
   * DefinitionsByTypeAndIdBuffer constructor.
   *
   * @param \Drupal\uniplugin\DefinitionsByTypeAndId\DefinitionsByTypeAndIdInterface $decorated
   * @param string $cid
   */
  function __construct(DefinitionsByTypeAndIdInterface $decorated, $cid) {
    $this->decorated = $decorated;
    $this->cid = $cid;
  }

  /**
   * @return array[][]
   */
  public function getDefinitionsByTypeAndId() {
    if ($cache = cache_get($this->cid, self::CACHE_BIN)) {
      return $cache->data;
    }
    $definitions = $this->decorated->getDefinitionsByTypeAndId();
    cache_set($this->cid, $definitions, self::CACHE_BIN);
    return $definitions;
  }
}
