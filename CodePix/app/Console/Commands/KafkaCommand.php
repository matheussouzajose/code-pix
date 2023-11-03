<?php

namespace App\Console\Commands;

use Core\Domain\Shared\Messaging\Subscriber\SubscriberInterface;
use Illuminate\Console\Command;

class KafkaCommand extends Command
{
    protected $signature = 'kafka:consumer';

    protected $description = 'Command description';

    public function __construct(protected SubscriberInterface $subscriber)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->subscriber->subscribe(topics: config('microservices.topics'));
    }
}
