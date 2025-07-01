<?php

require __DIR__.'/bootstrap/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

use Illuminate\Contracts\Console\Kernel;

$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "<pre>";
passthru('php artisan config:clear');
passthru('php artisan cache:clear');
passthru('php artisan config:cache');
echo "</pre>";

?>
