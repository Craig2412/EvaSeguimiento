<?php

// Define app routes
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    // Redirect to Swagger documentation
    $app->get('/', \App\Action\Home\HomeAction::class)->setName('home');
    $app->get('/dashboard', \App\Action\Home\TaskbyStatusFinderAction::class)->setName('dashboard');

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
            // Devuelve la cantidad de tasks por status segun el tipo de tarea o la direcciones de linea 
            $app->get('/byStatus/{value}/{id_busqueda}', \App\Action\Task\TaskbyStatusFinderAction::class);//completed // ($value = 1 [para tipos de tarea] 2 [para busqueda por areas]) (id_busqueda = 1-20 [para tipos de tareas] 1-3 [para las areas])
            $app->get('/byMonth/{year}', \App\Action\Task\TaskbyMonthFinderAction::class);//
            $app->get('/byAreas', \App\Action\Task\TaskbyAreaFinderAction::class);//completed // Devuelve la cantidad de tasks por areas
            $app->get('/byResponsablesAll', \App\Action\Task\TaskbyResponsableAllFinderAction::class);//completed
            $app->get('/byResponsable/{id_responsable}', \App\Action\Task\TaskbyResponsableFinderAction::class);//completed
            $app->get('/byCalendar/{nro_pag}/{cant_registros}/{fecha_inicial}/{fecha_final}', \App\Action\Task\TaskCalendarFinderAction::class);//completed
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
            $app->get('/file/{id_file}', \App\Action\Note\NoteFileReaderAction::class);//completed
            $app->get('/fileforNote/{id_note}', \App\Action\Note\NoteFileFinderAction::class);//

            $app->get('/{id_task}/{nro_pag}/{cant_registros}', \App\Action\Note\NoteFinderAction::class);//completed

            $app->post('', \App\Action\Note\NoteCreatorAction::class);//completed
            $app->post('/file', \App\Action\Note\NoteFileCreatorAction::class);//completed
            $app->put('/{note_id}', \App\Action\Note\NoteUpdaterAction::class);//completed
            $app->delete ('/{note_id}', \App\Action\Note\NoteDeleterAction::class);//completed
        }
    );

     // Responsibles
     $app->group(
        '/responsibles',
        function (RouteCollectorProxy $app) {
            $app->get('', \App\Action\Responsible\ResponsibleFinderAction::class);//completed
            $app->get('/{responsible_id}', \App\Action\Responsible\ResponsibleReaderAction::class);//completed
            $app->post('', \App\Action\Responsible\ResponsibleCreatorAction::class);//completed
            $app->put('/{responsible_id}', \App\Action\Responsible\ResponsibleUpdaterAction::class);//completed
            $app->delete('/{responsible_id}', \App\Action\Responsible\ResponsibleDeleterAction::class);//completed
        }
    );
    
     // Usuarios
     $app->group(
        '/usuarios',
        function (RouteCollectorProxy $app) {
            $app->get('', \App\Action\Usuario\UsuarioFinderAction::class);//completed
            $app->get('/{usuario_id}', \App\Action\Usuario\UsuarioReaderAction::class);//completed
            $app->post('', \App\Action\Usuario\UsuarioCreatorAction::class);//
            $app->put('/{usuario_id}', \App\Action\Usuario\UsuarioUpdaterAction::class);//
            $app->delete('/{usuario_id}', \App\Action\Usuario\UsuarioDeleterAction::class);//
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
