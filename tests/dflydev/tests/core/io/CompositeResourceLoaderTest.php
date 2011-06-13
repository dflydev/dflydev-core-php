<?php

/*
 * This file is part of the dflydev-core-php package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dflydev\tests\core\io;

use dflydev\core\io\CompositeResourceLoader;

/**
 * Description of CompositeResourceLoaderTest
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class CompositeResourceLoaderTest extends \PHPUnit_Framework_TestCase {
    public function testNoBackingResourceLoaders() {
        $resourceLoader = new CompositeResourceLoader();
        try {
            // This can be anything and it should fail.
            $resource = $resourceLoader->load("--ANYTHING--");
            $this->fail();
        } catch (\Exception $e) {
            $this->assertInstanceOf('dflydev\core\io\exception\ResourceNotFoundException', $e, '->load() throws dflydev\core\io\exception\ResourceNotFoundException when loading a resource but no backing resource loaders are specified');
        }        
    }
    public function testLoadingMissingResource() {
        $location = 'foo.txt';
        $firstResourceLoader = $this->getMock('dflydev\core\io\FileSystemResourceLoader', array('load'), array('anywhere'));
        $firstResourceLoader->expects($this->once())
                            ->method('load')
                            ->with($this->equalTo($location))
                            ->will($this->throwException(new \dflydev\core\io\exception\ResourceNotFoundException($location)));
        $resourceLoader = new CompositeResourceLoader(array($firstResourceLoader));
        try {
            $resourceLoader->load($location);
            $this->fail();
        } catch (\Exception $e) {
            $this->assertInstanceOf('dflydev\core\io\exception\ResourceNotFoundException', $e, '->load() throws dflydev\core\io\exception\ResourceNotFoundException when loading a resource but no backing resource loaders are specified');
        }        
    }
    public function testLoadingExistingResource() {
        $location = 'foo.txt';
        $firstResourceLoader = $this->getMock('dflydev\core\io\FileSystemResourceLoader', array('load'), array('anywhere'));
        $firstResourceLoader->expects($this->once())
                            ->method('load')
                            ->with($this->equalTo($location))
                            ->will($this->throwException(new \dflydev\core\io\exception\ResourceNotFoundException($location)));
        $secondResourceLoader = $this->getMock('dflydev\core\io\FileSystemResourceLoader', array('load'), array('else'));
        $secondResourceLoader->expects($this->once())
                            ->method('load')
                            ->with($this->equalTo($location))
                            ->will($this->returnValue(new \dflydev\core\io\FileSystemResource('else/'.$location)));
        $resourceLoader = new CompositeResourceLoader(array(
            $firstResourceLoader,
            $secondResourceLoader,
        ));
        
        $resource = $resourceLoader->load($location);
        $this->assertEquals('else/'.$location, $resource->filename());
    }
    public function testAppendingResourceLoadersIndividually() {
        $location = 'foo.txt';
        $firstResourceLoader = $this->getMock('dflydev\core\io\FileSystemResourceLoader', array('load'), array('anywhere'));
        $firstResourceLoader->expects($this->once())
                            ->method('load')
                            ->with($this->equalTo($location))
                            ->will($this->throwException(new \dflydev\core\io\exception\ResourceNotFoundException($location)));
        $secondResourceLoader = $this->getMock('dflydev\core\io\FileSystemResourceLoader', array('load'), array('else'));
        $secondResourceLoader->expects($this->once())
                            ->method('load')
                            ->with($this->equalTo($location))
                            ->will($this->returnValue(new \dflydev\core\io\FileSystemResource('else/'.$location)));
        $resourceLoader = new CompositeResourceLoader();
        $resourceLoader->appendResourceLoader($firstResourceLoader);
        $resourceLoader->appendResourceLoader($secondResourceLoader);
        $resource = $resourceLoader->load($location);
        $this->assertEquals('else/'.$location, $resource->filename());
    }
    public function testAppendingResourceLoadersTogether() {
        $location = 'foo.txt';
        $firstResourceLoader = $this->getMock('dflydev\core\io\FileSystemResourceLoader', array('load'), array('anywhere'));
        $firstResourceLoader->expects($this->once())
                            ->method('load')
                            ->with($this->equalTo($location))
                            ->will($this->throwException(new \dflydev\core\io\exception\ResourceNotFoundException($location)));
        $secondResourceLoader = $this->getMock('dflydev\core\io\FileSystemResourceLoader', array('load'), array('else'));
        $secondResourceLoader->expects($this->once())
                            ->method('load')
                            ->with($this->equalTo($location))
                            ->will($this->returnValue(new \dflydev\core\io\FileSystemResource('else/'.$location)));
        $resourceLoader = new CompositeResourceLoader();
        $resourceLoader->appendResourceLoaders(array(
            $firstResourceLoader,
            $secondResourceLoader,
        ));
        $resource = $resourceLoader->load($location);
        $this->assertEquals('else/'.$location, $resource->filename());
    }
}