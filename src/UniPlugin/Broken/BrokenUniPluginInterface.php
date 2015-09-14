<?php
namespace Drupal\uniplugin\UniPlugin\Broken;

use Drupal\uniplugin\UniPlugin\UniPluginInterface;

/**
 * Plugin to return if the plugin definition was invalid.
 */
interface BrokenUniPluginInterface extends UniPluginInterface {

  /**
   * Gets the message explaining why the plugin definition is invalid.
   *
   * @return string
   */
  function getMessage();

  /**
   * @return null|string
   */
  function getPluginId();

  /**
   * Gets the invalid plugin definition.
   *
   * @return array
   */
  function getPluginDefinition();

  /**
   * @return \Exception|null
   */
  function getException();

  /**
   * @return mixed|null
   */
  function getInvalidPlugin();
}
