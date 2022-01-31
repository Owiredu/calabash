<?php
// require modules
require_once __DIR__ . '/lib/core/Calabash.php';
require_once __DIR__ . '/routes/UserRouter.php';

// use namespaces
use Lib\Core\Calabash;
use Router\UserRouter;

// initialize application
$app = new Calabash();

// set cookies
$app->set_cookies(
    $name = "calabash",
    $value = uniqid("calabash_", $more_entropy = true),
    $options = [
        'expires' => time() + 60 * 60 * 24 * 30, // expires after 30 days
        'path' => '/calabash',
        'domain' => 'localhost', // eg. '.example.com', leading dot for compatibility or use subdomain
        'secure' => true, // or false
        'httponly' => true, // or false
        'samesite' => 'None', // None || Lax  || Strict
    ]
);

// add routers
$app->add_router('/calabash/user', UserRouter::class);
