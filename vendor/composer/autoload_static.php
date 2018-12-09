<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite677d5a5e1d0903083e2eefdbfd57472
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'PayPal' => 
            array (
                0 => __DIR__ . '/..' . '/paypal/rest-api-sdk-php/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite677d5a5e1d0903083e2eefdbfd57472::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite677d5a5e1d0903083e2eefdbfd57472::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInite677d5a5e1d0903083e2eefdbfd57472::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}