<?php

namespace Core\Infrastructure\Messaging\Kafka\Subscriber;

use Core\Domain\Shared\Messaging\Subscriber\SubscriberInterface;
use Core\Infrastructure\Messaging\Kafka\ConfKafka;
use Core\Infrastructure\Messaging\Kafka\Factory\ProcessMessagesFactory;
use Core\Infrastructure\Messaging\Kafka\ProcessMessageInterface;
use RdKafka\KafkaConsumer;
use RdKafka\Message;

class RdKafkaSubscriber implements SubscriberInterface
{
    public function subscribe(array $topics): void
    {
        $consumer = new KafkaConsumer(ConfKafka::connectConsumer());
        $consumer->subscribe($topics);

        while (true) {
            $message = $consumer->consume(120 * 1000);
            switch ($message->err) {
                case RD_KAFKA_RESP_ERR_NO_ERROR:
                    $this->process(message: $message, consumer: $consumer);
                    break;
                case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                    echo "No more messages; will wait for more\n";
                    break;
                case RD_KAFKA_RESP_ERR__TIMED_OUT:
                    echo "Timed out\n";
                    break;
                default:
                    throw new \Exception($message->errstr(), $message->err);
            }
        }
    }

    protected function process(Message $message, KafkaConsumer $consumer): void
    {
        $factory = ProcessMessagesFactory::create(topic: $message->topic_name);
        if ($factory instanceof ProcessMessageInterface) {
            $factory->process($message);
            $consumer->commitAsync($message);
        }
    }
}
