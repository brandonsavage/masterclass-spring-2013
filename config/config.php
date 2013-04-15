<?php

return array(

    'database' => array(
        'user' => 'nyoung',
        'pass' => 'test',
        'host' => '127.0.0.1',
        'name' => 'masterclass',
    ),
    
    'routes' => array(
        '' => 'Controller_Index/index',
        'story' => 'Controller_Story/index',
        'story/create' => 'Controller_Story/create',
        'comment/create' => 'Controller_Comment/create',
        'user/create' => 'Controller_User/create',
        'user/account' => 'Controller_User/account',
        'user/login' => 'Controller_User/login',
        'user/logout' => 'Controller_User/logout',
    ),
	'views' => array(
		'view_path' => '',
		'layout_path' => realpath('../view/layouts'),
	),
);
