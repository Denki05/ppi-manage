<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit59ab7a299986c4ee3880553abb5ea40c
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

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit59ab7a299986c4ee3880553abb5ea40c', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit59ab7a299986c4ee3880553abb5ea40c', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit59ab7a299986c4ee3880553abb5ea40c::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
