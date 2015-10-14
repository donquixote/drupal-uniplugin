<?php

namespace Drupal\uniplugin\DefinitionsByTypeAndId;

class DefinitionsByTypeAndIdDiscovery implements DefinitionsByTypeAndIdInterface {

  /**
   * @var string
   */
  private $hook;

  /**
   * @var array
   */
  private $arguments;

  /**
   * @param string $hook
   * @param array $arguments
   */
  function __construct($hook, $arguments = array()) {
    $this->hook = $hook;
    $this->arguments = $arguments;
  }

  /**
   * @return array[][]
   *   Format: $[$pluginType][$pluginId] = $pluginDefinition
   */
  public function getDefinitionsByTypeAndId() {
    $definitions = array();
    $suffix = '_' . $this->hook;
    foreach (module_implements($this->hook) as $module) {
      foreach ($this->moduleGetDefinitionsByTypeAndId($module, $suffix) as $type => $definitionsById) {
        foreach ($definitionsById as $id => $definition) {
          $definition['module'] = $module;
          $definitions[$type][$module . '.' . $id] = $definition;
        }
      }
    }
    return $definitions;
  }

  /**
   * @param string $module
   * @param string $suffix
   *
   * @return array[]
   */
  private function moduleGetDefinitionsByTypeAndId($module, $suffix) {
    $function = $module . $suffix;
    if (!function_exists($function)) {
      return array();
    }
    $moduleDefinitionsByTypeAndId = call_user_func_array($function, $this->arguments);
    if (!is_array($moduleDefinitionsByTypeAndId)) {
      return array();
    }
    return $moduleDefinitionsByTypeAndId;
  }
}
