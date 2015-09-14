<?php

namespace Drupal\uniplugin\Handler;

use Drupal\uniplugin\UniPlugin\UniPluginInterface;

class BrokenUniHandler implements BrokenUniHandlerInterface {

  /**
   * @var string
   */
  private $message;

  /**
   * @var string|null
   */
  private $pluginId;

  /**
   * @var array
   */
  private $pluginDefinition;

  /**
   * @var \Drupal\uniplugin\UniPlugin\UniPluginInterface|null
   */
  private $plugin;

  /**
   * @var array|null
   */
  private $pluginConfiguration;

  /**
   * @var \Exception|null
   */
  private $exception;

  /**
   * @var mixed|null
   */
  private $nonObjectHandler;

  /**
   * @param string $message
   * @param string[] $replacements
   *
   * @return static
   */
  static function createFromMessage($message, array $replacements = array()) {
    $message = format_string($message, $replacements);
    return new static($message);
  }

  /**
   * @param string $message
   *   Message explaining why the real handler could not be created.
   */
  function __construct($message) {
    $this->message = $message;
  }

  /**
   * @param null|string $pluginId
   *
   * @return $this
   */
  function setPluginId($pluginId) {
    $this->pluginId = $pluginId;
    return $this;
  }

  /**
   * @param \Drupal\uniplugin\UniPlugin\UniPluginInterface $plugin
   *
   * @return $this
   */
  function setPlugin(UniPluginInterface $plugin) {
    $this->plugin = $plugin;
    return $this;
  }

  /**
   * @param array|null $pluginConfiguration
   *
   * @return $this
   */
  function setPluginConfiguration($pluginConfiguration) {
    $this->pluginConfiguration = $pluginConfiguration;
    return $this;
  }

  /**
   * @param \Exception $exception
   *
   * @return $this
   */
  function setException(\Exception $exception) {
    $this->exception = $exception;
    return $this;
  }

  /**
   * @param mixed|null $nonObjectHandler
   *
   * @return $this
   */
  function setNonObjectHandler($nonObjectHandler) {
    $this->nonObjectHandler = $nonObjectHandler;
    return $this;
  }

  /**
   * @return string
   */
  function getMessage() {
    return $this->message;
  }

  /**
   * @return null|string
   */
  function getPluginId() {
    return $this->pluginId;
  }

  /**
   * @return array
   */
  public function getPluginDefinition() {
    return $this->pluginDefinition;
  }

  /**
   * @return \Drupal\uniplugin\UniPlugin\UniPluginInterface|null
   */
  function getPlugin() {
    return $this->plugin;
  }

  /**
   * @return array|null
   */
  function getPluginConfiguration() {
    return $this->pluginConfiguration;
  }

  /**
   * @return \Exception|null
   */
  function getException() {
    return $this->exception;
  }

  /**
   * @return mixed|null
   */
  function getNonObjectHandler() {
    return $this->nonObjectHandler;
  }

  /**
   * @param array $pluginDefinition
   *
   * @return BrokenUniHandler
   */
  public function setPluginDefinition($pluginDefinition) {
    $this->pluginDefinition = $pluginDefinition;
    return $this;
  }

}
