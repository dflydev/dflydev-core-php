<?php

/*
 * This file is part of the dflydev-core-php package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dflydev\core\io;

/**
 * Description of CompositeResourceLoader
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class CompositeResourceLoader implements IResourceLoader {
    
    /**
     * @var array
     */
    private $resourceLoaders = array();
    
    /**
     * Constructor
     * @param array|IResourceLoader $resourceLoaders Resource loaders
     */
    public function __construct($resourceLoaders = null) {
        if ( $resourceLoaders !== null ) {
            $this->resourceLoaders = (array) $resourceLoaders;
        }
    }
    
    /**
     * Append a resource loader.
     * @param IResourceLoader $resourceLoader A resource loader
     */
    public function appendResourceLoader(IResourceLoader $resourceLoader) {
        $this->resourceLoaders[] = $resourceLoader;
    }

    /**
     * Append resource loaders.
     * @param array $resourceLoaders A resource loader
     */
    public function appendResourceLoaders(array $resourceLoaders) {
        $this->resourceLoaders = array_merge($this->resourceLoaders, $resourceLoaders);
    }

    /**
     * {@inheritdoc}
     */
    public function load($location) {
        foreach ( $this->resourceLoaders as $resourceLoader ) {
            try {
                return $resourceLoader->load($location);
            } catch (exception\ResourceNotFoundException $e) {
                // fine, try the next...
            }
        }
        throw new exception\ResourceNotFoundException($location);
    }

    
}