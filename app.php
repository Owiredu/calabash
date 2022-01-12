<?php
// require routers
require(__DIR__ . '/routes/UserRouter.php');

use Routes\UserRouter;

$user_router = new UserRouter();
$user_router->index();
echo($_SERVER["REQUEST_URI"]);