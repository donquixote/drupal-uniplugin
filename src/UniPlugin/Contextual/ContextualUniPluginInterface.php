<?php

namespace Drupal\uniplugin\UniPlugin\Contextual;

use Drupal\uniplugin\TypeContext\UniPluginTypeContextInterface;
use Drupal\uniplugin\UniPlugin\Candidate\UniPluginCandidateInterface;

interface ContextualUniPluginInterface extends UniPluginCandidateInterface {

  /**
   * @param \Drupal\uniplugin\TypeContext\UniPluginTypeContextInterface $context
   *
   * @return null|\Drupal\uniplugin\UniPlugin\Candidate\UniPluginCandidateInterface
   */
  function contextGetPlugin(UniPluginTypeContextInterface $context);
}
