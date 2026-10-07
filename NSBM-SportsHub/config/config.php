<?php
return [
    'app_name' => 'NSBM SportsHub',
    'tagline' => 'Train. Compete. Belong.',
    'base_url' => getenv('APP_URL') ?: '',
    'timezone' => 'Asia/Colombo',
    'debug' => filter_var(getenv('APP_DEBUG') ?: 'false', FILTER_VALIDATE_BOOLEAN),
];
