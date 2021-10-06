<?php

namespace RWP\Vendor\Illuminate\Support\Facades;

use RWP\Vendor\Illuminate\Notifications\AnonymousNotifiable;
use RWP\Vendor\Illuminate\Notifications\ChannelManager;
use RWP\Vendor\Illuminate\Support\Testing\Fakes\NotificationFake;
/**
 * @method staticChannelManager locale(string|null $locale)
 * @method static \Illuminate\Support\Collection sent(mixed $notifiable, string $notification, callable $callback = null)
 * @method static bool hasSent(mixed $notifiable, string $notification)
 * @method static mixed channel(string|null $name = null)
 * @method static void assertNotSentTo(mixed $notifiable, string|\Closure $notification, callable $callback = null)
 * @method static void assertNothingSent()
 * @method static void assertSentTo(mixed $notifiable, string|\Closure $notification, callable $callback = null)
 * @method static void assertSentToTimes(mixed $notifiable, string $notification, int $times = 1)
 * @method static void assertTimesSent(int $expectedCount, string $notification)
 * @method static void send(\Illuminate\Support\Collection|array|mixed $notifiables, $notification)
 * @method static void sendNow(\Illuminate\Support\Collection|array|mixed $notifiables, $notification)
 *
 * @seeChannelManager
 */
class Notification extends Facade
{
    /**
     * Replace the bound instance with a fake.
     *
     * @returnNotificationFake
     */
    public static function fake()
    {
        static::swap($fake = new NotificationFake());
        return $fake;
    }
    /**
     * Begin sending a notification to an anonymous notifiable.
     *
     * @param  string  $channel
     * @param  mixed  $route
     * @returnAnonymousNotifiable
     */
    public static function route($channel, $route)
    {
        return (new AnonymousNotifiable())->route($channel, $route);
    }
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ChannelManager::class;
    }
}
