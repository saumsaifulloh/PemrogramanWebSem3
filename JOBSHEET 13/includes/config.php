<?php
// Konfigurasi database. Gunakan environment variable untuk deployment.
return [
    'host' => getenv('DB_HOST') ?: '127.0.0.1',
    'port' => getenv('DB_PORT') ?: '5432',
    'name' => getenv('DB_NAME') ?: 'simpus_mini',
    'user' => getenv('DB_USER') ?: 'postgres',
    'pass' => getenv('DB_PASS') !== false ? getenv('DB_PASS') : 'postgres',
];
