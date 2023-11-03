<?php

namespace Core\Infrastructure\Messaging\Kafka;
use RdKafka\Conf;

class ConfKafka
{
    public static function connect()
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', config('microservices.kafka.config.brokerList'));

        return $conf;
    }

    public static function connectConsumer(): Conf
    {
        $conf = self::connect();

        $config = config('microservices.kafka.config');
        $conf->set('group.id', $config['id']);
        $conf->set('auto.offset.reset', $config['offsetReset']);
        $conf->set('enable.auto.commit', $config['autoCommit']);
        $conf->set('enable.partition.eof', $config['eof']);

        return $conf;
    }
}
