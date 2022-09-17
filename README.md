# RIESTERWP Core

An internal plugin for websites created by RIESTER to enhance functionality

[![GPLv2 License][license-img]][license-url][![Issues][issues-img]][issues-url][![Semantic Release][semantic-release-img]][semantic-release-url]![Requires WordPress v5.6][requires-wp]![Tested up to WordPress v6.0.1][tested-wp]

[license-img]: https://img.shields.io/badge/License-GPLv2-green.svg
[license-url]:http://www.gnu.org/licenses/gpl-2.0.txt
[issues-img]: https://img.shields.io/bitbucket/issues/riester/rwp?logo=bitbucket
[issues-url]: https://bitbucket.org/riester/rwp/issues
[semantic-release-img]: https://img.shields.io/badge/semantic--release-conventionalcommits-e10079?logo=semantic-release
[semantic-release-url]: https://github.com/semantic-release/semantic-release
[requires-wp]: https://img.shields.io/badge/wordpress-v5.6-blue?logo=wordpress
[tested-wp]: https://img.shields.io/badge/wordpress-v6.0.1%20tested-blue?logo=wordpress

## Project Structure
.
├── dependencies
├── includes
│   ├── config
│   │   ├── acf
│   │   │   ├── group_cpt_team_member_options.php
│   │   │   ├── group_cpt_testimonial_options.php
│   │   │   ├── group_nav_item_options.php
│   │   │   ├── group_nav_options.php
│   │   │   ├── group_reusable_fields.php
│   │   │   ├── group_rwp_company_info.php
│   │   │   ├── group_rwp_plugin_options.php
│   │   │   └── group_rwp_reusable_fields.php
│   │   ├── assets.php
│   │   └── tinymce.php
│   ├── core
│   │   ├── ajax
│   │   │   ├── Ajax_Admin.php
│   │   │   └── Ajax.php
│   │   ├── backend
│   │   │   ├── Enqueue.php
│   │   │   ├── Notices.php
│   │   │   └── Settings.php
│   │   ├── base
│   │   │   ├── Component.php
│   │   │   ├── Singleton.php
│   │   │   └── Widget.php
│   │   ├── frontend
│   │   │   ├── Extras
│   │   │   │   ├── Body_Class.php
│   │   │   │   ├── Clean_Up.php
│   │   │   │   ├── JS_Footer.php
│   │   │   │   └── Nice_Search.php
│   │   │   ├── Enqueue.php
│   │   │   └── Favicons.php
│   │   ├── helpers
│   │   │   ├── Assets.php
│   │   │   ├── Collection.php
│   │   │   ├── Components.php
│   │   │   ├── Context.php
│   │   │   ├── index.php
│   │   │   ├── Pluralizer.php
│   │   │   ├── Request.php
│   │   │   ├── Str.php
│   │   │   └── Utils.php
│   │   ├── html
│   │   │   ├── Button.php
│   │   │   ├── Card.php
│   │   │   ├── Column.php
│   │   │   ├── Container.php
│   │   │   ├── Element.php
│   │   │   ├── Embed.php
│   │   │   ├── Grid.php
│   │   │   ├── Group.php
│   │   │   ├── Html.php
│   │   │   ├── HtmlList.php
│   │   │   ├── Icon.php
│   │   │   ├── Image.php
│   │   │   ├── Location.php
│   │   │   ├── Modal.php
│   │   │   ├── Nav.php
│   │   │   ├── NavItem.php
│   │   │   ├── NavList.php
│   │   │   ├── PostCard.php
│   │   │   ├── Row.php
│   │   │   ├── Section.php
│   │   │   ├── SVG.php
│   │   │   ├── Table.php
│   │   │   ├── TableCell.php
│   │   │   ├── TableRow.php
│   │   │   └── TableSection.php
│   │   ├── integrations
│   │   │   ├── Elementor
│   │   │   │   ├── Widgets
│   │   │   │   │   └── OEmbed.php
│   │   │   │   └── Elementor.php
│   │   │   ├── QM
│   │   │   │   ├── Collectors
│   │   │   │   │   ├── Collector.php
│   │   │   │   │   ├── Debug.php
│   │   │   │   │   └── Info.php
│   │   │   │   ├── Output
│   │   │   │   │   ├── Debug.php
│   │   │   │   │   ├── Info.php
│   │   │   │   │   └── Output.php
│   │   │   │   └── QM.php
│   │   │   ├── Walkers
│   │   │   │   └── Nav.php
│   │   │   ├── Yoast
│   │   │   │   ├── Generators
│   │   │   │   │   └── Locations.php
│   │   │   │   └── Yoast.php
│   │   │   ├── ACF.php
│   │   │   ├── Bootstrap.php
│   │   │   ├── BugHerd.php
│   │   │   ├── GravityForms.php
│   │   │   ├── Gutenberg.php
│   │   │   ├── index.php
│   │   │   ├── JS_Plugins.php
│   │   │   ├── Lazysizes.php
│   │   │   ├── Nav_Menus.php
│   │   │   └── Wistia.php
│   │   └── internals
│   │       ├── PostTypes
│   │       │   ├── Types
│   │       │   │   ├── GlobalBlock.php
│   │       │   │   ├── LandingPage.php
│   │       │   │   ├── PageHeader.php
│   │       │   │   ├── PostType.php
│   │       │   │   ├── TeamMember.php
│   │       │   │   └── Testimonial.php
│   │       │   └── PostTypes.php
│   │       ├── Shortcodes
│   │       │   ├── Button.php
│   │       │   ├── Copyright.php
│   │       │   ├── Location.php
│   │       │   ├── Shortcode.php
│   │       │   ├── SiblingGrid.php
│   │       │   ├── SubpageGrid.php
│   │       │   └── TeamGrid.php
│   │       ├── SVG
│   │       │   ├── Data
│   │       │   │   ├── AllowedAttributes.php
│   │       │   │   ├── AllowedTags.php
│   │       │   │   ├── AttributeInterface.php
│   │       │   │   ├── TagInterface.php
│   │       │   │   └── XPath.php
│   │       │   ├── ElementReference
│   │       │   │   ├── Resolver.php
│   │       │   │   ├── Subject.php
│   │       │   │   └── Usage.php
│   │       │   ├── Exceptions
│   │       │   │   └── NestingException.php
│   │       │   ├── Attributes.php
│   │       │   ├── Helper.php
│   │       │   ├── Sanitizer.php
│   │       │   ├── svg-scanner.php
│   │       │   └── Tags.php
│   │       ├── Taxonomies
│   │       │   ├── Types
│   │       │   │   ├── Taxonomy.php
│   │       │   │   └── TeamCategory.php
│   │       │   └── Taxonomies.php
│   │       ├── CustomBulkAction.php
│   │       ├── index.php
│   │       ├── PageForPostType.php
│   │       ├── Relative_Urls.php
│   │       ├── SVGs.php
│   │       └── Transient.php
│   ├── functions
│   │   ├── utils
│   │   │   ├── acf.php
│   │   │   ├── array.php
│   │   │   ├── cache.php
│   │   │   ├── company.php
│   │   │   ├── debug.php
│   │   │   ├── file.php
│   │   │   ├── html.php
│   │   │   ├── image.php
│   │   │   ├── menu.php
│   │   │   ├── object.php
│   │   │   ├── post.php
│   │   │   ├── rest.php
│   │   │   ├── string.php
│   │   │   ├── theme.php
│   │   │   └── url.php
│   │   ├── filters.php
│   │   ├── helpers.php
│   │   └── utils.php
│   ├── autoloader.php
│   ├── index.php
│   └── plugin.php
├── rwp.php
└── uninstall.php

## Installation

## License

[GPL v2][license-url]

## Changelog

For latest updates, check out the [Changelog](CHANGELOG.md)
