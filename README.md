# Dragonfly Development PHP Core Library #

Provides basic bootstrapping functionality such as resource locating and
class loading.

## Dependencies ##

None.

This package is likely a dependency for many Dragonfly Development libraries.
At the very least, the dflydev\core\ClassLoader is likely to be suggested
for a lack of a [better solution](https://github.com/symfony/ClassLoader).

## Usage ##

### Class Loader ###

Simple class loader based on the [Symfony UniversalClassLoader](https://github.com/symfony/ClassLoader)
that can be used to load classes following the [PSR-0 autoloader interoperability standard](http://groups.google.com/group/php-standards/web/psr-0-final-proposal).

    $classLoader = new ClassLoader();
    $classLoader->registerNamespaces(array(
        // 'namespace' => '/path/to/namespace/root'
        'dflydev\\core' => __DIR__.'/src',
    ));
    $classLoader->activate();

This class loader is provided as a fallback that can be used if a project
does not already have a PSR-0 capable class loader.

### Resource Loader ###

    use dflydev\core\io\FileSystemResourceLoader
    $resourceLoader = new FileSystemResourceLoader('/tmp');
    try {
        $resource = $resourceLoader->load('somefile.txt');
    } catch (dflydev\core\io\exception\ResourceNotFoundException $e) {
        // somefile.txt must not have been able to be located
        // in the specified directory/directories.
    }

## More Information ##

More information can be found on the [d2code Redmine](http://redmine.dflydev.com/projects/dflydev-core-php).

