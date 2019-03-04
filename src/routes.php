<?php

use Zend\Diactoros\Response;
use Aura\Router\RouterContainer;
use Zend\Diactoros\ServerRequestFactory;
use Psr\Http\Message\ServerRequestInterface;

$request = ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$routerContainer = new RouterContainer();
$generator = $routerContainer->getGenerator();
$map = $routerContainer->getMap();
$view = new \Slim\Views\PhpRenderer(__DIR__ . '/../templates/');
$entityManager = getEntityManager();


//Rotas ----------------------------------------------------------------------------------------------------------------
$map->get('home', '/', function (ServerRequestInterface $request, $response) use ($view, $entityManager){
    $productRepository = $entityManager->getRepository(\App\Entity\Product::class);
    $categoryRepository = $entityManager->getRepository(\App\Entity\Category::class);
    $categories = $categoryRepository->findAll();
    $data = $request->getQueryParams();
    if (isset($data['search']) and $data['search']!="") {
        $queryBuilder = $productRepository->createQueryBuilder('p');
        $queryBuilder->join('p.categories', 'c');
        $queryBuilder->where($queryBuilder->expr()->eq('c.id', $data['search']));

        $products = $queryBuilder->getQuery()->getResult();
    }else {
        $products = $productRepository->findAll();
    }


    return $view->render($response, 'home.phtml', [
        'products' => $products,
        'categories' => $categories
    ]);
});

require_once __DIR__ . '/routes/categories.php';
require_once __DIR__ . '/routes/products.php';

//Rotas Fim-------------------------------------------------------------------------------------------------------------
$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

//Pega atributos das rotas e coloca no request--------------------------------------------------------------------------
foreach ($route->attributes as $key => $value) {
    $request = $request->withAttribute($key, $value);
}//---------------------------------------------------------------------------------------------------------------------

$callable = $route->handler;

/** @var Response $response */
$response = $callable($request, new Response());

if ($response instanceof  Response\RedirectResponse) {
    header("location:{$response->getHeader("location")[0]}");
} elseif ($response instanceof Response) {
    echo $response->getBody();
}
