<?php
function loadEnv()
{
    $env = parse_ini_file(__DIR__ . '/../../.env');
    foreach ($env as $key => $value) {
        putenv("$key=$value");
    }
}
?>