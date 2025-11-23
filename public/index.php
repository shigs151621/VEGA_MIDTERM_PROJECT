<?php

define('LARAVEL_START', microtime(true));

// Composer autoload
require __DIR__.'/../vendor/autoload.php';

// Bootstrap the application
$app = require_once __DIR__.'/../bootstrap/app.php';

// Import Request
use Illuminate\Http\Request;

// Make the HTTP kernel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Capture the request
$request = Request::capture();

// Handle the request and send the response
$response = $kernel->handle($request);
$response->send();

// Terminate the kernel
$kernel->terminate($request, $response);
