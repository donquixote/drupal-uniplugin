<?php

namespace Drupal\uniplugin\DefinitionToPlugin;

interface DefinitionToPluginInterface {

  /**
   * Gets the handler object, or a fallback object for broken / missing handler.
   *
   * @param array $definition
   *
   * @return \Drupal\uniplugin\UniPlugin\UniPluginInterface
   */
  function definitionGetPlugin(array $definition);

}
