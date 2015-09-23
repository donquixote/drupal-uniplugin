<?php

namespace Drupal\uniplugin\Scan;

class NamespaceDirectoryWalker implements NamespaceDirectoryWalkerInterface {

  /**
   * @param string $directory
   * @param string $namespace
   * @param \Drupal\uniplugin\Scan\ClassFileVisitorInterface $classFileVisitor
   *
   * @return mixed
   */
  function walkNamespaceDirectory($directory, $namespace, ClassFileVisitorInterface $classFileVisitor) {
    $path_lastchar = substr($directory, -1);
    if ('/' === $path_lastchar || '\\' === $path_lastchar) {
      throw new \InvalidArgumentException('Path must be provided without trailing slash or backslash.');
    }
    if ('\\' === substr($namespace, -1)) {
      throw new \InvalidArgumentException('Namespace must be provided without trailing backslash.');
    }
    if (!empty($namespace) && '\\' === $namespace[0]) {
      throw new \InvalidArgumentException('Namespace must be provided without preceding backslash.');
    }
    if (!is_dir($directory)) {
      throw new \InvalidArgumentException('Not a directory: ' . check_plain($directory));
    }
    if ('' !== $namespace) {
      $namespace .= '\\';
    }
    $this->walkRecursive($directory . '/', $namespace, $classFileVisitor);
  }

  /**
   * @param string $parentDir
   * @param string $parentNamespace
   * @param \Drupal\uniplugin\Scan\ClassFileVisitorInterface $classFileVisitor
   */
  private function walkRecursive($parentDir, $parentNamespace, ClassFileVisitorInterface $classFileVisitor) {
    foreach (scandir($parentDir) as $candidate) {
      if ('.' === $candidate[0]) {
        continue;
      }
      $path = $parentDir . $candidate;
      if ('.php' === substr($candidate, -4)) {
        $name = substr($candidate, 0, -4);
        $class = $parentNamespace . $name;
        $classFileVisitor->visitClassFile($class, $path);
      }
      else {
        $this->walkRecursive($path . '/', $parentNamespace . $candidate . '\\', $classFileVisitor);
      }
    }
  }

}
