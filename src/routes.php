<?php

use Flute\Core\Admin\Http\Middlewares\HasPermissionMiddleware;
use Flute\Core\Router\RouteGroup;
use Flute\Modules\Rules\src\Http\Controllers\API\ApiAdminRulesController;
use Flute\Modules\Rules\src\Http\Controllers\View\RulesView;

$router->group(function (RouteGroup $routeGroup) {
    $routeGroup->middleware(HasPermissionMiddleware::class);

    $routeGroup->group(function (RouteGroup $adminRouteGroup) {
        $adminRouteGroup->get('list', [RulesView::class, 'list']);
        $adminRouteGroup->get('add', [RulesView::class, 'add']);
        $adminRouteGroup->get('edit/{id}', [RulesView::class, 'edit']);
    }, 'rules/');

    $routeGroup->group(function (RouteGroup $adminRouteGroup) {
        $adminRouteGroup->post('add', [ApiAdminRulesController::class, 'store']);
        $adminRouteGroup->delete('{id}', [ApiAdminRulesController::class, 'delete']);
        $adminRouteGroup->put('{id}', [ApiAdminRulesController::class, 'update']);
    }, 'api/rules/');
}, 'admin/');