<?php

namespace Drupal\uniplugin\Scan;

interface ClassFileVisitorInterface {

  /**
   * @param string $file
   * @param string $class
   */
  function visitClassFile($file, $class);

}
