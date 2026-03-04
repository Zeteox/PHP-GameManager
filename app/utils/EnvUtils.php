<?php

/**
 * Function to load environment variables from .env file and set them in the environment
 * @return void
 */
function loadEnv()
{
    $env = parse_ini_file(__DIR__ . '/../../.env');
    foreach ($env as $key => $value) {
        putenv("$key=$value");
    }
}
?>