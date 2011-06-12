<?php

/*
 * This file is part of the dflydev-core-php package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dflydev\core\io\exception;

/**
 * Description of ResourceNotFoundException
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class ResourceNotFoundException extends Exception {

    /**
     * Constructor
     * @param string $location Requested resource location
     */
    public function __construct($location) {
        parent::__construct('Could not find resource "' . $location . '"');
    }
    
}