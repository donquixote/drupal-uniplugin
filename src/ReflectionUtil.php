<?php

namespace Drupal\uniplugin;

use Drupal\uniplugin\UniPlugin\OptionHandler\PluginTypeOptionHandler;

abstract class ReflectionUtil {

  /**
   * @param \ReflectionClass $reflectionClass
   *
   * @return false|\Drupal\uniplugin\UniPlugin\OptionHandler\PluginTypeOptionHandler[]
   */
  static function reflectionClassGetConstructorArgumentHandlers(\ReflectionClass $reflectionClass) {
    if ($reflectionConstructor = $reflectionClass->getConstructor()) {
      return ReflectionUtil::reflectionFunctionGetArgumentHandlers($reflectionConstructor);
    }
    return array();
  }

  /**
   * @param \ReflectionFunctionAbstract $reflectionFunction
   *
   * @return false|\Drupal\uniplugin\UniPlugin\OptionHandler\PluginTypeOptionHandler[]
   */
  static function reflectionFunctionGetArgumentHandlers(\ReflectionFunctionAbstract $reflectionFunction) {
    $argumentHandlers = array();
    foreach ($reflectionFunction->getParameters() as $param) {
      $argumentHandler = static::reflectionParamGetArgumentHandler($param);
      if (NULL === $argumentHandler) {
        return FALSE;
      }
      $argumentHandlers[$param->getName()] = $argumentHandler;
    }
    return $argumentHandlers;
  }

  /**
   * @param \ReflectionFunctionAbstract $reflectionFunction
   *
   * @return false|\Drupal\uniplugin\UniPlugin\OptionHandler\PluginTypeOptionHandler
   */
  static function reflectionFunctionGetSingleArgumentHandler(\ReflectionFunctionAbstract $reflectionFunction) {
    $params = $reflectionFunction->getParameters();
    if (count($params) !== 1) {
      return FALSE;
    }
    $param = reset($params);
    return static::reflectionParamGetArgumentHandler($param);
  }

  /**
   * @param \ReflectionParameter $reflectionParam
   *
   * @return false|\Drupal\uniplugin\UniPlugin\OptionHandler\PluginTypeOptionHandler
   */
  static function reflectionParamGetArgumentHandler(\ReflectionParameter $reflectionParam) {
    $typeHintReflectionClassLike = $reflectionParam->getClass();
    if (!$typeHintReflectionClassLike) {
      return FALSE;
    }
    $manager = uniplugin()->interfaceGetHandlerMap($typeHintReflectionClassLike->getName());
    return new PluginTypeOptionHandler($manager, $reflectionParam->getName());
  }

  /**
   * @param callable $callback
   *
   * @return null|\ReflectionFunctionAbstract
   */
  static function callbackGetReflection($callback) {

    if (!is_callable($callback)) {
      return NULL;
    }

    if (is_string($callback)) {
      if (FALSE === strpos($callback, '::')) {
        if (!function_exists($callback)) {
          return NULL;
        }
        return new \ReflectionFunction($callback);
      }
      list($classOrObject, $methodName) = explode('::', $callback);
    }
    elseif (is_object($callback)) {
      if (!method_exists($callback, '__invoke')) {
        return NULL;
      }
      $classOrObject = $callback;
      $methodName = '__invoke';
    }
    elseif (!is_array($callback)) {
      return NULL;
    }
    elseif (!isset($callback[0]) || !isset($callback[1])) {
      return NULL;
    }
    else {
      list($classOrObject, $methodName) = $callback;
    }

    if (!method_exists($classOrObject, $methodName)) {
      return NULL;
    }

    return new \ReflectionMethod($classOrObject, $methodName);
  }
}
