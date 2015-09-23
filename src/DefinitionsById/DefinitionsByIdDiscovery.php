<?php

namespace Drupal\uniplugin\DefinitionsById;

class DefinitionsByIdDiscovery implements DefinitionsByIdInterface {

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
   * @return array[]
   *   Array of all plugin definitions for this plugin type.
   */
  function getDefinitionsById() {
    $definitions = array();
    $suffix = '_' . $this->hook;
    foreach (module_implements($this->hook) as $module) {
      $definitions += $this->moduleGetDefinitions($module, $suffix);
    }
    return $definitions;
  }

  /**
   * @param string $module
   * @param string $suffix
   *
   * @return array[]
   */
  private function moduleGetDefinitions($module, $suffix) {
    $function = $module . $suffix;
    if (!function_exists($function)) {
      return array();
    }
    $module_definitions = call_user_func_array($function, $this->arguments);
    if (!is_array($module_definitions)) {
      return array();
    }
    $definitions = array();
    foreach ($module_definitions as $id => $definition) {
      $definition['module'] = $module;
      $definitions[$module . '.' . $id] = $definition;
    }
    return $definitions;
  }

}
