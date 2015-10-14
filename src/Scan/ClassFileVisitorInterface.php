<?php

namespace Drupal\uniplugin\Scan;

interface ClassFileVisitorInterface {

  /**
   * @param string $class
   * @param string $file
   */
  function visitClassFile($class, $file);

}
