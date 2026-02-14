<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

echo "Starting image optimization...\n";

$files = Storage::disk('public')->allFiles();
$count = 0;
$totalSaved = 0;

function optimizeImage($path) {
    $fullPath = storage_path('app/public/' . $path);
    $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
    
    if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
        return 0; // Skip non-standard or unsupported for now
    }

    if (!function_exists('imagecreatefromstring')) {
        echo "GD not found\n";
        return 0;
    }

    $oldSize = filesize($fullPath);
    if ($oldSize < 500 * 1024) return 0; // Skip files < 500KB

    try {
        $imageData = file_get_contents($fullPath);
        $img = imagecreatefromstring($imageData);
        if (!$img) return 0;

        $width = imagesx($img);
        $height = imagesy($img);
        $maxDim = 1200;

        if ($width > $maxDim || $height > $maxDim) {
            if ($width > $height) {
                $newWidth = $maxDim;
                $newHeight = (int)($height * ($maxDim / $width));
            } else {
                $newHeight = $maxDim;
                $newWidth = (int)($width * ($maxDim / $height));
            }
            $tmp = imagecreatetruecolor($newWidth, $newHeight);
            if ($extension === 'png') {
                imagealphablending($tmp, false);
                imagesavealpha($tmp, true);
            }
            imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($img);
            $img = $tmp;
        }

        ob_start();
        if ($extension === 'png') {
            imagepng($img, null, 7);
        } else {
            imagejpeg($img, null, 75);
        }
        $optimizedData = ob_get_clean();
        imagedestroy($img);

        if (strlen($optimizedData) < $oldSize) {
            file_put_contents($fullPath, $optimizedData);
            $saved = $oldSize - strlen($optimizedData);
            echo "Optimized: $path (".round($oldSize/1024)."KB -> ".round(strlen($optimizedData)/1024)."KB)\n";
            return $saved;
        }
    } catch (\Exception $e) {
        echo "Error optimizing $path: " . $e->getMessage() . "\n";
    }
    return 0;
}

foreach ($files as $file) {
    $saved = optimizeImage($file);
    if ($saved > 0) {
        $count++;
        $totalSaved += $saved;
    }
}

echo "\nFinished! Optimized $count files.\n";
echo "Total space saved: " . round($totalSaved / 1024 / 1024, 2) . " MB\n";
