<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf91837ad77060b5c4c6423e5c3a0a4c2
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'Bifei\\FastXml\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Bifei\\FastXml\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf91837ad77060b5c4c6423e5c3a0a4c2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf91837ad77060b5c4c6423e5c3a0a4c2::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
