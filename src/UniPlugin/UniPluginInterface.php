<?php

namespace Drupal\uniplugin\UniPlugin;

use Drupal\uniplugin\UniPlugin\Candidate\UniPluginCandidateInterface;

/**
 * Interface for "valid" plugin objects.
 *
 * Plugins should not do any business logic on their own. Instead, they should
 * create and provide a handler object that does the business logic for the
 * respective plugin type.
 *
 * Any plugin class that can return valid handler objects should implement this
 * interface, and not the parent.
 */
interface UniPluginInterface extends UniPluginCandidateInterface {

  /**
   * Gets a handler object that does the business logic.
   *
   * @param array $conf
   *   Configuration for the handler object creation, if this plugin is
   *   configurable.
   *
   * @return object|null
   *   The handler object, or NULL.
   *   Plugins should return handlers of a specific type, but they are not
   *   technically required to do this. This is why an additional check should
   *   be performed for everything returned from a plugin.
   *
   * @throws \Exception
   */
  function confGetHandler(array $conf = NULL);

}
