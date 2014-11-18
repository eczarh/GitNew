<?php
$serviceManager = new \LSite\ServiceManager();
$serviceManager->setLazyService(
    'ajax',
    array(
        'class' => 'LSite\Ajax'
    )
);

$serviceManager->setLazyService(
    'lang',
    array(
        'class' => 'LSite\Lang'
    )
);

$serviceManager->setLazyService(
    'modules',
    array(
        'class' => 'LSite\Modules'
    )
);

$serviceManager->setLazyService(
    'mysqli',
    array(
        'class' => 'LSite\Mysqli',
        'constructorParameters' => $mysqliConfig        
    )
);
unset($mysqliConfig);

$serviceManager->setLazyService(
    'templatesEscaper',
    array(
        'class' => 'Zend\Escaper\Escaper'     
    )
);