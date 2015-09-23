<?php

namespace Drupal\uniplugin\Scan;

interface NamespaceDirectoryWalkerInterface {

  /**
   * @param string $directory
   * @param string $namespace
   * @param \Drupal\uniplugin\Scan\ClassFileVisitorInterface $classFileVisitor
   *
   * @return mixed
   */
  function walkNamespaceDirectory($directory, $namespace, ClassFileVisitorInterface $classFileVisitor);

}
