<?php
$dsn = "mysql:dbname=emphloyer_example;host=localhost";
$user = getenv("DB_USER");
$password = getenv("DB_PWD");
$pipelineBackend = new \Emphloyer\Pdo\PipelineBackend($dsn, $user, $password, array(), "test_jobs");
$schedulerBackend = new \Emphloyer\Pdo\SchedulerBackend($dsn, $user, $password, array(), "test_scheduled_jobs");
$employees = array(
  array('employees' => getenv('REGULAR_WORKERS'), 'exclude' => array('priority')),
  array('employees' => getenv('PRIORITY_WORKERS'), 'only' => array('priority')),
);
