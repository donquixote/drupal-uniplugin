<?php

namespace Drupal\uniplugin\UniPlugin\OptionHandler;

interface OptionHandlerInterface {

  /**
   * Builds the argument value to use at the position represented by this
   * handler.
   *
   * @param mixed $setting
   *   Setting value from configuration.
   *
   * @return mixed
   */
  function settingBuildArgument($setting);

  /**
   * @param mixed $setting
   *   Setting value from configuration.
   *
   * @return string
   */
  function settingBuildSummary($setting);

  /**
   * @param mixed $setting
   *   Setting value from configuration.
   *
   * @return array
   *   A form element(s) array.
   */
  function settingBuildForm($setting);
}
