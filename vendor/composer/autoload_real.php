<?php

// autoload_real.php @generated by Composer

<<<<<<< HEAD
class ComposerAutoloaderInit9447bd3be82ac6ba9b952bbc04749a69
=======
class ComposerAutoloaderInit97b0fb09415bc6b831967605b21244bd
>>>>>>> release/v0.9.0
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

<<<<<<< HEAD
        spl_autoload_register(array('ComposerAutoloaderInit9447bd3be82ac6ba9b952bbc04749a69', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit9447bd3be82ac6ba9b952bbc04749a69', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit9447bd3be82ac6ba9b952bbc04749a69::getInitializer($loader));
=======
        spl_autoload_register(array('ComposerAutoloaderInit97b0fb09415bc6b831967605b21244bd', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit97b0fb09415bc6b831967605b21244bd', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit97b0fb09415bc6b831967605b21244bd::getInitializer($loader));
>>>>>>> release/v0.9.0

        $loader->setClassMapAuthoritative(true);
        $loader->register(true);

<<<<<<< HEAD
        return $loader;
    }
}
=======
        $includeFiles = \Composer\Autoload\ComposerStaticInit97b0fb09415bc6b831967605b21244bd::$files;
        foreach ($includeFiles as $fileIdentifier => $file) {
            composerRequire97b0fb09415bc6b831967605b21244bd($fileIdentifier, $file);
        }

        return $loader;
    }
}

/**
 * @param string $fileIdentifier
 * @param string $file
 * @return void
 */
function composerRequire97b0fb09415bc6b831967605b21244bd($fileIdentifier, $file)
{
    if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
        $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;

        require $file;
    }
}
>>>>>>> release/v0.9.0
