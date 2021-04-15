<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '../vendor/autoload.php';
$app = AppFactory::create();

$app->get('/hello/{name}', HelloWorld());

function HelloWorld(Request $resquest, Response $response,$args) 
{
    $array = array('nom' => $args['name']);
    return $response->getBody()->write(json_encode($array));
}; 


$app->run();


