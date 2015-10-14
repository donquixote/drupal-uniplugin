<?php

namespace Drupal\uniplugin\TypeContext;

interface UniPluginTypeContextInterface {

  /**
   * @param string $paramName
   *
   * @return bool
   */
  function paramNameHasValue($paramName);

  /**
   * @param $paramName
   *
   * @return mixed
   */
  function paramNameGetValue($paramName);

  /**
   * @return string
   */
  function getMachineName();

}
