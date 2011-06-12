<?php

/*
 * This file is part of the dflydev-core-php package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dflydev\core\io;

/**
 * Description of FileSystemResourceLoader
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class FileSystemResourceLoader implements IResourceLoader {
    
    /**
     * @var array
     */
    private $paths = array();

    /**
     * Constructor.
     * 
     * @param type $paths Paths
     */
    public function __construct($paths) {
        foreach ( (is_array($paths) ? $paths : array($paths)) as $path ) {
            if ( file_exists($path) ) { $this->paths[] = $path; }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function load($location) {
        if ( file_exists($location) ) {
            return new FileSystemResource(realpath($location));
        }
        foreach ( $this->paths as $path ) {
            $filename = $path . '/' . $location;
            if ( file_exists($filename) ) {
                return new FileSystemResource(realpath($filename));
            }
        }
        
        throw new exception\ResourceNotFoundException($location);

    }
    
}