<?php
copyR(__DIR__ . '/client-application/', $vhostDir . '/client-application/');
copyR(__DIR__ . '/public/', $vhostDir . '/public/');

$mysqlConstants = array('MYSQL_HOST', 'MYSQL_USER', 'MYSQL_PASSWORD', 'MYSQL_DATABASE', 'MYSQL_PREFIX');
foreach ($mysqlConstants as $mysqlConstant) {
    file_put_contents(
        $vhostDir . '/client-application/config.php',
        str_replace(
            $mysqlConstant,
            constant($mysqlConstant),
            file_get_contents($vhostDir . '/client-application/config.php')
        )
    );
}
