<?php

/*
 * This file is part of the Hierarchy package.
 *
 * (c) Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RWP\Vendor\Brain\Hierarchy\Loader;

use RWP\Vendor\Brain\Hierarchy\FileExtensionPredicate;
/**
 * This is an aggregate loader that allow a different loader based on template file extension.
 * It requires a "map" of extension to loader to be passed to constructor.
 * The map keys are the  template file extensions, the values are the loader to be used.
 * Loader can be passed as:
 * - template loader instances
 * - template loader fully qualified class names
 * - factory callbacks that once called return template loader instances.
 *
 * The same loader can be used for multiple file extension, using as key a string of many extensions
 * separated by a pipe `|`.
 *
 * Example:
 *
 * <code>
 * $loader = new ExtensionMapTemplateLoader([
 *      'php|phtml' => new FileRequireLoader(),
 *      'mustache'  => function() {
 *          return new MyMustacheAdapter(new \Mustache_Engine);
 *       },
 *      'md'        => MyMarkdownRenderer::class
 * ]);
 * </code>
 *
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
final class ExtensionMapTemplateLoader implements  Loader\AggregateTemplateLoaderInterface
{
    /**
     * @var \Brain\Hierarchy\Loader\AggregateTemplateLoaderInterface
     */
    private $loader;
    /**
     * @param array                                                    $map
     * @param \Brain\Hierarchy\Loader\AggregateTemplateLoaderInterface $loader
     */
    public function __construct(array $map,  Loader\AggregateTemplateLoaderInterface $loader = null)
    {
        $this->loader = $loader ?: new  Loader\CascadeAggregateTemplateLoader();
        \array_walk($map, function ($loader, $extension) {
            $loader = $this->buildLoader($loader);
            if (!\is_null($loader)) {
                $predicate = new  FileExtensionPredicate($extension);
                $loader instanceof  Loader\TemplateLoaderInterface ? $this->loader->addLoader($loader, $predicate) : $this->loader->addLoaderFactory($loader, $predicate);
            }
        });
    }
    /**
     * {@inheritdoc}
     */
    public function load($templatePath)
    {
        return $this->loader->load($templatePath);
    }
    /**
     * {@inheritdoc}
     */
    public function addLoader( Loader\TemplateLoaderInterface $loader, callable $predicate)
    {
        return $this->loader->addLoader($loader, $predicate);
    }
    /**
     * {@inheritdoc}
     */
    public function addLoaderFactory(callable $loaderFactory, callable $predicate)
    {
        return $this->loader->addLoaderFactory($loaderFactory, $predicate);
    }
    /**
     * @param \Brain\Hierarchy\Loader\TemplateLoaderInterface|callable|string $loader
     *
     * @return \Closure|\Brain\Hierarchy\Loader\TemplateLoaderInterface
     */
    private function buildLoader($loader)
    {
        if ($loader instanceof  Loader\TemplateLoaderInterface || \is_callable($loader)) {
            return $loader;
        }
        if (\is_string($loader) && \is_subclass_of($loader,  Loader\TemplateLoaderInterface::class, \true)) {
            return function () use($loader) {
                return new $loader();
            };
        }
    }
}
