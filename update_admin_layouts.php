<?php

$adminViewsDir = __DIR__ . '/resources/views/admin';

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($adminViewsDir));

$count = 0;
foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $path = $file->getRealPath();
        $content = file_get_contents($path);
        
        $original = $content;
        $content = str_replace('<x-app-layout>', '<x-admin-layout>', $content);
        $content = str_replace('</x-app-layout>', '</x-admin-layout>', $content);

        if ($content !== $original) {
            file_put_contents($path, $content);
            $count++;
        }
    }
}

echo "Updated $count admin views to use x-admin-layout.\n";
