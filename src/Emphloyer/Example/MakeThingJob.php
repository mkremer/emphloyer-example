<?php

namespace Emphloyer\Example;

class MakeThingJob extends \Emphloyer\AbstractJob {
  public function __construct($name = "") {
    $this->attributes['name'] = $name;
  }

  public function perform() {
    \Logger::getLogger(get_called_class())->info("Executing job, about to insert {$this->attributes['name']}");
    $pdo = new \PDO("mysql:dbname=emphloyer_example;host=localhost", getenv("DB_USER"), getenv("DB_PWD"));

    $stmt = $pdo->prepare('INSERT INTO things (name, created_at) VALUES (?, NOW())');
    for ($i = 1; $i < 11; $i++) {
      $stmt->execute(array($this->attributes['name'] . ' ' . $i));
    }
  }
}
