<?php

namespace Drupal\uniplugin\PluginTypeDIC;

use Drupal\uniplugin\DefinitionsById\DefinitionsByIdBuffer;
use Drupal\uniplugin\DefinitionToLabel\DefinitionToLabel;
use Drupal\uniplugin\DefinitionToPlugin\DefinitionToPluginChain;
use Drupal\uniplugin\DIC\ServiceContainerBase;
use Drupal\uniplugin\Manager\UniPluginManager;
use Drupal\uniplugin\IdToLabel\IdToLabel;
use Drupal\uniplugin\IdToLabel\IdToLabelBuffer;
use Drupal\uniplugin\LabelsByModuleAndId\LabelsByModuleAndId;
use Drupal\uniplugin\Uikit\UniPluginUikitElementType;
use Drupal\uniplugin\IdConfToHandler\IdConfToHandler;
use Drupal\uniplugin\IdToPlugin\IdToPluginBuffer;
use Drupal\uniplugin\IdToPlugin\IdToPlugin;
use Drupal\uniplugin\PluginConfToHandler\PluginConfToHandler;

/**
 * @property \Drupal\uniplugin\IdConfToHandler\IdConfToHandlerInterface $idConfToHandler
 *   Gets a handler object for a given plugin id + configuration.
 *
 * @property \Drupal\uniplugin\IdToPlugin\IdToPluginInterface $idToPlugin
 *   Gets the plugin object for a given plugin id.
 *
 * @property \Drupal\uniplugin\PluginConfToHandler\PluginConfToHandlerInterface $pluginConfToHandler
 *   Gets a handler object from a plugin object + configuration.
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
 * @property \Drupal\uniplugin\DefinitionsById\PluginDefinitionBufferInterface $definitionBuffer
 *   Gets plugin definition from plugin id.
 *
 * @property \Drupal\uniplugin\DefinitionToLabel\DefinitionToLabelInterface $definitionToLabel
 *   Gets plugin label from plugin definition and id.
 *
 * @property \Drupal\uniplugin\DefinitionsById\DefinitionsByIdDiscovery $pluginDefinitionDiscovery
 *   Discovers the available plugin ids with their definitions for this plugin type.
 *
 * @property \Drupal\uikit\FormElement\UikitElementTypeInterface $uikitElementType
 *   A form element object, to choose a plugin from this type.
 *
 * @property \Drupal\uniplugin\Manager\UniPluginManagerInterface $manager
 *   Not sure what this does..
 *
 * @property \Drupal\uniplugin\DefinitionToPlugin\DefinitionToPluginInterface $definitionToPlugin
 *   Gets a plugin object from a plugin definition.
 */
abstract class PluginTypeServiceContainerBase extends ServiceContainerBase {

  /**
   * @return \Drupal\uniplugin\IdConfToHandler\IdConfToHandlerInterface
   *
   * @see \Drupal\uniplugin\PluginTypeDIC\PluginTypeServiceContainerBase::idConfToHandler
   */
  protected function get_idConfToHandler() {
    return new IdConfToHandler($this->idToPlugin, $this->pluginConfToHandler);
  }

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
   * @return \Drupal\uniplugin\PluginConfToHandler\PluginConfToHandler
   *
   * @see \Drupal\uniplugin\PluginTypeDIC\PluginTypeServiceContainerBase::pluginConfToHandler
   */
  protected function get_pluginConfToHandler() {
    return new PluginConfToHandler();
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
    return new LabelsByModuleAndId($this->definitionsById, $this->definitionToLabel);
  }

  /**
   * @return \Drupal\uniplugin\DefinitionsById\DefinitionsByIdInterface
   *
   * @see \Drupal\uniplugin\PluginTypeDIC\PluginTypeServiceContainerBase::definitionsById
   */
  protected function get_definitionsById() {
    return $this->definitionBuffer;
  }

  /**
   * @return \Drupal\uniplugin\IdToDefinition\IdToDefinitionInterface
   *
   * @see \Drupal\uniplugin\PluginTypeDIC\PluginTypeServiceContainerBase::idToDefinition
   */
  protected function get_idToDefinition() {
    return $this->definitionBuffer;
  }

  /**
   * @return \Drupal\uniplugin\DefinitionsById\PluginDefinitionBufferInterface
   *
   * @see \Drupal\uniplugin\PluginTypeDIC\PluginTypeServiceContainerBase::definitionBuffer
   */
  protected function get_definitionBuffer() {
    // @todo Add a cache, maybe?
    return new DefinitionsByIdBuffer($this->pluginDefinitionDiscovery);
  }

  /**
   * @return \Drupal\uniplugin\DefinitionToLabel\DefinitionToLabelInterface
   *
   * @see \Drupal\uniplugin\PluginTypeDIC\PluginTypeServiceContainerBase::definitionToLabel
   */
  protected function get_definitionToLabel() {
    return new DefinitionToLabel($this->definitionToPlugin);
  }

  /**
   * @return \Drupal\uikit\FormElement\UikitElementTypeInterface
   *
   * @see \Drupal\uniplugin\PluginTypeDIC\PluginTypeServiceContainerBase::uikitElementType
   */
  protected function get_uikitElementType() {
    return new UniPluginUikitElementType($this->labelsByModuleAndId, $this->idToPlugin);
  }

  /**
   * @return \Drupal\uniplugin\Manager\UniPluginManagerInterface
   *
   * @see \Drupal\uniplugin\PluginTypeDIC\PluginTypeServiceContainerBase::manager
   */
  protected function get_manager() {
    return new UniPluginManager($this->uikitElementType, $this->idConfToHandler, $this->idToLabel);
  }

  /**
   * @return \Drupal\uniplugin\DefinitionToPlugin\DefinitionToPluginInterface
   *
   * @see \Drupal\uniplugin\PluginTypeDIC\PluginTypeServiceContainerBase::definitionToPlugin
   */
  protected function get_definitionToPlugin() {
    return DefinitionToPluginChain::createDefault();
  }

  /**
   * @return \Drupal\uniplugin\DefinitionsById\DefinitionsByIdDiscovery
   *
   * @see \Drupal\uniplugin\PluginTypeDIC\PluginTypeServiceContainerBase::pluginDefinitionDiscovery
   */
  abstract protected function get_pluginDefinitionDiscovery();

}