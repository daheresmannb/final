<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit71b9f016d99b93267165431067e34048
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MicheleAngioni\\PhalconAuth\\' => 27,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MicheleAngioni\\PhalconAuth\\' => 
        array (
            0 => __DIR__ . '/..' . '/michele-angioni/phalcon-auth/src/PhalconAuth',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit71b9f016d99b93267165431067e34048::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit71b9f016d99b93267165431067e34048::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}