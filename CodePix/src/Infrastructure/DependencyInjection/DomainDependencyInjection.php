<?php

namespace Core\Infrastructure\DependencyInjection;

use Carbon\Laravel\ServiceProvider;
use Core\Domain\Shared\Service\AMQPInterface;
use Core\Infrastructure\AMQP\Kafka\RdKafkaService;

class DomainDependencyInjection extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AMQPInterface::class, RdKafkaService::class);
    }

    public function boot()
    {
        //
    }
}
