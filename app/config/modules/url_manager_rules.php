<?php
$project_rules = [
    \App\App::PROJECT_ID_TRAD3R => [
        //MAIN
        'login'                                         => 'auth/login',
        
        'devices'                                       => 'device/index',
        'devices/0'                                     => 'device/add',
        'devices/remove/<id:\d{1,}>'                    => 'device/remove',
        'devices/<id:\d{1,}>'                           => 'device/update',
        'devices/specification/list/<id:\d{1,}>'        => 'device/spec-list',
        'devices/search'                                => 'device/search',
        
        'products'                                      => 'product/index',
        'products/<id:(-1|0)>'                          => 'product/add',
        'products/remove/<id:\d{1,}>'                   => 'product/remove',
        'products/<id:\d{1,}>'                          => 'product/update',
        'products/specification/list/<id:\d{1,}>'       => 'product/spec-list',
        
        
        'listings/'                                     => 'listing/index',
        'listings/create'                               => 'listing/create',
    ]
];

return $project_rules[PROJECT_ID];