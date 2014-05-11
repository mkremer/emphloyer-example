<?php
require_once __DIR__ . "/vendor/autoload.php";

$dsn = "mysql:dbname=emphloyer_example;host=localhost";
$user = getenv("DB_USER");
$password = getenv("DB_PWD");

$pdo = new \PDO($dsn, $user, $password);
$pdo->exec("DROP TABLE IF EXISTS emphloyer_jobs");
$pdo->exec("CREATE table emphloyer_jobs (uuid VARCHAR(36) PRIMARY KEY, created_at TIMESTAMP, locked_at TIMESTAMP, lock_uuid VARCHAR(36) UNIQUE, status VARCHAR(20), class_name VARCHAR(255), type VARCHAR(100), attributes TEXT)");
$pdo->exec("DROP TABLE IF EXISTS things");
$pdo->exec("CREATE TABLE things (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(100), created_at TIMESTAMP)");

$pipeline = new \Emphloyer\Pipeline(new \Emphloyer\Pdo\PipelineBackend($dsn, $user, $password));

for ($i = 1; $i <= 1000; $i++) {
  if (($i % 10) == 0) {
    $name = "Priority Thing {$i}";
    $job = new Emphloyer\Example\MakeThingJob($name);
    $job->setType('priority');
  } else {
    $name = "Regular Thing {$i}";
    $job = new Emphloyer\Example\MakeThingJob($name);
    $job->setType('regular');
  }
  $pipeline->enqueue($job);
}
