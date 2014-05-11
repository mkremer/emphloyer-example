<?php
$dsn = "mysql:dbname=emphloyer_example;host=localhost";
$user = getenv("DB_USER");
$password = getenv("DB_PWD");
$pipelineBackend = new \Emphloyer\Pdo\PipelineBackend($dsn, $user, $password);
$employees = array(
  array('employees' => getenv('REGULAR_WORKERS'), 'exclude' => array('priority')),
  array('employees' => getenv('PRIORITY_WORKERS'), 'only' => array('priority')),
);
