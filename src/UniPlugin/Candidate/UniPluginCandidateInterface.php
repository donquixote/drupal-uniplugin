<?php

namespace Drupal\uniplugin\UniPlugin\Candidate;

interface UniPluginCandidateInterface {

  /**
   * Gets a handler object that does the business logic.
   *
   * Plugins that do not implement the child interface, UniPluginInterface, will
   * only return dummy handler objects.
   *
   * @param array $conf
   *   Configuration for the handler object creation, if this plugin is
   *   configurable.
   *
   * @return object|null
   *   The handler object, or a dummy handler object, or NULL.
   *   Plugins should return handlers of a specific type, but they are not
   *   technically required to do this. This is why an additional check should
   *   be performed for everything returned from a plugin.
   *
   * @throws \Exception
   *
   * @see \Drupal\uniplugin\Handler\BrokenUniHandlerInterface
   */
  function confGetHandler(array $conf = NULL);

}
