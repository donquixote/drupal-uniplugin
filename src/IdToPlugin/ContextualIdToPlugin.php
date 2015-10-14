<?php

namespace Drupal\uniplugin\IdToPlugin;

use Drupal\uniplugin\TypeContext\UniPluginTypeContextInterface;
use Drupal\uniplugin\UniPlugin\Contextual\ContextualUniPluginInterface;

class ContextualIdToPlugin implements IdToPluginInterface {

  /**
   * @var \Drupal\uniplugin\IdToPlugin\IdToPluginInterface
   */
  private $idToPlugin;

  /**
   * @var \Drupal\uniplugin\TypeContext\UniPluginTypeContextInterface
   */
  private $context;

  /**
   * ContextualIdToPlugin constructor.
   *
   * @param \Drupal\uniplugin\IdToPlugin\IdToPluginInterface $idToPlugin
   * @param \Drupal\uniplugin\TypeContext\UniPluginTypeContextInterface $context
   */
  function __construct(IdToPluginInterface $idToPlugin, UniPluginTypeContextInterface $context) {
    $this->idToPlugin = $idToPlugin;
    $this->context = $context;
  }

  /**
   * @param string $id
   *
   * @return \Drupal\uniplugin\UniPlugin\UniPluginInterface|null
   */
  function idGetPlugin($id) {
    $pluginCandidate = $this->idToPlugin->idGetPlugin($id);
    if ($pluginCandidate instanceof ContextualUniPluginInterface) {
      return $pluginCandidate->contextGetPlugin($this->context);
    }
    return $pluginCandidate;
  }
}
