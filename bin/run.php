<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Database\Connection;
use App\Repository\UserRepository;
use App\Repository\FileRepository;
use App\DemoRunner;

$uri = 'mongodb://mongo:27017';
$db  = 'howto';

$conn     = new Connection($uri, $db);
$userRepo = new UserRepository($conn);
$fileRepo = new FileRepository($conn);

$demo = new DemoRunner($userRepo, $fileRepo);
$demo->run();
