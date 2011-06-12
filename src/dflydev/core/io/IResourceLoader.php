<?php

/*
 * This file is part of the dflydev-core-php package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dflydev\core\io;

/**
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
interface IResourceLoader {
    
    /**
     * Return a Resource handle for the specified resource.
     * @return IResource
     * @throws exception\ResourceNotFoundException
     */
    function load($location);
    
}