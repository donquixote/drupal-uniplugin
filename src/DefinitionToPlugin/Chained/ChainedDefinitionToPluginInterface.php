<?php

namespace Drupal\uniplugin\DefinitionToPlugin\Chained;

interface ChainedDefinitionToPluginInterface {

  /**
   * @param mixed $arg
   * @param array $definition
   *
   * @return \Drupal\uniplugin\UniPlugin\UniPluginInterface
   */
  function argDefinitionGetPlugin($arg, array $definition);
}
