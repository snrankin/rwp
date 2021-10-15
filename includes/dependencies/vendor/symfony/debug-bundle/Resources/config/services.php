<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RWP\Vendor\Symfony\Component\DependencyInjection\Loader\Configurator;

use RWP\Vendor\Monolog\Formatter\FormatterInterface;
use RWP\Vendor\Symfony\Bridge\Monolog\Command\ServerLogCommand;
use RWP\Vendor\Symfony\Bridge\Monolog\Formatter\ConsoleFormatter;
use RWP\Vendor\Symfony\Bridge\Twig\Extension\DumpExtension;
use RWP\Vendor\Symfony\Component\HttpKernel\DataCollector\DumpDataCollector;
use RWP\Vendor\Symfony\Component\HttpKernel\EventListener\DumpListener;
use RWP\Vendor\Symfony\Component\VarDumper\Cloner\VarCloner;
use RWP\Vendor\Symfony\Component\VarDumper\Command\Descriptor\CliDescriptor;
use RWP\Vendor\Symfony\Component\VarDumper\Command\Descriptor\HtmlDescriptor;
use RWP\Vendor\Symfony\Component\VarDumper\Command\ServerDumpCommand;
use RWP\Vendor\Symfony\Component\VarDumper\Dumper\CliDumper;
use RWP\Vendor\Symfony\Component\VarDumper\Dumper\ContextProvider\CliContextProvider;
use RWP\Vendor\Symfony\Component\VarDumper\Dumper\ContextProvider\RequestContextProvider;
use RWP\Vendor\Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider;
use RWP\Vendor\Symfony\Component\VarDumper\Dumper\ContextualizedDumper;
use RWP\Vendor\Symfony\Component\VarDumper\Dumper\HtmlDumper;
use RWP\Vendor\Symfony\Component\VarDumper\Server\Connection;
use RWP\Vendor\Symfony\Component\VarDumper\Server\DumpServer;
return static function (ContainerConfigurator $container) {
    $container->parameters()->set('env(VAR_DUMPER_SERVER)', '127.0.0.1:9912');
    $container->services()->set('twig.extension.dump', Bridge\Twig\Extension\DumpExtension::class)->args([service('var_dumper.cloner'), service('var_dumper.html_dumper')])->tag('twig.extension')->set('data_collector.dump', DumpDataCollector::class)->public()->args([service('debug.stopwatch')->ignoreOnInvalid(), service('debug.file_link_formatter')->ignoreOnInvalid(), param('kernel.charset'), service('request_stack'), null])->tag('data_collector', ['id' => 'dump', 'template' => '@Debug/Profiler/dump.html.twig', 'priority' => 240])->set('debug.dump_listener', DumpListener::class)->args([service('var_dumper.cloner'), service('var_dumper.cli_dumper'), null])->tag('kernel.event_subscriber')->set('var_dumper.cloner', VarCloner::class)->public()->set('var_dumper.cli_dumper', CliDumper::class)->args([
        null,
        // debug.dump_destination,
        param('kernel.charset'),
        0,
    ])->set('var_dumper.contextualized_cli_dumper', ContextualizedDumper::class)->decorate('var_dumper.cli_dumper')->args([service('var_dumper.contextualized_cli_dumper.inner'), ['source' => inline_service(SourceContextProvider::class)->args([param('kernel.charset'), param('kernel.project_dir'), service('debug.file_link_formatter')->nullOnInvalid()])]])->set('var_dumper.html_dumper', HtmlDumper::class)->args([null, param('kernel.charset'), 0])->call('setDisplayOptions', [['fileLinkFormat' => service('debug.file_link_formatter')->ignoreOnInvalid()]])->set('var_dumper.server_connection', Connection::class)->args([
        '',
        // server host
        ['source' => inline_service(SourceContextProvider::class)->args([param('kernel.charset'), param('kernel.project_dir'), service('debug.file_link_formatter')->nullOnInvalid()]), 'request' => inline_service(RequestContextProvider::class)->args([service('request_stack')]), 'cli' => inline_service(CliContextProvider::class)],
    ])->set('var_dumper.dump_server', DumpServer::class)->args([
        '',
        // server host
        service('logger')->nullOnInvalid(),
    ])->tag('monolog.logger', ['channel' => 'debug'])->set('var_dumper.command.server_dump', ServerDumpCommand::class)->args([service('var_dumper.dump_server'), ['cli' => inline_service(CliDescriptor::class)->args([service('var_dumper.contextualized_cli_dumper.inner')]), 'html' => inline_service(HtmlDescriptor::class)->args([service('var_dumper.html_dumper')])]])->tag('console.command')->set('monolog.command.server_log', Bridge\Monolog\Command\ServerLogCommand::class);
    if (\class_exists(Bridge\Monolog\Formatter\ConsoleFormatter::class) && \interface_exists(Formatter\FormatterInterface::class)) {
        $container->services()->get('monolog.command.server_log')->tag('console.command');
    }
};
