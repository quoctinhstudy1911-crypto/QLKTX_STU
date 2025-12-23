<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$profile = \App\Models\PersonalProfile::first();
echo "Avatar: " . ($profile->avatar ?? 'NULL') . "\n";
echo "Phone: " . $profile->phone . "\n";
echo "Updated At: " . $profile->updated_at . "\n";
?>
