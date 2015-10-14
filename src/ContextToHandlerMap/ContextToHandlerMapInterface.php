<?php

namespace Drupal\uniplugin\ContextToHandlerMap;

use Drupal\uniplugin\TypeContext\UniPluginTypeContextInterface;

interface ContextToHandlerMapInterface {

  /**
   * @param \Drupal\uniplugin\TypeContext\UniPluginTypeContextInterface $context
   *
   * @return \Drupal\uniplugin\HandlerMap\UniHandlerMapInterface
   */
  function contextGetHandlerMap(UniPluginTypeContextInterface $context);

}
