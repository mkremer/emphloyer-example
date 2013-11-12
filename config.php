<?php
$dsn = "mysql:dbname=emphloyer_example;host=localhost";
$user = getenv("DB_USER");
$password = getenv("DB_PWD");
$pipelineBackend = new \Emphloyer\Pdo\PipelineBackend($dsn, $user, $password);
$numberOfEmployees = getenv('WORKERS');
?>
