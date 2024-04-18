<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');


$routes->setDefaultNamespace('App\Controllers');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

$routes->get('/', 'Roster::index', ['as' => 'roster']);
$routes->get('roster/new', 'Roster::new', ['as' => 'roster.new']);
$routes->post('roster/create', 'Roster::create', ['as' => 'roster.create']);
$routes->get('roster/new-excel', 'Roster::newExcel', ['as' => 'roster.new.excel']);
$routes->post('roster/create-excel', 'Roster::createExcel', ['as' => 'roster.create.excel']);
$routes->get('roster/edit/(:num)', 'Roster::edit/$1', ['as' => 'roster.edit']);
$routes->post('roster/update/(:num)', 'Roster::update/$1', ['as' => 'roster.update']);
$routes->get('roster/delete/(:num)', 'Roster::delete/$1', ['as' => 'roster.delete']);

$routes->get('supervisory-authority', 'SupervisoryAuthority::index', ['as' => 'supervisory.authority']);
$routes->get('supervisory-authority/new', 'SupervisoryAuthority::new', ['as' => 'supervisory.authority.new']);
$routes->post('supervisory-authority/create', 'SupervisoryAuthority::create', ['as' => 'supervisory.authority.create']);
$routes->get('supervisory-authority/edit/(:num)', 'SupervisoryAuthority::edit/$1', ['as' => 'supervisory.authority.edit']);
$routes->post('supervisory-authority/update/(:num)', 'SupervisoryAuthority::update/$1', ['as' => 'supervisory.authority.update']);
$routes->get('supervisory-authority/delete/(:num)', 'SupervisoryAuthority::delete/$1', ['as' => 'supervisory.authority.delete']);

$routes->get('small-business-entity', 'SmallBusinessEntity::index', ['as' => 'small.business.entity']);
$routes->get('small-business-entity/new', 'SmallBusinessEntity::new', ['as' => 'small.business.entity.new']);
$routes->post('small-business-entity/create', 'SmallBusinessEntity::create', ['as' => 'small.business.entity.create']);
$routes->get('small-business-entity/edit/(:num)', 'SmallBusinessEntity::edit/$1', ['as' => 'small.business.entity.edit']);
$routes->post('small-business-entity/update/(:num)', 'SmallBusinessEntity::update/$1', ['as' => 'small.business.entity.update']);
$routes->get('small-business-entity/delete/(:num)', 'SmallBusinessEntity::delete/$1', ['as' => 'small.business.entity.delete']);

$routes->group('api', ['namespace' => 'App\Controllers'], function($routes)
{
    $routes->get('api-search', 'ApiSearch::filterRoster', ['as' => 'api.search']);
});