<?php

return [
    'default'     => env('QUEUE_CONNECTION', 'sync'),
    'connections' => [
        'sync' => ['driver' => 'sync'],
        'database' => [
            'driver' => 'database',
            'connection' => env('DB_QUEUE_CONNECTION'),
            'table'      => env('DB_QUEUE_TABLE', 'job'),
            'queue'      => env('DB_QUEUE', 'default'),
            'retry_after' => (int) env('DB_QUEUE_RETRY_AFTER', 90),
            'after_commit' => false,
        ],
    ],
    'batching' => [
        'database' => env('DB_BATCH_CONNECTION'),
        'table'    => env('DB_BATCH_TABLE', 'job_batch'),
    ],
    'failed' => [
        'driver'   => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        'database' => env('DB_FAILED_CONNECTION'),
        'table'    => env('DB_FAILED_TABLE', 'failed_job'),
    ],
];
