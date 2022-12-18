<?php

// app/config/config.php
$configuration->loadFromExtension('doctrine', array(
    'dbal' => array(
        'charset' => 'utf8mb4',
        'path'    => 'mysql://root:@localhost/ecf_symfony?serverVersion=mariadb-10.5.8',
        'default_table_options' => array(
            'charset' => 'utf8mb4',
            'collate' => 'utf8mb4_unicode_ci',
        )
    ),
));