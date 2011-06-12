<?php

/*
 * This file is part of the dflydev-core-php package.
 * 
 * This is a very minimal reimplementation of the Symfony UniversalClassLoader
 * which is (c) Fabien Potencier <fabien@symfony.com> and can be found here:
 * 
 * https://github.com/symfony/ClassLoader
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dflydev\core;

/**
 * Description of ClassLoader
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class ClassLoader {
    
    /**
     * @var array
     */
    private $namespaces = array();

    /**
     * Registers an array of namespaces.
     * @param array $namespaces An array of namespaces (namespaces as keys and locations as values)
     */
    public function registerNamespaces(array $namespaces) {
        foreach ( $namespaces as $namespace => $locations ) {
            $this->namespaces[$namespace] = (array) $locations;
        }
    }

    /**
     * Activate the autoloader.
     * @param type $prepend Whether to prepend the autoloader or not
     */
    public function activate($prepend = false) {
        spl_autoload_register(array($this, 'load'), true, $prepend);
    }

    /**
     * Attempt to load a given class or interface.
     * @param string $class The name of the lass
     */
    public function load($class) {
        $file = $this->locate($class);
        if ($file) {
            require $file;
        }
    }

    /**
     * Locates the file in which the class is defined.
     * @param type $class The name of the class
     * @return string Filename
     */
    protected function locate($class) {
        if ( '\\' == $class[0] ) {
            $class = substr($class, 1);
        }
        if (false !== $pos = strrpos($class, '\\')) {
            $namespace = substr($class, 0, $pos);
            foreach ($this->namespaces as $ns => $dirs) {
                foreach ($dirs as $dir) {
                    if (0 === strpos($namespace, $ns)) {
                        $className = substr($class, $pos + 1);
                        $file = $dir.DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, $namespace).DIRECTORY_SEPARATOR.str_replace('_', DIRECTORY_SEPARATOR, $className).'.php';
                        if (file_exists($file)) {
                            return $file;
                        }
                    }
                }
            }
        }
    }

}