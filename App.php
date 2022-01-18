<?php
// require modules
require_once(__DIR__ . '/lib/core/Calabash.php');
require_once(__DIR__ . '/routes/UserRouter.php');

// use interfaces
use Lib\Core\Class\Calabash as App;
use Router\UserRouter as UserRouter;

// initialize application
$app = new App();

// add routers
$app->add_router('/calabash/user', UserRouter::class);