<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb9a700ac9d58e3a3255ca579cae564a9
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'RWP\\Internals\\' => 14,
            'RWP\\Integrations\\' => 17,
            'RWP\\Frontend\\' => 13,
            'RWP\\Engine\\' => 11,
            'RWP\\Components\\' => 15,
            'RWP\\Backend\\' => 12,
            'RWP\\Assets\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'RWP\\Internals\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes/internals',
        ),
        'RWP\\Integrations\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes/integrations',
        ),
        'RWP\\Frontend\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes/frontend',
        ),
        'RWP\\Engine\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes/engine',
        ),
        'RWP\\Components\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes/components',
        ),
        'RWP\\Backend\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes/backend',
        ),
        'RWP\\Assets\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes/assets',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'RWP\\Backend\\Enqueue' => __DIR__ . '/../..' . '/includes/backend/Enqueue.php',
        'RWP\\Backend\\Notices' => __DIR__ . '/../..' . '/includes/backend/Notices.php',
        'RWP\\Backend\\Settings' => __DIR__ . '/../..' . '/includes/backend/Settings.php',
        'RWP\\Components\\Button' => __DIR__ . '/../..' . '/includes/components/Button.php',
        'RWP\\Components\\Column' => __DIR__ . '/../..' . '/includes/components/Column.php',
        'RWP\\Components\\Container' => __DIR__ . '/../..' . '/includes/components/Container.php',
        'RWP\\Components\\Element' => __DIR__ . '/../..' . '/includes/components/Element.php',
        'RWP\\Components\\Embed' => __DIR__ . '/../..' . '/includes/components/Embed.php',
        'RWP\\Components\\Grid' => __DIR__ . '/../..' . '/includes/components/Grid.php',
        'RWP\\Components\\Group' => __DIR__ . '/../..' . '/includes/components/Group.php',
        'RWP\\Components\\Html' => __DIR__ . '/../..' . '/includes/components/Html.php',
        'RWP\\Components\\HtmlList' => __DIR__ . '/../..' . '/includes/components/HtmlList.php',
        'RWP\\Components\\Icon' => __DIR__ . '/../..' . '/includes/components/Icon.php',
        'RWP\\Components\\Image' => __DIR__ . '/../..' . '/includes/components/Image.php',
        'RWP\\Components\\Nav' => __DIR__ . '/../..' . '/includes/components/Nav.php',
        'RWP\\Components\\NavItem' => __DIR__ . '/../..' . '/includes/components/NavItem.php',
        'RWP\\Components\\NavList' => __DIR__ . '/../..' . '/includes/components/NavList.php',
        'RWP\\Components\\Row' => __DIR__ . '/../..' . '/includes/components/Row.php',
        'RWP\\Components\\SVG' => __DIR__ . '/../..' . '/includes/components/SVG.php',
        'RWP\\Components\\Section' => __DIR__ . '/../..' . '/includes/components/Section.php',
        'RWP\\Engine\\Abstracts\\Plugin' => __DIR__ . '/../..' . '/includes/engine/Abstracts/Plugin.php',
        'RWP\\Engine\\Abstracts\\Singleton' => __DIR__ . '/../..' . '/includes/engine/Abstracts/Singleton.php',
        'RWP\\Engine\\Base' => __DIR__ . '/../..' . '/includes/engine/Base.php',
        'RWP\\Engine\\Initialize' => __DIR__ . '/../..' . '/includes/engine/Initialize.php',
        'RWP\\Engine\\Interfaces\\Component' => __DIR__ . '/../..' . '/includes/engine/Interfaces/Component.php',
        'RWP\\Engine\\Interfaces\\Core' => __DIR__ . '/../..' . '/includes/engine/Interfaces/Core.php',
        'RWP\\Engine\\Is_Methods' => __DIR__ . '/../..' . '/includes/engine/Is_Methods.php',
        'RWP\\Engine\\Traits\\Assets' => __DIR__ . '/../..' . '/includes/engine/Traits/Assets.php',
        'RWP\\Frontend\\Enqueue' => __DIR__ . '/../..' . '/includes/frontend/Enqueue.php',
        'RWP\\Frontend\\Extras\\Body_Class' => __DIR__ . '/../..' . '/includes/frontend/Extras/Body_Class.php',
        'RWP\\Frontend\\Extras\\Clean_Up' => __DIR__ . '/../..' . '/includes/frontend/Extras/Clean_Up.php',
        'RWP\\Frontend\\Extras\\JS_Footer' => __DIR__ . '/../..' . '/includes/frontend/Extras/JS_Footer.php',
        'RWP\\Frontend\\Extras\\Nice_Search' => __DIR__ . '/../..' . '/includes/frontend/Extras/Nice_Search.php',
        'RWP\\Integrations\\ACF' => __DIR__ . '/../..' . '/includes/integrations/ACF.php',
        'RWP\\Integrations\\Elementor' => __DIR__ . '/../..' . '/includes/integrations/Elementor.php',
        'RWP\\Integrations\\FakePage' => __DIR__ . '/../..' . '/includes/integrations/FakePage.php',
        'RWP\\Integrations\\GravityForms' => __DIR__ . '/../..' . '/includes/integrations/GravityForms.php',
        'RWP\\Integrations\\JS_Plugins' => __DIR__ . '/../..' . '/includes/integrations/JS_Plugins.php',
        'RWP\\Integrations\\Nav_Menus' => __DIR__ . '/../..' . '/includes/integrations/Nav_Menus.php',
        'RWP\\Integrations\\QM' => __DIR__ . '/../..' . '/includes/integrations/QM.php',
        'RWP\\Integrations\\Walkers\\Nav' => __DIR__ . '/../..' . '/includes/integrations/Walkers/Nav.php',
        'RWP\\Integrations\\Wistia' => __DIR__ . '/../..' . '/includes/integrations/Wistia.php',
        'RWP\\Internals\\Bootstrap' => __DIR__ . '/../..' . '/includes/internals/Bootstrap.php',
        'RWP\\Internals\\Lazysizes' => __DIR__ . '/../..' . '/includes/internals/Lazysizes.php',
        'RWP\\Internals\\PostTypes' => __DIR__ . '/../..' . '/includes/internals/PostTypes.php',
        'RWP\\Internals\\Relative_Urls' => __DIR__ . '/../..' . '/includes/internals/Relative_Urls.php',
        'RWP\\Internals\\Shortcode' => __DIR__ . '/../..' . '/includes/internals/Shortcode.php',
        'RWP\\Internals\\Transient' => __DIR__ . '/../..' . '/includes/internals/Transient.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb9a700ac9d58e3a3255ca579cae564a9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb9a700ac9d58e3a3255ca579cae564a9::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb9a700ac9d58e3a3255ca579cae564a9::$classMap;

        }, null, ClassLoader::class);
    }
}
