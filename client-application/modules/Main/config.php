<?php
return array(
    'routes' => array(
        array(
            'class' => '\LSite\Main\Controllers\Main',
            'method' => 'jsConstantsList',
            'type' => 'contentOnly',
            'matchType' => 'simple',
            'matchParams' => array('/js/site-langcs.js')
        )
    )
);