<?php

require __DIR__ . '/../vendor/autoload.php';

use DI\Container;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

use Twitter2\Controllers\UserController;
use Twitter2\Controllers\StatusController;

$container = new Container();

AppFactory::setContainer($container);

$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$app->addErrorMiddleware(true, true, true);

$app->add(new Tuupola\Middleware\JwtAuthentication([
    "path" => ["/users", "/statuses"], //TODO: ENHANCE THIS
    "ignore" => ["/users/token"],
    "secret" => "mysecret"
]));

//TODO: GENERATE JWT. USING THE SITE FOR TESTING https://jwt.io/

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->get('/users/', UserController::class . ':get');
$app->post('/users/', UserController::class . ':create');

$app->post('/users/{userid}/statuses/', StatusController::class . ':create'); //TODO: DECIDE ABOUT THIS ROUTE NAMING
$app->get('/statuses/{statusid}', StatusController::class . ':getSingle');

$app->run();