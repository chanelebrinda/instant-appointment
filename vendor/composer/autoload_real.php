<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInite8688be2922c1068844b09d6b2c6d8c6
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

        spl_autoload_register(array('ComposerAutoloaderInite8688be2922c1068844b09d6b2c6d8c6', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInite8688be2922c1068844b09d6b2c6d8c6', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInite8688be2922c1068844b09d6b2c6d8c6::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
