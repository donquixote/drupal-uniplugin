<?php

namespace Drupal\uniplugin\UniPlugin;

/**
 * Interface for plugin objects.
 *
 * Plugins should not do any business logic on their own. Instead, they should
 * create and provide a handler object that does the business logic for the
 * respective plugin type.
 */
interface UniPluginInterface {

  /**
   * Gets a handler object that does the business logic.
   *
   * @param array $configuration
   *   Configuration for the handler object creation, if this plugin is
   *   configurable.
   *
   * @return object|null|\Drupal\uniplugin\Handler\BrokenUniHandlerInterface
   *   The handler object, or NULL.
   *   Plugins should return handlers of a specific type, but they are not
   *   technically required to do this. This is why an additional check should
   *   be performed for everything returned from a plugin.
   *
   * @throws \Exception
   */
  function confGetHandler(array $configuration = NULL);

}
