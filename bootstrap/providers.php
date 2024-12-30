<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\VoltServiceProvider::class,
    Yajra\DataTables\DataTablesServiceProvider::class,

    // for api.
    Laravel\Passport\PassportServiceProvider::class,
    App\Providers\ConsoleServiceProvider::class,
    App\Providers\PassportServiceProvider::class, 
    App\Providers\MiddlewareServiceProvider::class,
    // for tenancy
    App\Providers\TenancyServiceProvider::class,
    // Stancl\Tenancy\TenancyServiceProvider::class,



];
