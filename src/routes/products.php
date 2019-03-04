<?php
/**
 * Created by PhpStorm.
 * User: arman
 * Date: 03/11/2018
 * Time: 19:33
 */
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use App\Entity\Product;

$map->get('products.list', '/products', function ($request, $response) use ($view, $entityManager){
    $repository = $entityManager->getRepository(Product::class);
    $products = $repository->findAll();

    return $view->render($response, 'products/list.phtml', [
        'products' => $products
    ]);
});

$map->get('products.create', '/products/create', function ($request, $response) use ($view){
    return $view->render($response, '/products/create.phtml');
});

$map->post('products.store', '/products/store',
    function (ServerRequestInterface $request, $response) use ($view, $entityManager, $generator){
        $data = $request->getParsedBody();
        $product = new Product();
        $product->setName($data['name']);
        $product->setAmount($data['amount']);
        $product->setPrice($data['price']);
        $product->setDescription($data['description']);
        $product->setSpotlight($data['spotlight']);
        $entityManager->persist($product);
        $entityManager->flush();
        $uri = $generator->generate('products.list');
        return new Response\RedirectResponse($uri);
    });

$map->get('products.edit', '/products/{id}/edit',
    function (ServerRequestInterface $request, $response) use ($view, $entityManager) {
        $id = $request->getAttribute('id');
        $repository = $entityManager->getRepository(Product::class);
        $product = $repository->find($id);
        return $view->render($response, 'products/edit.phtml', [
            'product' => $product
        ]);
    });

$map->post('products.update', '/products/{id}/update',
    function (ServerRequestInterface $request, $response) use ($view, $entityManager, $generator){
        $id = $request->getAttribute('id');
        $repository = $entityManager->getRepository(Product::class);
        $product = $repository->find($id);
        $data = $request->getParsedBody();
        $product->setName($data['name']);
        $product->setAmount($data['amount']);
        $product->setPrice($data['price']);
        $product->setDescription($data['description']);
        $product->setSpotlight($data['spotlight']);
        $entityManager->flush();
        $uri = $generator->generate('products.list');
        return new Response\RedirectResponse($uri);
    });

$map->get('products.remove', '/products/{id}/remove',
    function (ServerRequestInterface $request, $response) use ($view, $entityManager, $generator){
        $id = $request->getAttribute('id');
        $repository = $entityManager->getRepository(Product::class);
        $product = $repository->find($id);
        $entityManager->remove($product);
        $entityManager->flush();
        $uri = $generator->generate('products.list');
        return new Response\RedirectResponse($uri);
    });

$map->get('products.categories', '/products/{id}/categories',
    function (ServerRequestInterface $request, $response) use ($view, $entityManager){
        $id = $request->getAttribute('id');
        $repository = $entityManager->getRepository(Product::class);
        $categoryRepository = $entityManager->getRepository(\App\Entity\Category::class);
        $categories = $categoryRepository->findAll();
        $product = $repository->find($id);
        return $view->render($response, 'products/categories.phtml', [
            'product' => $product,
            'categories' => $categories
        ]);
    });

$map->post('products.set-categories', '/products/{id}/set-categories',
    function (ServerRequestInterface $request, $response) use ($view, $entityManager, $generator){
        $id = $request->getAttribute('id');
        $data = $request->getParsedBody();
        $repository = $entityManager->getRepository(Product::class);
        $categoryRepository = $entityManager->getRepository(\App\Entity\Category::class);

        /** @var Product $product */
        $product = $repository->find($id);
        $product->getCategories()->clear();
        $entityManager->flush();

        foreach ($data['categories'] as $idCategory) {
            $category = $categoryRepository->find($idCategory);
            $product->addCategory($category);
        }

        $entityManager->flush();
        $uri = $generator->generate('products.list');
        return new Response\RedirectResponse($uri);
    });