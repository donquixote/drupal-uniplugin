<?php
namespace Drupal\uniplugin\Handler;

interface BrokenUniHandlerInterface {

  /**
   * @return string
   */
  function getMessage();

  /**
   * @return null|string
   */
  function getPluginId();

  /**
   * @return array
   */
  function getPluginDefinition();

  /**
   * @return \Drupal\uniplugin\UniPlugin\UniPluginInterface|null
   */
  function getPlugin();

  /**
   * @return array|null
   */
  function getPluginConfiguration();

  /**
   * @return \Exception|null
   */
  function getException();

  /**
   * @return mixed|null
   */
  function getNonObjectHandler();

}
