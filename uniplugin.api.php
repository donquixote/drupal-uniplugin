<?php
use Drupal\renderkit\ListFormat\ListFormatInterface;
use Drupal\renderkit\Plugin\ListFormat\ItemListLfPlugin;
use Drupal\renderkit\Plugin\ListFormat\SeparatorLfPlugin;

/**
 * Implements hook_uniplugin_info()
 *
 * @return array[][]
 */
function hook_uniplugin_info() {
  $definitions = array();

  $definitions[ListFormatInterface::class] = array(
    SeparatorLfPlugin::class => array(
      'label' => t('Separator'),
      'plugin_class' => SeparatorLfPlugin::class,
    ),
    ItemListLfPlugin::class => array(
      'label' => t('HTML list'),
      'plugin_class' => ItemListLfPlugin::class,
    ),
  );

  return $definitions;
}
