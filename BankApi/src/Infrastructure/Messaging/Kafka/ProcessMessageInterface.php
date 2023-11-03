<?php

namespace Core\Infrastructure\Messaging\Kafka;

use RdKafka\Message;

interface ProcessMessageInterface
{
    public function process(Message $message);
}
