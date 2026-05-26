<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::create('/wealth/dashboard?token=21|qypmTDgplTjqfGsh7oSYkrilEMDLnLxbqMYvAyMTbe826c4f', 'GET');
$response = $kernel->handle($request);

echo $response->getStatusCode() . PHP_EOL;
echo $response->headers->get('Location') . PHP_EOL;
