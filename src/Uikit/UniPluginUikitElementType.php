<?php

namespace Drupal\uniplugin\Uikit;

use Drupal\uikit\FormElement\UikitElementTypeInterface;
use Drupal\uniplugin\LabelsByModuleAndId\LabelsByModuleAndIdInterface;
use Drupal\uniplugin\IdToPlugin\IdToPluginInterface;
use Drupal\uniplugin\UniPlugin\ConfigurableUniPluginInterface;

class UniPluginUikitElementType implements UikitElementTypeInterface {

  /**
   * @var \Drupal\uniplugin\LabelsByModuleAndId\LabelsByModuleAndIdInterface
   */
  private $labelsByModuleAndId;

  /**
   * @var \Drupal\uniplugin\IdToPlugin\IdToPluginInterface
   */
  private $idToPlugin;

  /**
   * @param \Drupal\uniplugin\LabelsByModuleAndId\LabelsByModuleAndIdInterface $labelsByModuleAndId
   * @param \Drupal\uniplugin\IdToPlugin\IdToPluginInterface $idToPlugin
   */
  function __construct(LabelsByModuleAndIdInterface $labelsByModuleAndId, IdToPluginInterface $idToPlugin) {
    $this->labelsByModuleAndId = $labelsByModuleAndId;
    $this->idToPlugin = $idToPlugin;
  }

  /**
   * @param array $element
   * @param array|FALSE|NULL $input
   * @param array $form_state
   *
   * @return mixed
   *
   * @see _uikit_element_value_callback()
   */
  public function value_callback(array $element, $input, array $form_state) {
    // A neutral value callback returns NULL.
    return NULL;
  }

  /**
   * @param array $element
   * @param array $form_state
   * @param array $form
   *
   * @return array
   *   The modified form element.
   *
   * @see _uikit_element_process()
   */
  public function process(array $element, array &$form_state, array &$form) {
    $form_build_id = $form['form_build_id']['#value'];
    $uniqid = sha1($form_build_id . $element['#name']);


    if (!isset($element['#title'])) {
      $element['#title'] = t('Display plugin');
    }

    $element['id']['#markup'] = '<!-- ' . $element['#name'] . ' -->';

    $value = isset($element['#value']) ? $element['#value'] : array();
    $plugin_id = isset($value['plugin_id'])
      ? $value['plugin_id']
      : NULL;

    $element['plugin_id'] = array(
      '#title' => $element['#title'],
      '#type' => 'select',
      '#options' => $this->getSelectOptions(),
      '#default_value' => $plugin_id,
    );

    $element['plugin_options'] = array(
      '#prefix' => '<div id="' . $uniqid . '">',
      '#suffix' => '</div>',
      '#type' => 'renderkit_container',
      '#markup' => '<!-- -->',
      '#tree' => TRUE,
    );

    if (!empty($element['#views'])) {
      $element['plugin_options']['sorry'] = array(
        '#markup' => t('This sub-form would normally be AJAX-updated if you change the display plugin.')
          . '<br/>' . t('Unfortunately, this is currently not supported, because Views is special.')
          . '<br/>' . t('For an updated sub-form, click "Apply" to save this form, and open it again.'),
        '#weight' => -1,
      );
    }
    else {
      // See https://www.drupal.org/node/752056 "AJAX Forms in Drupal 7".
      $element['plugin_id']['#ajax'] = array(
        /* @see _uniplugin_element_ajax_callback() */
        'callback' => '_uniplugin_element_ajax_callback',
        'wrapper' => $uniqid,
        'method' => 'replace',
        # 'effect' =>
      );
    }

    // @todo Reload the 'plugin_options' element with ajax, when 'plugin_id' changes.
    if (NULL !== $plugin_id) {
      $plugin = $this->idToPlugin->idGetPlugin($plugin_id);
      if ($plugin instanceof ConfigurableUniPluginInterface) {
        $conf = isset($value['plugin_options'])
          ? $value['plugin_options']
          : array();
        $options_form = $plugin->settingsForm($conf);
        if ($options_form) {
          $element['plugin_options'] += $options_form;
        }
      }
    }

    if (element_children($element['plugin_options'])) {
      $element['plugin_options']['#type'] = 'fieldset';
      $element['plugin_options']['#title'] = t('Plugin options');
    }

    return $element;
  }

  /**
   * @return string[][]
   */
  private function getSelectOptions() {
    $labelsByModule = $this->labelsByModuleAndId->getLabelsByModuleAndId();
    $module_info = system_get_info('module_enabled');
    $options = array();
    foreach ($labelsByModule as $module => $labelsById) {
      $group_base = isset($module_info[$module]['name'])
        ? $module_info[$module]['name']
        : $module;
      $group = $group_base;
      $i = 1;
      while (isset($options[$group]) && is_string($options[$group])) {
        $group = $group_base . ' (' . $i .')';
        ++$i;
      }
      if (!isset($options[$group])) {
        $options[$group] = $labelsById;
      }
      else {
        $options[$group] += $labelsById;
      }
    }

    return $options;
  }
}
