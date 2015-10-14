<?php

namespace Drupal\uniplugin\ContextToHandlerMap;

use Drupal\uniplugin\TypeContext\UniPluginTypeContextInterface;

class ContextToHandlerMapBuffer implements ContextToHandlerMapInterface {

  /**
   * @var \Drupal\uniplugin\ContextToHandlerMap\ContextToHandlerMapInterface
   */
  private $decorated;

  /**
   * @var \Drupal\uniplugin\HandlerMap\UniHandlerMapInterface[]
   */
  private $handlerMaps = array();

  /**
   * ContextToHandlerMapBuffer constructor.
   *
   * @param \Drupal\uniplugin\ContextToHandlerMap\ContextToHandlerMapInterface $decorated
   */
  function __construct(ContextToHandlerMapInterface $decorated) {
    $this->decorated = $decorated;
  }

  /**
   * @param \Drupal\uniplugin\TypeContext\UniPluginTypeContextInterface $context
   *
   * @return \Drupal\uniplugin\HandlerMap\UniHandlerMapInterface
   */
  function contextGetHandlerMap(UniPluginTypeContextInterface $context) {
    $key = $context->getMachineName();
    return array_key_exists($key, $this->handlerMaps)
      ? $this->handlerMaps[$key]
      : $this->handlerMaps[$key] = $this->decorated->contextGetHandlerMap($context);
  }
}
