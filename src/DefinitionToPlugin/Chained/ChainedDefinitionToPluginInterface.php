<?php

namespace Drupal\uniplugin\DefinitionToPlugin\Chained;

interface ChainedDefinitionToPluginInterface {

  /**
   * @param mixed $arg
   * @param array $definition
   *
   * @return null|\Drupal\uniplugin\UniPlugin\Candidate\UniPluginCandidateInterface
   */
  function argDefinitionGetPlugin($arg, array $definition);
}
