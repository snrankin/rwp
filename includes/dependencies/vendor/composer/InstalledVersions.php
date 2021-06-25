<?php

namespace Composer;

use Composer\Autoload\ClassLoader;
use Composer\Semver\VersionParser;

class InstalledVersions {
    private static $installed = array('root' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(), 'reference' => '1a51398e062e02cd9996044d5294cad4b041dda4', 'name' => 'rwp/plugin'), 'versions' => array('brain/hierarchy' => array('pretty_version' => '2.5.0', 'version' => '2.5.0.0', 'aliases' => array(), 'reference' => 'd5d46c6a44f84e59384b0d4d61b27cb5b91bc523'), 'composer/installers' => array('pretty_version' => 'v1.11.0', 'version' => '1.11.0.0', 'aliases' => array(), 'reference' => 'ae03311f45dfe194412081526be2e003960df74b'), 'crazycodr/standard-exceptions' => array('pretty_version' => '2.4.3', 'version' => '2.4.3.0', 'aliases' => array(), 'reference' => '842242a1abb8b757abfd24c2dccc64bb821bf53f'), 'doctrine/inflector' => array('pretty_version' => '2.0.3', 'version' => '2.0.3.0', 'aliases' => array(), 'reference' => '9cf661f4eb38f7c881cac67c75ea9b00bf97b210'), 'illuminate/collections' => array('pretty_version' => 'v8.46.0', 'version' => '8.46.0.0', 'aliases' => array(), 'reference' => 'deccb956d38710f3f8baf36dd876c3fa1585ec22'), 'illuminate/config' => array('pretty_version' => 'v8.46.0', 'version' => '8.46.0.0', 'aliases' => array(), 'reference' => '8441c542312b4d57220b1f942b947b6517c05008'), 'illuminate/container' => array('pretty_version' => 'v8.46.0', 'version' => '8.46.0.0', 'aliases' => array(), 'reference' => '07342efca88cf9fff4f2fa0e3c378ea6ee86e5e2'), 'illuminate/contracts' => array('pretty_version' => 'v8.46.0', 'version' => '8.46.0.0', 'aliases' => array(), 'reference' => '199fcedc161ba4a0b83feaddc4629f395dbf1641'), 'illuminate/macroable' => array('pretty_version' => 'v8.46.0', 'version' => '8.46.0.0', 'aliases' => array(), 'reference' => '300aa13c086f25116b5f3cde3ca54ff5c822fb05'), 'illuminate/support' => array('pretty_version' => 'v8.46.0', 'version' => '8.46.0.0', 'aliases' => array(), 'reference' => '79e1ec26d58426e4f06e5b548712a8a6dc1ffdca'), 'inpsyde/cpt-archives' => array('pretty_version' => '0.1.1', 'version' => '0.1.1.0', 'aliases' => array(), 'reference' => '6cb4172b3db8226f6ee32fe5d00a6a40ce95c391'), 'johnbillion/extended-cpts' => array('pretty_version' => '4.5.2', 'version' => '4.5.2.0', 'aliases' => array(), 'reference' => '59ce9f4e0422512eec6f698ccba4a6a81b018fdb'), 'micropackage/internationalization' => array('pretty_version' => '1.0.1', 'version' => '1.0.1.0', 'aliases' => array(), 'reference' => '8de158b8fc71557a8310f0d98d2b8ad9f4f44dd5'), 'micropackage/requirements' => array('pretty_version' => '1.0.3', 'version' => '1.0.3.0', 'aliases' => array(), 'reference' => '86ad5fcfdbe2c89eaab4c0895d122957fde1de82'), 'mrclay/jsmin-php' => array('pretty_version' => '2.4.0', 'version' => '2.4.0.0', 'aliases' => array(), 'reference' => 'bb05febc9440852d39899255afd5569b7f21a72c'), 'nesbot/carbon' => array('pretty_version' => '2.49.0', 'version' => '2.49.0.0', 'aliases' => array(), 'reference' => '93d9db91c0235c486875d22f1e08b50bdf3e6eee'), 'oomphinc/composer-installers-extender' => array('pretty_version' => '2.0.0', 'version' => '2.0.0.0', 'aliases' => array(), 'reference' => '8d3fe38a1723e0e91076920c8bb946b1696e28ca'), 'psr/container' => array('pretty_version' => '1.1.1', 'version' => '1.1.1.0', 'aliases' => array(), 'reference' => '8622567409010282b7aeebe4bb841fe98b58dcaf'), 'psr/container-implementation' => array('provided' => array(0 => '1.0')), 'psr/log' => array('pretty_version' => '1.1.4', 'version' => '1.1.4.0', 'aliases' => array(), 'reference' => 'd49695b909c3b7628b6289db5479a1c204601f11'), 'psr/simple-cache' => array('pretty_version' => '1.0.1', 'version' => '1.0.1.0', 'aliases' => array(), 'reference' => '408d5eafb83c57f6365a3ca330ff23aa4a5fa39b'), 'roundcube/plugin-installer' => array('replaced' => array(0 => '*')), 'rwp/plugin' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(), 'reference' => '1a51398e062e02cd9996044d5294cad4b041dda4'), 'seravo/wp-custom-bulk-actions' => array('pretty_version' => '0.1.4', 'version' => '0.1.4.0', 'aliases' => array(), 'reference' => 'b31da03919186b1065616743a54995b7e4f29d4a'), 'shama/baton' => array('replaced' => array(0 => '*')), 'stevegrunwell/wp-cache-remember' => array('pretty_version' => 'v1.1.1', 'version' => '1.1.1.0', 'aliases' => array(), 'reference' => 'f37b8e79d9cb05f5fd0e8035b0ffecbb1ded182e'), 'symfony/css-selector' => array('pretty_version' => 'v5.3.0', 'version' => '5.3.0.0', 'aliases' => array(), 'reference' => 'fcd0b29a7a0b1bb5bfbedc6231583d77fea04814'), 'symfony/deprecation-contracts' => array('pretty_version' => 'v2.4.0', 'version' => '2.4.0.0', 'aliases' => array(), 'reference' => '5f38c8804a9e97d23e0c8d63341088cd8a22d627'), 'symfony/dom-crawler' => array('pretty_version' => 'v5.3.0', 'version' => '5.3.0.0', 'aliases' => array(), 'reference' => '55fff62b19f413f897a752488ade1bc9c8a19cdd'), 'symfony/error-handler' => array('pretty_version' => 'v5.3.0', 'version' => '5.3.0.0', 'aliases' => array(), 'reference' => '0e6768b8c0dcef26df087df2bbbaa143867a59b2'), 'symfony/filesystem' => array('pretty_version' => 'v5.3.0', 'version' => '5.3.0.0', 'aliases' => array(), 'reference' => '348116319d7fb7d1faa781d26a48922428013eb2'), 'symfony/finder' => array('pretty_version' => 'v5.3.0', 'version' => '5.3.0.0', 'aliases' => array(), 'reference' => '0ae3f047bed4edff6fd35b26a9a6bfdc92c953c6'), 'symfony/http-foundation' => array('pretty_version' => 'v5.3.1', 'version' => '5.3.1.0', 'aliases' => array(), 'reference' => '8827b90cf8806e467124ad476acd15216c2fceb6'), 'symfony/options-resolver' => array('pretty_version' => 'v5.3.0', 'version' => '5.3.0.0', 'aliases' => array(), 'reference' => '162e886ca035869866d233a2bfef70cc28f9bbe5'), 'symfony/polyfill-ctype' => array('pretty_version' => 'v1.23.0', 'version' => '1.23.0.0', 'aliases' => array(), 'reference' => '46cd95797e9df938fdd2b03693b5fca5e64b01ce'), 'symfony/polyfill-mbstring' => array('pretty_version' => 'v1.23.0', 'version' => '1.23.0.0', 'aliases' => array(), 'reference' => '2df51500adbaebdc4c38dea4c89a2e131c45c8a1'), 'symfony/polyfill-php73' => array('pretty_version' => 'v1.23.0', 'version' => '1.23.0.0', 'aliases' => array(), 'reference' => 'fba8933c384d6476ab14fb7b8526e5287ca7e010'), 'symfony/polyfill-php80' => array('pretty_version' => 'v1.23.0', 'version' => '1.23.0.0', 'aliases' => array(), 'reference' => 'eca0bf41ed421bed1b57c4958bab16aa86b757d0'), 'symfony/translation' => array('pretty_version' => 'v5.3.0', 'version' => '5.3.0.0', 'aliases' => array(), 'reference' => '251de0d921c42ef0a81494d8f37405421deefdf6'), 'symfony/translation-contracts' => array('pretty_version' => 'v2.4.0', 'version' => '2.4.0.0', 'aliases' => array(), 'reference' => '95c812666f3e91db75385749fe219c5e494c7f95'), 'symfony/translation-implementation' => array('provided' => array(0 => '2.3')), 'symfony/var-dumper' => array('pretty_version' => 'v5.3.0', 'version' => '5.3.0.0', 'aliases' => array(), 'reference' => '1d3953e627fe4b5f6df503f356b6545ada6351f3'), 'tubalmartin/cssmin' => array('pretty_version' => 'v4.1.1', 'version' => '4.1.1.0', 'aliases' => array(), 'reference' => '3cbf557f4079d83a06f9c3ff9b957c022d7805cf'), 'voku/portable-ascii' => array('pretty_version' => '1.5.6', 'version' => '1.5.6.0', 'aliases' => array(), 'reference' => '80953678b19901e5165c56752d087fc11526017c'), 'wa72/html-pretty-min' => array('pretty_version' => 'v0.2.0', 'version' => '0.2.0.0', 'aliases' => array(), 'reference' => '3b4eca03559dab8c178ec7a80f3043c279f5e90e'), 'wa72/htmlpagedom' => array('pretty_version' => 'v2.0.1', 'version' => '2.0.1.0', 'aliases' => array(), 'reference' => '34710d592b9865e798b5c35a78166ab1f18ecc8e'), 'wikimedia/composer-merge-plugin' => array('pretty_version' => 'v2.0.1', 'version' => '2.0.1.0', 'aliases' => array(), 'reference' => '8ca2ed8ab97c8ebce6b39d9943e9909bb4f18912'), 'wpdesk/wp-builder' => array('pretty_version' => '1.4.4', 'version' => '1.4.4.0', 'aliases' => array(), 'reference' => 'e18df43bc3bc047c7bc0ed3e52eabb16118f4bc9'), 'wpdesk/wp-notice' => array('pretty_version' => '3.1.3', 'version' => '3.1.3.0', 'aliases' => array(), 'reference' => 'bd062f56852a6206ae23f0c635ee7c97aa553438'), 'yahnis-elsts/plugin-update-checker' => array('pretty_version' => 'v4.11', 'version' => '4.11.0.0', 'aliases' => array(), 'reference' => '3155f2d3f1ca5e7ed3f25b256f020e370515af43'), 'yoast/i18n-module' => array('pretty_version' => '3.1.1', 'version' => '3.1.1.0', 'aliases' => array(), 'reference' => '9d0a2f6daea6fb42376b023e7778294d19edd85d')));
    private static $canGetVendors;
    private static $installedByVendor = array();
    public static function getInstalledPackages() {
        $packages = array();
        foreach (self::getInstalled() as $installed) {
            $packages[] = \array_keys($installed['versions']);
        }
        if (1 === \count($packages)) {
            return $packages[0];
        }
        return \array_keys(\array_flip(\call_user_func_array('array_merge', $packages)));
    }
    public static function isInstalled($packageName) {
        foreach (self::getInstalled() as $installed) {
            if (isset($installed['versions'][$packageName])) {
                return \true;
            }
        }
        return \false;
    }
    public static function satisfies(\Composer\Semver\VersionParser $parser, $packageName, $constraint) {
        $constraint = $parser->parseConstraints($constraint);
        $provided = $parser->parseConstraints(self::getVersionRanges($packageName));
        return $provided->matches($constraint);
    }
    public static function getVersionRanges($packageName) {
        foreach (self::getInstalled() as $installed) {
            if (!isset($installed['versions'][$packageName])) {
                continue;
            }
            $ranges = array();
            if (isset($installed['versions'][$packageName]['pretty_version'])) {
                $ranges[] = $installed['versions'][$packageName]['pretty_version'];
            }
            if (\array_key_exists('aliases', $installed['versions'][$packageName])) {
                $ranges = \array_merge($ranges, $installed['versions'][$packageName]['aliases']);
            }
            if (\array_key_exists('replaced', $installed['versions'][$packageName])) {
                $ranges = \array_merge($ranges, $installed['versions'][$packageName]['replaced']);
            }
            if (\array_key_exists('provided', $installed['versions'][$packageName])) {
                $ranges = \array_merge($ranges, $installed['versions'][$packageName]['provided']);
            }
            return \implode(' || ', $ranges);
        }
        throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
    }
    public static function getVersion($packageName) {
        foreach (self::getInstalled() as $installed) {
            if (!isset($installed['versions'][$packageName])) {
                continue;
            }
            if (!isset($installed['versions'][$packageName]['version'])) {
                return null;
            }
            return $installed['versions'][$packageName]['version'];
        }
        throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
    }
    public static function getPrettyVersion($packageName) {
        foreach (self::getInstalled() as $installed) {
            if (!isset($installed['versions'][$packageName])) {
                continue;
            }
            if (!isset($installed['versions'][$packageName]['pretty_version'])) {
                return null;
            }
            return $installed['versions'][$packageName]['pretty_version'];
        }
        throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
    }
    public static function getReference($packageName) {
        foreach (self::getInstalled() as $installed) {
            if (!isset($installed['versions'][$packageName])) {
                continue;
            }
            if (!isset($installed['versions'][$packageName]['reference'])) {
                return null;
            }
            return $installed['versions'][$packageName]['reference'];
        }
        throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
    }
    public static function getRootPackage() {
        $installed = self::getInstalled();
        return $installed[0]['root'];
    }
    public static function getRawData() {
        @\trigger_error('getRawData only returns the first dataset loaded, which may not be what you expect. Use getAllRawData() instead which returns all datasets for all autoloaders present in the process.', \E_USER_DEPRECATED);
        return self::$installed;
    }
    public static function getAllRawData() {
        return self::getInstalled();
    }
    public static function reload($data) {
        self::$installed = $data;
        self::$installedByVendor = array();
    }
    private static function getInstalled() {
        if (null === self::$canGetVendors) {
            self::$canGetVendors = \method_exists('RWP\\Vendor\\Composer\\Autoload\\ClassLoader', 'getRegisteredLoaders');
        }
        $installed = array();
        if (self::$canGetVendors) {
            foreach (\Composer\Autoload\ClassLoader::getRegisteredLoaders() as $vendorDir => $loader) {
                if (isset(self::$installedByVendor[$vendorDir])) {
                    $installed[] = self::$installedByVendor[$vendorDir];
                } elseif (\is_file($vendorDir . '/composer/installed.php')) {
                    $installed[] = self::$installedByVendor[$vendorDir] = (require $vendorDir . '/composer/installed.php');
                }
            }
        }
        $installed[] = self::$installed;
        return $installed;
    }
}
