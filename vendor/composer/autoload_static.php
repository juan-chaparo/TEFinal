<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite239e4337690b7dcd63f34135036364b
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite239e4337690b7dcd63f34135036364b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite239e4337690b7dcd63f34135036364b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite239e4337690b7dcd63f34135036364b::$classMap;

        }, null, ClassLoader::class);
    }
}
