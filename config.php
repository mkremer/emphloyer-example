<?php

declare(strict_types=1);

use Emphloyer\Pdo\PipelineBackend;
use Emphloyer\Pdo\SchedulerBackend;

$dsn              = 'mysql:dbname=emphloyer_example;host=localhost';
$user             = getenv('DB_USER');
$password         = getenv('DB_PWD');
$pipelineBackend  = new PipelineBackend($dsn, $user, $password, [], 'test_jobs');
$schedulerBackend = new SchedulerBackend($dsn, $user, $password, [], 'test_scheduled_jobs');
$employees        = [
    ['employees' => getenv('REGULAR_WORKERS'), 'exclude' => ['priority']],
    ['employees' => getenv('PRIORITY_WORKERS'), 'only' => ['priority']],
];
