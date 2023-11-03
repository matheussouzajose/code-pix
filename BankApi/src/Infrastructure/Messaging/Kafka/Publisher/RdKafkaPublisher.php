<?php

namespace Core\Infrastructure\Messaging\Kafka\Publisher;

use Core\Domain\Shared\Messaging\Publisher\PublisherInterface;
use Core\Infrastructure\Messaging\Kafka\ConfKafka;
use Core\Infrastructure\Messaging\Kafka\KafkaLog;
use RdKafka\Producer;

class RdKafkaPublisher implements PublisherInterface
{
    public function publish(string $topic, string $message): void
    {
        $producer = new Producer(ConfKafka::connect());
        $newTopic = $producer->newTopic($topic);
        $newTopic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
        $producer->poll(0);

        $result = $producer->flush(10000);

        if ($result === RD_KAFKA_RESP_ERR_NO_ERROR) {
            KafkaLog::info(topic: $topic, result: $message);

            return;
        }

        KafkaLog::error(topic: $topic, error: 'Was unable to flush, messages might be lost!');
    }
}
