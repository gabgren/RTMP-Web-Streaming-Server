<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit419df90f40a2d3a0dc34a588dc3c52dd
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Filebase\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Filebase\\' => 
        array (
            0 => __DIR__ . '/..' . '/tmarois/filebase/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit419df90f40a2d3a0dc34a588dc3c52dd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit419df90f40a2d3a0dc34a588dc3c52dd::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}