<?php

namespace Drupal\uniplugin\Configurable;

interface UniConfigurableInterface {

  /**
   * @param array $conf
   *
   * @return array
   */
  function confGetForm(array $conf);

  /**
   * @param array $conf
   *
   * @return string
   */
  function confGetSummary(array $conf);

}
