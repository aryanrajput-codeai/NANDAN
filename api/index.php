<?php

// Prepare writable storage directory structure in /tmp for Vercel serverless environment
if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL'])) {
    $storageDirs = [
        '/tmp/storage',
        '/tmp/storage/app',
        '/tmp/storage/app/public',
        '/tmp/storage/framework',
        '/tmp/storage/framework/cache',
        '/tmp/storage/framework/cache/data',
        '/tmp/storage/framework/sessions',
        '/tmp/storage/framework/views',
        '/tmp/storage/logs',
        '/tmp/bootstrap/cache',
    ];

    foreach ($storageDirs as $dir) {
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }

    // Set up SQLite database in /tmp if using sqlite
    $defaultDb = __DIR__.'/../database/database.sqlite';
    $tmpDb = '/tmp/database.sqlite';
    if (! file_exists($tmpDb)) {
        if (file_exists($defaultDb)) {
            copy($defaultDb, $tmpDb);
        } else {
            touch($tmpDb);
        }
    }
}

// Forward requests to Laravel's front controller
require __DIR__.'/../public/index.php';
