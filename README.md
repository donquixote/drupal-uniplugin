# Unified Plugin API

UniPlugin is an API module to create plugin APIs. Examples are the [EntDisP (Entity Display Plugin)](https://github.com/donquixote/drupal-entdisp) and the [Listformat](https://github.com/donquixote/drupal-listformat) modules.

Plugin systems have a long history in Drupal.
In D7 there were Ctools plugins, in D8 there is the [D8 core plugin API](https://www.drupal.org/developing/api/8/plugins).
One could also regard the D7 text filters, image style processors, field formatters, etc, as plugins, even though these systems are completely procedural.

Both with Ctools and with D8 plugins, plugins are objects that do a specific job, and in addition have some functionality for configuration management. 
 
UniPlugin was initially inspired by the D8 plugin API, but it has one big difference:

* Plugins and handlers are distinct objects.
* Plugin objects don't do any business logic, they only create handler objects.
* Handler objects do the actual business logic, such as, build a render array for an entity.
* Handlers know nothing of the plugin system, and can be used independently of it.  
  E.g. all the handlers for EntDisP live in the [Renderkit](https://github.com/donquixote/drupal-renderkit) module, which is perfectly usable without EntDisP.  
  In fact, most of the Renderkit EntityDisplay classes do not even have any associated EntDisP plugin.
* All plugins implement the same interface, [UniPluginInterface](src/UniPlugin/UniPluginInterface.php).  
  There is no need to distinguish plugins of different types.
* Handlers implement distinct interfaces depending on the plugin type, without any shared super-interface.
* Plugins do not hold their configuration. Instead, the configuration is passed to the `UniPluginInterface::confGetHandler()` method from outside.
* Handlers typically do not hold their configuration either, at least not in the original form.
  Instead, the `UniPluginInterface::confGetHandler()` method of the respective plugin can pass relevant constructor arguments when creating handler objects.  

More details:

* A plugin for a given plugin type is identified by a plugin id, typically a string.  
  There is only one plugin object per plugin id, so these objects can be buffered.
* For a handler, we need both the plugin id and the plugin options.  
  For a plugin id / plugins with options, any number of different handlers can be created.
* For every plugin id, there is one plugin definition array.
* A plugin definition array defines how to create a plugin object.  
  Have a look at [DefinitionToPlugin](src/DefinitionToPlugin/DefinitionToPlugin.php) for the structure of the definition array.
* If the plugin implements [ConfigurableUniPluginInterface](src/UniPlugin/ConfigurableUniPluginInterface.php), the plugin will have options and a configuration form.

Handler interfaces for plugin types:
 
* Different plugin types require different interfaces for the handler objects.  
  E.g. EntDisP handlers should implement `Drupal\renderkit\EntityDisplay\EntityDisplayInterface`.
* However, plugins are not technically required to return a specific handler type in the `->confGetHandler()` method.
* Instead, plugin types should provide a "manager" class, that checks if a handler has the correct type.  
  If not, the "manager" can create a placeholder handler object.  
  E.g. `Drupal\entdisp\Manager\EntdispPluginManager::settingsGetEntityDisplay()` will return an `EntdispBrokenEntityDisplay` as a placeholder. 

Discovery:

* By default, plugin definitions are registered through an info hook.  
  E.g. for EntDisP, this is `hook_entdisp_info()`.
* 3rd party modules can provide discovery tools, which can be called from those hook implementations, e.g. for annotation-based discovery.  
  So far this is not part of UniPlugin, because it would cause unnecessary bloat, and possibly 3rd party dependencies.
  
Placeholder objects:

* When other systems would return NULL or throw exceptions, UniPlugin (and EntDisP) return placeholder objects like [BrokenUniHandler](src/Handler/BrokenUniHandler.php) for handlers, or [BrokenUniPlugin](src/UniPlugin/Broken/BrokenUniPlugin.php) for plugins.
* Placeholder objects remember what went wrong, why no "real" handler or plugin was created.
* Placeholder plugins behave as real plugins, with full respect to the Liskov Substitution principle.
* Placeholder handlers created by UniPlugin do not implement the respective handler interface of the plugin type.
  This is ok because UniPlugin does not promise anything about handler objects, anyway.
 
