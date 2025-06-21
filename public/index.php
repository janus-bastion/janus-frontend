<?php
require __DIR__ . '/../../composer/vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->get('/login', function (Request $request, Response $response, $args) {
    $file = '/usr/share/nginx/html/index.php';
    ob_start();
    include($file);
    $output = ob_get_clean();
    $response->getBody()->write($output);
    return $response;
});

$app->get('/newconnect', function (Request $request, Response $response, $args) {
    $file = '/usr/share/nginx/html/janus-view/janus-create-connect.php';
    ob_start();
    include($file);
    $output = ob_get_clean();
    $response->getBody()->write($output);
    return $response;
});

$app->get('/stats', function (Request $request, Response $response, $args) {
    $file = '/usr/share/nginx/html/janus-view/get-stats.php';
    ob_start();
    include($file);
    $output = ob_get_clean();
    $response->getBody()->write($output);
    return $response;
});

$app->get('/home', function (Request $request, Response $response, $args) {
    $file = '/usr/share/nginx/html/janus-view/home.php';
    ob_start();
    include($file);
    $output = ob_get_clean();
    $response->getBody()->write($output);
    return $response;
});

$app->get('/dashboard', function (Request $request, Response $response, $args) {
    $file = '/usr/share/nginx/html/janus-view/janus-dashboard.php';
    ob_start();
    include($file);
    $output = ob_get_clean();
    $response->getBody()->write($output);
    return $response;
});

$app->get('/logout', function (Request $request, Response $response, $args) {
    $file = '/usr/share/nginx/html/janus-view/janus-logout.php';
    ob_start();
    include($file);
    $output = ob_get_clean();
    $response->getBody()->write($output);
    return $response;
});

$app->get('/register', function (Request $request, Response $response, $args) {
    $file = '/usr/share/nginx/html/janus-view/janus-register.php';
    ob_start();
    include($file);
    $output = ob_get_clean();
    $response->getBody()->write($output);
    return $response;
});

$app->get('/manage-users', function (Request $request, Response $response, $args) {
    $file = '/usr/share/nginx/html/janus-view/janus-manage-users.php';
    ob_start();
    include($file);
    $output = ob_get_clean();
    $response->getBody()->write($output);
    return $response;
});

$app->post('/manage-users', function (Request $request, Response $response, $args) {
    $file = '/usr/share/nginx/html/janus-view/janus-manage-users.php';
    ob_start();
    include($file);
    $output = ob_get_clean();
    $response->getBody()->write($output);
    return $response;
});

# ----------------------- #

$app->post('/preauthprocess', function (Request $request, Response $response, $args) {
    $fich = '/usr/share/nginx/html/janus-mdlw/janus-preauth.php';
    ob_start();
    include($fich);
    $output = ob_get_clean();
    $response->getBody()->write($output);
    return $response;
});

$app->post('/registerprocess', function (Request $request, Response $response, $args) {
    $fich = '/usr/share/nginx/html/janus-mdlw/janus-register.php';
    ob_start();
    include($fich);
    $output = ob_get_clean();
    $response->getBody()->write($output);
    return $response;
});

$app->post('/logoutprocess', function (Request $request, Response $response, $args) {
    $fich = '/usr/share/nginx/html/janus-mdlw/janus-logout.php';
    ob_start();
    include($fich);
    $output = ob_get_clean();
    $response->getBody()->write($output);
    return $response;
});

$app->post('/newconnectprocess', function (Request $request, Response $response, $args) {
    $fich = '/usr/share/nginx/html/janus-mdlw/janus-create-connect.php';
    ob_start();
    include($fich);
    $output = ob_get_clean();
    $response->getBody()->write($output);
    return $response;
});

$app->run();
