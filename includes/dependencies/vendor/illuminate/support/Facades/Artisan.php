<?php

namespace RWP\Vendor\Illuminate\Support\Facades;

use RWP\Vendor\Illuminate\Contracts\Console\Kernel as ConsoleKernelContract;
/**
 * @method staticPendingDispatch queue(string $command, array $parameters = [])
 * @method static \Illuminate\Foundation\Console\ClosureCommand command(string $command, callable $callback)
 * @method static array all()
 * @method static int call(string $command, array $parameters = [], \Symfony\Component\Console\Output\OutputInterface|null $outputBuffer = null)
 * @method static int handle(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface|null $output = null)
 * @method static string output()
 * @method static void terminate(\Symfony\Component\Console\Input\InputInterface $input, int $status)
 *
 * @seeKernel
 */
class Artisan extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Kernel::class;
    }
}
