<?php

$packagesPath = __DIR__ . '/../packages';
$publicPath = __DIR__ . '/../public/css/packages';

if (!is_dir($publicPath)) {
    mkdir($publicPath, 0755, true);
}

$packages = scandir($packagesPath);
foreach ($packages as $package) {
    if ($package === '.' || $package === '..') {
        continue;
    }
    $source = $packagesPath . '/' . $package . '/src/Resources/assets/css';
    if (is_dir($source)) {
        $target = $publicPath . '/' . $package;
        if (!is_dir($target)) {
            mkdir($target, 0755, true);
        }
        $files = scandir($source);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            copy($source . '/' . $file, $target . '/' . $file);
        }
    }
}