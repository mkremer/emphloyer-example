<?php

declare(strict_types=1);

namespace Emphloyer\Example;

use Emphloyer\AbstractJob;
use Logger;
use PDO;
use function getenv;

class MakeThingJob extends AbstractJob
{
    public function __construct($name = '')
    {
        $this->attributes['name'] = $name;
    }

    public function perform() : void
    {
        Logger::getLogger(static::class)->info("Executing job, about to insert {$this->attributes['name']}");
        $pdo = new PDO('mysql:dbname=emphloyer_example;host=localhost', getenv('DB_USER'), getenv('DB_PWD'));

        $stmt = $pdo->prepare('INSERT INTO things (name, created_at) VALUES (?, NOW())');
        for ($i = 1; $i < 11; $i++) {
            $stmt->execute([$this->attributes['name'] . ' ' . $i]);
        }
    }
}
