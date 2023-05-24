<?php

return [
    'main_domain' => env(
        'MAIN_DOMAIN',
        parse_url(
            trim(env('APP_URL')),
            PHP_URL_HOST
        )
    ) ?? throw new Exception("'MAIN_DOMAIN' is required"),
];
