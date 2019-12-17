<?php
$project_rules = [
    \App\App::PROJECT_ID_TRAD3R => [
        //MAIN
        'login'     => 'auth/login',
        'device/<id:\d{1,}>'     => 'site/device-update',
        'device/add'     => 'site/device-add',
    ]
];

return $project_rules[PROJECT_ID];