<?php

namespace Core\Infrastructure\Messaging\Kafka;

use Illuminate\Support\Facades\Log;

class KafkaLog
{
    public static function info(string $topic, string $result): void
    {
        Log::channel('stderr')->info(
            json_encode([
                'kafkaTopic' => $topic,
                'result' => $result
            ])
        );
    }

    public static function error(string $topic, string $error): void
    {
        Log::channel('stderr')->error(
            json_encode([
                'kafkaTopic' => $topic,
                'result' => $error
            ])
        );
    }
}
