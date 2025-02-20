<?php

include "./utils/connexion.php";
include "./models/userModel.php";
include "./controllers/apiController.php";
include './env.php';

$bdd = connexion();

$request_method = $_SERVER['REQUEST_METHOD'];
$path_info = $_SERVER['PATH_INFO'] ?? '/';

$routes = [
    'GET' => [
        '/users' => 'getUsers',       
    ],
    'POST' => [
        '/user' => 'addUser',
    ],
];

if (isset($routes[$request_method][$path_info])) {
    $action = $routes[$request_method][$path_info];
    $models = ["user"=>new UserModel()];
    $controller = new ApiController($models, $bdd);
    $controller->$action();
} else {
    header("HTTP/1.1 404 Not Found");
    echo json_encode(['status' => 'error', 'message' => 'Route non trouvée']);
}


if($request_method === 'PUT'){
    http_response_code(405);
    echo json_encode(['message' => "Methode non autorisée", 'code response' => 405]);
    return;
}

