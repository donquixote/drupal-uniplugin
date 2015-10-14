<?php

namespace Drupal\uniplugin\Manager;

use Drupal\uniplugin\HandlerMap\UniHandlerMapInterface;

trait UniHandlerMapDecoratorTrait {

  /**
   * @var \Drupal\uniplugin\HandlerMap\UniHandlerMapInterface
   */
  private $handlerMap;

  /**
   * EntdispManager constructor.
   *
   * @param \Drupal\uniplugin\HandlerMap\UniHandlerMapInterface $handlerMap
   */
  function __construct(UniHandlerMapInterface $handlerMap) {
    $this->handlerMap = $handlerMap;
  }

  /**
   * @param array $conf
   *
   * @return array
   */
  function confGetForm(array $conf) {
    return $this->handlerMap->confGetForm($conf);
  }

  /**
   * @param array $conf
   *
   * @return string
   */
  function confGetSummary(array $conf) {
    return $this->handlerMap->confGetSummary($conf);
  }

}
