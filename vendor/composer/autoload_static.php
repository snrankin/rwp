<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9447bd3be82ac6ba9b952bbc04749a69
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
        'RWP\\Components\\Card' => __DIR__ . '/../..' . '/includes/components/Card.php',
        'RWP\\Components\\Collection' => __DIR__ . '/../..' . '/includes/components/Collection.php',
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
        'RWP\\Components\\Location' => __DIR__ . '/../..' . '/includes/components/Location.php',
        'RWP\\Components\\Modal' => __DIR__ . '/../..' . '/includes/components/Modal.php',
        'RWP\\Components\\Nav' => __DIR__ . '/../..' . '/includes/components/Nav.php',
        'RWP\\Components\\NavItem' => __DIR__ . '/../..' . '/includes/components/NavItem.php',
        'RWP\\Components\\NavList' => __DIR__ . '/../..' . '/includes/components/NavList.php',
        'RWP\\Components\\Pluralizer' => __DIR__ . '/../..' . '/includes/components/Pluralizer.php',
        'RWP\\Components\\PostCard' => __DIR__ . '/../..' . '/includes/components/PostCard.php',
        'RWP\\Components\\Row' => __DIR__ . '/../..' . '/includes/components/Row.php',
        'RWP\\Components\\SVG' => __DIR__ . '/../..' . '/includes/components/SVG.php',
        'RWP\\Components\\Section' => __DIR__ . '/../..' . '/includes/components/Section.php',
        'RWP\\Components\\Str' => __DIR__ . '/../..' . '/includes/components/Str.php',
        'RWP\\Components\\Table' => __DIR__ . '/../..' . '/includes/components/Table.php',
        'RWP\\Components\\TableCell' => __DIR__ . '/../..' . '/includes/components/TableCell.php',
        'RWP\\Components\\TableRow' => __DIR__ . '/../..' . '/includes/components/TableRow.php',
        'RWP\\Components\\TableSection' => __DIR__ . '/../..' . '/includes/components/TableSection.php',
        'RWP\\Engine\\Abstracts\\Collector' => __DIR__ . '/../..' . '/includes/engine/Abstracts/Collector.php',
        'RWP\\Engine\\Abstracts\\DebugOutput' => __DIR__ . '/../..' . '/includes/engine/Abstracts/DebugOutput.php',
        'RWP\\Engine\\Abstracts\\PostType' => __DIR__ . '/../..' . '/includes/engine/Abstracts/PostType.php',
        'RWP\\Engine\\Abstracts\\Shortcode' => __DIR__ . '/../..' . '/includes/engine/Abstracts/Shortcode.php',
        'RWP\\Engine\\Abstracts\\Singleton' => __DIR__ . '/../..' . '/includes/engine/Abstracts/Singleton.php',
        'RWP\\Engine\\Abstracts\\Taxonomy' => __DIR__ . '/../..' . '/includes/engine/Abstracts/Taxonomy.php',
        'RWP\\Engine\\Abstracts\\Widget' => __DIR__ . '/../..' . '/includes/engine/Abstracts/Widget.php',
        'RWP\\Engine\\Initialize' => __DIR__ . '/../..' . '/includes/engine/Initialize.php',
        'RWP\\Engine\\Interfaces\\Component' => __DIR__ . '/../..' . '/includes/engine/Interfaces/Component.php',
        'RWP\\Engine\\Interfaces\\Core' => __DIR__ . '/../..' . '/includes/engine/Interfaces/Core.php',
        'RWP\\Engine\\Is_Methods' => __DIR__ . '/../..' . '/includes/engine/Is_Methods.php',
        'RWP\\Engine\\Plugin' => __DIR__ . '/../..' . '/includes/engine/Plugin.php',
        'RWP\\Engine\\Traits\\Assets' => __DIR__ . '/../..' . '/includes/engine/Traits/Assets.php',
        'RWP\\Engine\\Traits\\Helpers' => __DIR__ . '/../..' . '/includes/engine/Traits/Helpers.php',
        'RWP\\Frontend\\Enqueue' => __DIR__ . '/../..' . '/includes/frontend/Enqueue.php',
        'RWP\\Frontend\\Extras\\Body_Class' => __DIR__ . '/../..' . '/includes/frontend/Extras/Body_Class.php',
        'RWP\\Frontend\\Extras\\Clean_Up' => __DIR__ . '/../..' . '/includes/frontend/Extras/Clean_Up.php',
        'RWP\\Frontend\\Extras\\JS_Footer' => __DIR__ . '/../..' . '/includes/frontend/Extras/JS_Footer.php',
        'RWP\\Frontend\\Extras\\Nice_Search' => __DIR__ . '/../..' . '/includes/frontend/Extras/Nice_Search.php',
        'RWP\\Frontend\\Favicons' => __DIR__ . '/../..' . '/includes/frontend/Favicons.php',
        'RWP\\Integrations\\ACF' => __DIR__ . '/../..' . '/includes/integrations/ACF.php',
        'RWP\\Integrations\\Bootstrap' => __DIR__ . '/../..' . '/includes/integrations/Bootstrap.php',
        'RWP\\Integrations\\BugHerd' => __DIR__ . '/../..' . '/includes/integrations/BugHerd.php',
        'RWP\\Integrations\\Elementor' => __DIR__ . '/../..' . '/includes/integrations/Elementor.php',
        'RWP\\Integrations\\Elementor\\OEmbed' => __DIR__ . '/../..' . '/includes/integrations/Elementor/OEmbed.php',
        'RWP\\Integrations\\GravityForms' => __DIR__ . '/../..' . '/includes/integrations/GravityForms.php',
        'RWP\\Integrations\\Gutenberg' => __DIR__ . '/../..' . '/includes/integrations/Gutenberg.php',
        'RWP\\Integrations\\JS_Plugins' => __DIR__ . '/../..' . '/includes/integrations/JS_Plugins.php',
        'RWP\\Integrations\\Lazysizes' => __DIR__ . '/../..' . '/includes/integrations/Lazysizes.php',
        'RWP\\Integrations\\Nav_Menus' => __DIR__ . '/../..' . '/includes/integrations/Nav_Menus.php',
        'RWP\\Integrations\\QM' => __DIR__ . '/../..' . '/includes/integrations/QM.php',
        'RWP\\Integrations\\QM\\Collectors\\Debug' => __DIR__ . '/../..' . '/includes/integrations/QM/Collectors/Debug.php',
        'RWP\\Integrations\\QM\\Collectors\\Info' => __DIR__ . '/../..' . '/includes/integrations/QM/Collectors/Info.php',
        'RWP\\Integrations\\QM\\Output\\Debug' => __DIR__ . '/../..' . '/includes/integrations/QM/Output/Debug.php',
        'RWP\\Integrations\\QM\\Output\\Info' => __DIR__ . '/../..' . '/includes/integrations/QM/Output/Info.php',
        'RWP\\Integrations\\Walkers\\Nav' => __DIR__ . '/../..' . '/includes/integrations/Walkers/Nav.php',
        'RWP\\Integrations\\Wistia' => __DIR__ . '/../..' . '/includes/integrations/Wistia.php',
        'RWP\\Integrations\\Yoast' => __DIR__ . '/../..' . '/includes/integrations/Yoast.php',
        'RWP\\Integrations\\Yoast\\Locations' => __DIR__ . '/../..' . '/includes/integrations/Yoast/Locations.php',
        'RWP\\Internals\\CustomBulkAction' => __DIR__ . '/../..' . '/includes/internals/CustomBulkAction.php',
        'RWP\\Internals\\PageForPostType' => __DIR__ . '/../..' . '/includes/internals/PageForPostType.php',
        'RWP\\Internals\\PostTypes' => __DIR__ . '/../..' . '/includes/internals/PostTypes.php',
        'RWP\\Internals\\PostTypes\\GlobalBlock' => __DIR__ . '/../..' . '/includes/internals/PostTypes/GlobalBlock.php',
        'RWP\\Internals\\PostTypes\\LandingPage' => __DIR__ . '/../..' . '/includes/internals/PostTypes/LandingPage.php',
        'RWP\\Internals\\PostTypes\\PageHeader' => __DIR__ . '/../..' . '/includes/internals/PostTypes/PageHeader.php',
        'RWP\\Internals\\PostTypes\\TeamMember' => __DIR__ . '/../..' . '/includes/internals/PostTypes/TeamMember.php',
        'RWP\\Internals\\PostTypes\\Testimonial' => __DIR__ . '/../..' . '/includes/internals/PostTypes/Testimonial.php',
        'RWP\\Internals\\Relative_Urls' => __DIR__ . '/../..' . '/includes/internals/Relative_Urls.php',
        'RWP\\Internals\\SVG\\Attributes' => __DIR__ . '/../..' . '/includes/internals/SVG/Attributes.php',
        'RWP\\Internals\\SVG\\Data\\AllowedAttributes' => __DIR__ . '/../..' . '/includes/internals/SVG/Data/AllowedAttributes.php',
        'RWP\\Internals\\SVG\\Data\\AllowedTags' => __DIR__ . '/../..' . '/includes/internals/SVG/Data/AllowedTags.php',
        'RWP\\Internals\\SVG\\Data\\AttributeInterface' => __DIR__ . '/../..' . '/includes/internals/SVG/Data/AttributeInterface.php',
        'RWP\\Internals\\SVG\\Data\\TagInterface' => __DIR__ . '/../..' . '/includes/internals/SVG/Data/TagInterface.php',
        'RWP\\Internals\\SVG\\Data\\XPath' => __DIR__ . '/../..' . '/includes/internals/SVG/Data/XPath.php',
        'RWP\\Internals\\SVG\\ElementReference\\Resolver' => __DIR__ . '/../..' . '/includes/internals/SVG/ElementReference/Resolver.php',
        'RWP\\Internals\\SVG\\ElementReference\\Subject' => __DIR__ . '/../..' . '/includes/internals/SVG/ElementReference/Subject.php',
        'RWP\\Internals\\SVG\\ElementReference\\Usage' => __DIR__ . '/../..' . '/includes/internals/SVG/ElementReference/Usage.php',
        'RWP\\Internals\\SVG\\Exceptions\\NestingException' => __DIR__ . '/../..' . '/includes/internals/SVG/Exceptions/NestingException.php',
        'RWP\\Internals\\SVG\\Helper' => __DIR__ . '/../..' . '/includes/internals/SVG/Helper.php',
        'RWP\\Internals\\SVG\\Sanitizer' => __DIR__ . '/../..' . '/includes/internals/SVG/Sanitizer.php',
        'RWP\\Internals\\SVG\\Tags' => __DIR__ . '/../..' . '/includes/internals/SVG/Tags.php',
        'RWP\\Internals\\SVGs' => __DIR__ . '/../..' . '/includes/internals/SVGs.php',
        'RWP\\Internals\\Shortcodes\\Button' => __DIR__ . '/../..' . '/includes/internals/Shortcodes/Button.php',
        'RWP\\Internals\\Shortcodes\\Copyright' => __DIR__ . '/../..' . '/includes/internals/Shortcodes/Copyright.php',
        'RWP\\Internals\\Shortcodes\\Location' => __DIR__ . '/../..' . '/includes/internals/Shortcodes/Location.php',
        'RWP\\Internals\\Shortcodes\\SiblingGrid' => __DIR__ . '/../..' . '/includes/internals/Shortcodes/SiblingGrid.php',
        'RWP\\Internals\\Shortcodes\\SubpageGrid' => __DIR__ . '/../..' . '/includes/internals/Shortcodes/SubpageGrid.php',
        'RWP\\Internals\\Shortcodes\\TeamGrid' => __DIR__ . '/../..' . '/includes/internals/Shortcodes/TeamGrid.php',
        'RWP\\Internals\\Taxonomies' => __DIR__ . '/../..' . '/includes/internals/Taxonomies.php',
        'RWP\\Internals\\Taxonomies\\TeamCategory' => __DIR__ . '/../..' . '/includes/internals/Taxonomies/TeamCategory.php',
        'RWP\\Internals\\Transient' => __DIR__ . '/../..' . '/includes/internals/Transient.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9447bd3be82ac6ba9b952bbc04749a69::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9447bd3be82ac6ba9b952bbc04749a69::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9447bd3be82ac6ba9b952bbc04749a69::$classMap;

        }, null, ClassLoader::class);
    }
}
