<?php

use App\Controllers\News; // Add this line
use CodeIgniter\Router\RouteCollection;
use App\Controllers\Pages;
use App\Controllers\Blog;
use App\Controllers\Test;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('news', [News::class, 'index']);
$routes->get('news/new', [News::class, 'new']); // Add this line
$routes->post('news', [News::class, 'create']); // Add this line
           
$routes->get('news/(:segment)', [News::class, 'show']); // Add this line

$routes->get('pages', [Pages::class, 'index']);


$routes->get('upload', 'Upload::index');          // Add this line.
$routes->post('upload/upload', 'Upload::upload'); // Add this line.

$routes->get('blog', [Blog::class, 'index']);

$routes->get('form', 'Form::index');
$routes->post('form', 'Form::index');

//routes untuk Test Helper
$routes->get('test', [Test::class,'index']);
$routes->get('(:segment)', [Pages::class, 'view']);

//
