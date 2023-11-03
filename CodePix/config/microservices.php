<?php

return [
    'topics' => explode(',', (string)env('KAFKA_TOPICS')),
    'kafka' => [
        'config' => [
            'id' => env('KAFKA_GROUP_ID', 'codepixstats'),
            'brokerList' =>  env('KAFKA_METADATA_BROKER_LIST', 'host.docker.internal:9092'),
            'offsetReset' =>  env('KAFKA_AUTO_OFFSET_RESET', 'earliest'),
            'autoCommit' =>  'false',
            'eof' =>  'true',
        ]
    ]
];
