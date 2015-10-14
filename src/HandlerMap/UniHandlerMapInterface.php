<?php

namespace Drupal\uniplugin\HandlerMap;

use Drupal\uniplugin\Configurable\UniConfigurableInterface;

interface UniHandlerMapInterface extends UniConfigurableInterface {

  /**
   * @param array $conf
   *
   * @return object
   */
  function confGetHandler(array $conf);
}
