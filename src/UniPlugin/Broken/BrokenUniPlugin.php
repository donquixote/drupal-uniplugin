<?php

namespace Drupal\uniplugin\UniPlugin\Broken;

use Drupal\uniplugin\Handler\BrokenUniHandler;

/**
 * Plugin to return if the plugin definition was invalid.
 */
class BrokenUniPlugin implements BrokenUniPluginInterface {

  /**
   * @var string
   */
  private $message;

  /**
   * @var string|null
   */
  private $pluginId;

  /**
   * @var array|null
   */
  private $pluginDefinition;

  /**
   * @var \Exception|null
   */
  private $exception;

  /**
   * @var mixed|null
   */
  private $invalidPlugin;

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
   *   Message explaining what is wrong with the plugin definition.
   */
  function __construct($message) {
    $this->message = $message;
  }

  /**
   * @param null|string $pluginId
   *
   * @return BrokenUniPlugin
   */
  function setPluginId($pluginId) {
    $this->pluginId = $pluginId;
    return $this;
  }

  /**
   * @param array $pluginDefinition
   *
   * @return BrokenUniPlugin
   */
  function setPluginDefinition($pluginDefinition) {
    $this->pluginDefinition = $pluginDefinition;
    return $this;
  }

  /**
   * @param \Exception|null $exception
   *
   * @return BrokenUniPlugin
   */
  function setException($exception) {
    $this->exception = $exception;
    return $this;
  }

  /**
   * @param mixed|null $invalidPlugin
   *
   * @return BrokenUniPlugin
   */
  function setInvalidPlugin($invalidPlugin) {
    $this->invalidPlugin = $invalidPlugin;
    return $this;
  }

  /**
   * Gets the message explaining why the plugin definition is invalid.
   *
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
  function getPluginDefinition() {
    return $this->pluginDefinition;
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
  function getInvalidPlugin() {
    return $this->invalidPlugin;
  }

  /**
   * Gets a handler object that does the business logic.
   *
   * @param array $configuration
   *   Configuration for the handler object creation, if this plugin is
   *   configurable.
   *
   * @return object|null
   *   The handler object, or NULL.
   *   Plugins should return handlers of a specific type, but they are not
   *   technically required to do this. This is why an additional check should
   *   be performed for everything returned from a plugin.
   */
  function confGetHandler(array $configuration = NULL) {
    return BrokenUniHandler::createFromMessage('Handler from invalid plugin.')
      ->setPluginId($this->pluginId)
      ->setPluginDefinition($this->pluginDefinition)
      ->setPlugin($this);
  }

}
