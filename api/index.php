<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

use Tuupola\Middleware\HttpBasicAuthentication;
use \Firebase\JWT\JWT;

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/modeles/Catalogue.php';
require __DIR__ . '/vendor/autoload.php';


 
$app = AppFactory::create();

const JWT_SECRET = "1RDFMP5vPI";



function addCorsHeaders (Response $response) : Response {

    $response =  $response
    ->withHeader("Access-Control-Allow-Methods", 'GET, POST, PUT, PATCH, DELETE,OPTIONS')
    ->withHeader ("Access-Control-Expose-Headers" , "Authorization");
    return $response;
}


// Middleware de validation du Jwt
$options = [
    "attribute" => "token",
    "header" => "Authorization",
    "regexp" => "/Bearer\s+(.*)$/i",
    "secure" => false,
    "algorithm" => ["HS256"],
    "secret" => JWT_SECRET,
    "path" => ["/api"],
    "ignore" => ["/hello","/api/hello","/api/login","/api/createUser", "/api/catalogue"],
    "error" => function ($response, $arguments) {
        $data = array('ERREUR' => 'Connexion', 'ERREUR' => 'JWT Non valide');
        $response = $response->withStatus(401);
        $response = @addCorsHeaders($response);
        return $response->withHeader("Content-Type", "application/json")->getBody()->write(json_encode($data));
    }
];

$app->post('/api/login', function (Request $request, Response $response, $args) {
    $issuedAt = time();
    $expirationTime = $issuedAt + 6000;
    $payload = array(
        'userid' => "1",
        'email' => "corentin.jolivel.pro@gmail.com",
        'pseudo' => "pasta",
        'iat' => $issuedAt,
        'exp' => $expirationTime
    );

    $token_jwt = JWT::encode($payload,JWT_SECRET, "HS256");
    $response = $response->withHeader("Authorization", "Bearer {$token_jwt}");
    $response = @addCorsHeaders($response);
    return $response;
});





$app->get('/api/catalogue', function (Request $request, Response $response, $args) {
  
    global $entityManager;

    $catalogueRepository = $entityManager->getRepository(Catalogue::class);
    $catalogue = $catalogueRepository->findAll();

    $data = [];

    foreach ($catalogue as $e) {
        $elem = [];
        $elem ["id"] = $e->getId();
        $elem ["ref"] = $e->getRef();
        $elem ["nom"] = $e->getNom();
        $elem ["prix"] = $e->getPrix();

        array_push ($data,$elem);
    }

    $response = $response
    ->withHeader("Content-Type", "application/json;charset=utf-8");

    
    $response->getBody()->write(json_encode($data));
    $response = @addCorsHeaders($response);
    return $response;
});


$app->get('/api/client/{id}', function (Request $request, Response $response, $args) {
    $array = [];
    $array ["nom"] = "jolivel";
    $array ["prenom"] = "corentin";
    
    $response->getBody()->write(json_encode ($array));
    $response = @addCorsHeaders($response);
    return $response;
});

$app->get('/hello/{name}', function (Request $request, Response $response, $args) {
    $array = [];
    $array ["nom"] = $args ['name'];
    $response->getBody()->write(json_encode ($array));
    $response = @addCorsHeaders($response);
    return $response;
});


$app->get('/api/hello/{name}', function (Request $request, Response $response, $args) {
    $array = [];
    $array ["nom"] = $args ['name'];
    $response->getBody()->write(json_encode ($array));
    $response = @addCorsHeaders($response);
    return $response;
});


// Chargement du Middleware
$app->add(new Tuupola\Middleware\JwtAuthentication($options));
$app->run ();


/*
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
*/

