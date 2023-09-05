<?php

// Define app routes
use Slim\App;
use Slim\Routing\RouteCollectorProxy;



return function (App $app) {
    // Redirect to Swagger documentation
    $app->get('/', \App\Action\Home\HomeAction::class)->setName('home');
    $app->get('/dashboard', \App\Action\Home\HomeAction::class)->setName('dashboard');
    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });

    //Auth
    $app->group(
        '/auth',
        function (RouteCollectorProxy $app) { 
            $app->post('/user/create', \App\Action\Auth\AuthSigninAction::class);
            $app->post('/user/authentication', \App\Action\Auth\AuthLoginAction::class);
        }
    );
 
    //User 
    $app->group(
        '/user',
        function (RouteCollectorProxy $app) { 
            $app->post('/token', \App\Action\Users\UsersFinderAction::class);
        }
    );

    // Roles
    $app->group(
        '/roles',
        function (RouteCollectorProxy $app) {
           
            $app->get('', \App\Action\Roles\RolesFinderAction::class);//completed
            $app->get('/{roles_id}', \App\Action\Roles\RolesReaderAction::class);//completed
            $app->post('', \App\Action\Roles\RolesCreatorAction::class);//completed
            $app->put('/{roles_id}', \App\Action\Roles\RolesUpdaterAction::class);//completed
            $app->delete('/{roles_id}', \App\Action\Roles\RolesDeleterAction::class);//completed
        }
    );

    // Area
    $app->group(
        '/areas',
        function (RouteCollectorProxy $app) {
           
            $app->get('', \App\Action\Area\AreaFinderAction::class);//completed
            $app->get('/{area_id}', \App\Action\Area\AreaReaderAction::class);//completed
            $app->post('', \App\Action\Area\AreaCreatorAction::class);//completed
            $app->put('/{area_id}', \App\Action\Area\AreaUpdaterAction::class);//completed
            $app->delete('/{area_id}', \App\Action\Area\AreaDeleterAction::class);//completed
        }
    );

    // Charge
    $app->group(
        '/charges',
        function (RouteCollectorProxy $app) {
            $app->get('', \App\Action\Charge\ChargeFinderAction::class);//completed
            $app->get('/{charge_id}', \App\Action\Charge\ChargeReaderAction::class);//completed
            $app->post('', \App\Action\Charge\ChargeCreatorAction::class);//completed
            $app->put('/{charge_id}', \App\Action\Charge\ChargeUpdaterAction::class);//completed
            $app->delete('/{charge_id}', \App\Action\Charge\ChargeDeleterAction::class);//completed
        }
    );

    // Status
    $app->group(
        '/status',
        function (RouteCollectorProxy $app) {
            $app->get('', \App\Action\Status\StatusFinderAction::class);//completed
            $app->get('/{status_id}', \App\Action\Status\StatusReaderAction::class);//completed
            $app->post('', \App\Action\Status\StatusCreatorAction::class);//completed
            $app->put('/{status_id}', \App\Action\Status\StatusUpdaterAction::class);//completed
            $app->delete('/{status_id}', \App\Action\Status\StatusDeleterAction::class);//completed
        }
    );

    // Type Tasks
    $app->group(
        '/type_tasks',
        function (RouteCollectorProxy $app) {
            $app->get('', \App\Action\TypeTask\TypeTaskFinderAction::class);//completed
            $app->get('/{typeArea_id}', \App\Action\TypeTask\TypeTaskXAreaFinderAction::class);//completed
            $app->post('', \App\Action\TypeTask\TypeTaskCreatorAction::class);//
            $app->put('/{typeTask_id}', \App\Action\TypeTask\TypeTaskUpdaterAction::class);//
            $app->delete('/{typeTask_id}', \App\Action\TypeTask\TypeTaskDeleterAction::class);//
        }
    );

   //Tasks
    $app->group(
        '/tasks',
        function (RouteCollectorProxy $app) { 
            $app->get('/{id_task}', \App\Action\Task\TaskReaderAction::class);//completed
            $app->get('/{nro_pag}/{cant_registros}[/{params:.*}]', \App\Action\Task\TaskFinderAction::class);//completed
            $app->post('', \App\Action\Task\TaskCreatorAction::class);//completed
            $app->put('/{task_id}', \App\Action\Task\TaskUpdaterAction::class);//completed
            $app->delete ('/{task_id}', \App\Action\Task\TaskDeleterAction::class);//completed
        }
    );

   //Notes
    $app->group(
        '/notes',
        function (RouteCollectorProxy $app) { 
            $app->get('/unique/{id_note}', \App\Action\Note\NoteReaderAction::class);//completed
            $app->get('/{id_task}/{nro_pag}/{cant_registros}', \App\Action\Note\NoteFinderAction::class);//completed
            $app->post('', \App\Action\Note\NoteCreatorAction::class);//completed
            $app->put('/{note_id}', \App\Action\Note\NoteUpdaterAction::class);//completed
            $app->delete ('/{note_id}', \App\Action\Note\NoteDeleterAction::class);//completed
        }
    );

    // API
    $app->group(
        '/api',
        function (RouteCollectorProxy $app) {
            $app->get('/customers', \App\Action\Customer\CustomerFinderAction::class);//test
            $app->get('/customers/{customer_id}', \App\Action\Customer\CustomerReaderAction::class);//test
            $app->post('/customers', \App\Action\Customer\CustomerCreatorAction::class);//test
            $app->put('/customers/{customer_id}', \App\Action\Customer\CustomerUpdaterAction::class);//test
            $app->delete('/customers/{customer_id}', \App\Action\Customer\CustomerDeleterAction::class);//test
        }
    );
};
