<?php
return array(
    'routes' => array(
        array(
            'class' => '\Oznaka\Mainpage\Controllers\Mainpage',
            'method' => 'start',
            'layout' => 'main.php',
            'type' => 'contentInLayout',
            'matchType' => 'simple',
            'matchParams' => array('/')
        )
    )
);