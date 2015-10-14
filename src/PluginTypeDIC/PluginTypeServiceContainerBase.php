<?php

namespace Drupal\uniplugin\PluginTypeDIC;

use Drupal\uniplugin\ContextToHandlerMap\ContextToHandlerMap;
use Drupal\uniplugin\DefinitionsById\DefinitionsByIdBuffer;
use Drupal\uniplugin\DefinitionToLabel\DefinitionToLabel;
use Drupal\uniplugin\DefinitionToPlugin\DefinitionToPlugin;
use Drupal\uniplugin\DIC\ServiceContainerBase;
use Drupal\uniplugin\HandlerMap\UniHandlerMap;
use Drupal\uniplugin\IdToLabel\IdToLabel;
use Drupal\uniplugin\IdToLabel\IdToLabelBuffer;
use Drupal\uniplugin\LabelsByModuleAndId\LabelsByModuleAndId;
use Drupal\uniplugin\IdToPlugin\IdToPluginBuffer;
use Drupal\uniplugin\IdToPlugin\IdToPlugin;

/**
 * @property \Drupal\uniplugin\IdToPlugin\IdToPluginInterface $idToPlugin
 *   Gets the plugin object for a given plugin id.
 *
 * @property \Drupal\uniplugin\IdToLabel\IdToLabelInterface $idToLabel
 *   Gets a label from a plugin id.
 *
 * @property \Drupal\uniplugin\LabelsByModuleAndId\LabelsByModuleAndIdInterface $labelsByModuleAndId
 *   Gets available plugin labels by module and plugin id.
 *
 * @property \Drupal\uniplugin\DefinitionsById\DefinitionsByIdInterface $definitionsById
 *   Gets all available definitions by id.
 *
 * @property \Drupal\uniplugin\IdToDefinition\IdToDefinitionInterface $idToDefinition
 *   Gets a plugin definition from a plugin id.
 *
 * @property \Drupal\uniplugin\DefinitionsById\DefinitionsByIdMapInterface $definitionsByIdMap
 *   Gets plugin definition from plugin id.
 *
 * @property \Drupal\uniplugin\DefinitionToLabel\DefinitionToLabelInterface $definitionToLabel
 *   Gets plugin label from plugin definition and id.
 *
 * @property \Drupal\uniplugin\DefinitionsById\DefinitionsByIdInterface $pluginDefinitionDiscovery
 *   Discovers the available plugin ids with their definitions for this plugin type.
 *
 * @property \Drupal\uniplugin\DefinitionToPlugin\DefinitionToPluginInterface $definitionToPlugin
 *   Gets a plugin object from a plugin definition.
 *
 * @property \Drupal\uniplugin\HandlerMap\UniHandlerMapInterface $handlerMap
 *   A handler map for the plugin type without context.
 *
 * @property \Drupal\uniplugin\ContextToHandlerMap\ContextToHandlerMapInterface $contextToHandlerMap
 *   Gets a handler map for a plugin type context.
 */
abstract class PluginTypeServiceContainerBase extends ServiceContainerBase {

  /**
   * @return \Drupal\uniplugin\IdToPlugin\IdToPluginInterface
   *
   * @see PluginTypeServiceContainerBase::idToPlugin
   */
  protected function get_idToPlugin() {
    $idToPlugin = new IdToPlugin($this->idToDefinition, $this->definitionToPlugin);
    return new IdToPluginBuffer($idToPlugin);
  }

  /**
   * @return \Drupal\uniplugin\IdToLabel\IdToLabelInterface
   *
   * @see \Drupal\uniplugin\PluginTypeDIC\PluginTypeServiceContainerBase::idToLabel
   */
  protected function get_idToLabel() {
    $idToLabel = new IdToLabel($this->idToDefinition, $this->definitionToLabel);
    return new IdToLabelBuffer($idToLabel);
  }

  /**
   * @return \Drupal\uniplugin\LabelsByModuleAndId\LabelsByModuleAndIdInterface
   *
   * @see \Drupal\uniplugin\PluginTypeDIC\PluginTypeServiceContainerBase::labelsByModuleAndId
   */
  protected function get_labelsByModuleAndId() {
    return new LabelsByModuleAndId($this->definitionsById, $this->idToLabel);
  }

  /**
   * @return \Drupal\uniplugin\DefinitionsById\DefinitionsByIdInterface
   *
   * @see \Drupal\uniplugin\PluginTypeDIC\PluginTypeServiceContainerBase::definitionsById
   */
  protected function get_definitionsById() {
    return $this->definitionsByIdMap;
  }

  /**
   * @return \Drupal\uniplugin\IdToDefinition\IdToDefinitionInterface
   *
   * @see \Drupal\uniplugin\PluginTypeDIC\PluginTypeServiceContainerBase::idToDefinition
   */
  protected function get_idToDefinition() {
    return $this->definitionsByIdMap;
  }

  /**
   * @return \Drupal\uniplugin\DefinitionsById\DefinitionsByIdMapInterface
   *
   * @see \Drupal\uniplugin\PluginTypeDIC\PluginTypeServiceContainerBase::definitionsByIdMap
   */
  protected function get_definitionsByIdMap() {
    return new DefinitionsByIdBuffer($this->pluginDefinitionDiscovery);
  }

  /**
   * @return \Drupal\uniplugin\DefinitionToLabel\DefinitionToLabelInterface
   *
   * @see \Drupal\uniplugin\PluginTypeDIC\PluginTypeServiceContainerBase::definitionToLabel
   */
  protected function get_definitionToLabel() {
    return new DefinitionToLabel();
  }

  /**
   * @return \Drupal\uniplugin\DefinitionToPlugin\DefinitionToPluginInterface
   *
   * @see \Drupal\uniplugin\PluginTypeDIC\PluginTypeServiceContainerBase::definitionToPlugin
   */
  protected function get_definitionToPlugin() {
    return DefinitionToPlugin::createDefault();
  }

  /**
   * @return \Drupal\uniplugin\HandlerMap\UniHandlerMapInterface
   *
   * @see \Drupal\uniplugin\PluginTypeDIC\PluginTypeServiceContainerBase::$handlerMap
   */
  protected function get_handlerMap() {
    return new UniHandlerMap($this->idToPlugin, $this->labelsByModuleAndId, $this->idToLabel);
  }

  /**
   * @return \Drupal\uniplugin\ContextToHandlerMap\ContextToHandlerMapInterface
   *
   * @see \Drupal\uniplugin\PluginTypeDIC\PluginTypeServiceContainerBase::$contextToHandlerMap
   */
  protected function get_contextToHandlerMap() {
    return new ContextToHandlerMap($this->idToPlugin, $this->labelsByModuleAndId, $this->idToLabel);
  }

  /**
   * @return \Drupal\uniplugin\DefinitionsById\DefinitionsByIdInterface
   *
   * @see \Drupal\uniplugin\PluginTypeDIC\PluginTypeServiceContainerBase::pluginDefinitionDiscovery
   */
  abstract protected function get_pluginDefinitionDiscovery();

}
