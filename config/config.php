<?php



return array(

    'database' => array(
        'user' => 'root',
        'pass' => 'jdjhsgeh',
        'host' => 'localhost',
        'name' => 'phpOOP2013',
    ),
    
    'routes' => array(
        '' => 'index/index',
        'story' => 'story/index',
        'story/create' => 'story/create',
        'comment/create' => 'comment/create',
        'user/create' => 'user/create',
        'user/account' => 'user/account',
        'user/login' => 'user/login',
        'user/logout' => 'user/logout',
    ),

    'views' => array(
        'view_path' => '',
        'layout_path' => realpath('../view/layouts'),
    )
);
