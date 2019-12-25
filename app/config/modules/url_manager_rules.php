<?php
$project_rules = [
    \App\App::PROJECT_ID_TRAD3R => [
        //MAIN
        'login'                                         => 'auth/login',
        'device/0'                                      => 'device/add',
        'device/<id:\d{1,}>'                            => 'device/update',
        '/device/specification/list/<id:\d{1,}>'        => 'device/spec-list',
    ]
];

return $project_rules[PROJECT_ID];