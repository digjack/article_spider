<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2faa0678fde518995a87cc77141a47a5
{
    public static $prefixLengthsPsr4 = array (
        'H' => 
        array (
            'HtmlParser\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'HtmlParser\\' => 
        array (
            0 => __DIR__ . '/..' . '/bupt1987/html-parser/src',
        ),
    );

    public static $prefixesPsr0 = array (
        's' => 
        array (
            'stringEncode' => 
            array (
                0 => __DIR__ . '/..' . '/paquettg/string-encode/src',
            ),
        ),
        'P' => 
        array (
            'PHPHtmlParser' => 
            array (
                0 => __DIR__ . '/..' . '/paquettg/php-html-parser/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2faa0678fde518995a87cc77141a47a5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2faa0678fde518995a87cc77141a47a5::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit2faa0678fde518995a87cc77141a47a5::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
