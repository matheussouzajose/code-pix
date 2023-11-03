<?php

namespace App\Providers;

use Core\Domain\Shared\Messaging\Publisher\PublisherInterface;
use Core\Domain\Shared\Messaging\Subscriber\SubscriberInterface;
use Core\Infrastructure\Messaging\Kafka\Publisher\RdKafkaPublisher;
use Core\Infrastructure\Messaging\Kafka\Subscriber\RdKafkaSubscriber;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PublisherInterface::class, RdKafkaPublisher::class);
        $this->app->singleton(SubscriberInterface::class, RdKafkaSubscriber::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
