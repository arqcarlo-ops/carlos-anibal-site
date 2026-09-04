<?php
return [
    'site' => [
        'name' => 'Carlos Aníbal',
        'tagline' => 'Treinamento e Desenvolvimento Infantil',
        'city' => 'Feira de Santana - BA',
        'cref' => '015760-BA',
        'instagram' => '@anibal_erudilho',
        'instagram_url' => 'https://instagram.com/anibal_erudilho',
        'whatsapp' => '5575983131424',
        'whatsapp_display' => '(75) 98313-1424',
    ],
    // SQLite funciona imediatamente. Para hospedagem com MySQL, troque driver para mysql
    // e preencha os dados abaixo.
    'db' => [
        'driver' => 'sqlite', // sqlite | mysql
        'sqlite_path' => __DIR__ . '/../storage/database.sqlite',
        'host' => 'localhost',
        'port' => '3306',
        'database' => 'carlos_anibal',
        'username' => 'SEU_USUARIO_MYSQL',
        'password' => 'SUA_SENHA_MYSQL',
        'charset' => 'utf8mb4',
    ],
];
