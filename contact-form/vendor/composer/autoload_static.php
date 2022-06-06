<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5ccf6a0f3bd9356bdf00a0533f08e8d8
{
    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'User\\ContactForm\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'User\\ContactForm\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5ccf6a0f3bd9356bdf00a0533f08e8d8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5ccf6a0f3bd9356bdf00a0533f08e8d8::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit5ccf6a0f3bd9356bdf00a0533f08e8d8::$classMap;

        }, null, ClassLoader::class);
    }
}
