<?php
require_once __DIR__ . "/vendor/autoload.php";

$dsn = "mysql:dbname=emphloyer_example;host=localhost";
$user = getenv("DB_USER");
$password = getenv("DB_PWD");

$pdo = new \PDO($dsn, $user, $password);
$pdo->exec("DROP TABLE IF EXISTS emphloyer_jobs");
$pdo->exec("DROP TABLE IF EXISTS emphloyer_scheduled_jobs");
$pdo->exec('CREATE table emphloyer_jobs (uuid VARCHAR(36) PRIMARY KEY, created_at TIMESTAMP, run_from TIMESTAMP NULL DEFAULT NULL, locked_at TIMESTAMP NULL DEFAULT NULL, lock_uuid VARCHAR(36) UNIQUE, status VARCHAR(20), class_name VARCHAR(255), type VARCHAR(100), attributes TEXT);');
$pdo->exec("CREATE table emphloyer_scheduled_jobs ( id INT AUTO_INCREMENT, uuid VARCHAR(36) UNIQUE, created_at TIMESTAMP, locked_at TIMESTAMP NULL DEFAULT NULL, lock_uuid VARCHAR(36), class_name VARCHAR(255), attributes TEXT, minute TINYINT(1) DEFAULT NULL, hour TINYINT(1) DEFAULT NULL, monthday TINYINT(1) DEFAULT NULL, month TINYINT(1) DEFAULT NULL, weekday TINYINT(1) DEFAULT NULL, PRIMARY KEY (id));");
$pdo->exec("DROP TABLE IF EXISTS things");
$pdo->exec("CREATE TABLE things (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(100), created_at TIMESTAMP)");

// Run one job every minute through the scheduler
$job = new Emphloyer\Example\MakeThingJob("Scheduled");
$job->setType("priority");
$scheduler = new \Emphloyer\Scheduler(new \Emphloyer\Pdo\SchedulerBackend($dsn, $user, $password));
$scheduler->schedule($job);

$pipeline = new \Emphloyer\Pipeline(new \Emphloyer\Pdo\PipelineBackend($dsn, $user, $password));

for ($i = 1; $i <= 100; $i++) {
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
