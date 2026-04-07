<?php

$viewsDir = __DIR__ . '/resources/views';

$replacements = [
    // ── Cartes ──
    'bg-white overflow-hidden shadow-sm sm:rounded-lg' => 'card',
    'bg-white shadow-sm sm:rounded-lg' => 'card',
    'p-6 text-gray-900' => '', // Sera absorbé par card

    // ── Boutons Primary ──
    'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded' => 'btn-primary',
    'bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded' => 'btn-primary',
    'bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow' => 'btn-primary',
    'bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-3 px-6 rounded-lg' => 'btn-primary',
    'bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 flex items-center justify-center h-full rounded shadow' => 'btn-primary h-full',

    // ── Boutons Secondary/Retour ──
    'bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded' => 'btn-secondary',
    'bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold py-2 px-4 rounded' => 'btn-secondary',
    'bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-bold py-2 px-4 rounded-lg' => 'btn-secondary',
    
    // ── Boutons Verts / Accent ──
    'bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 flex items-center justify-center h-full rounded shadow' => 'btn-accent h-full',
    'bg-green-600 hover:bg-green-800 text-white text-sm font-bold py-2 px-4 rounded' => 'btn-accent',
    'bg-green-600 hover:bg-green-700 text-white text-sm font-bold py-2 px-5 rounded-lg' => 'btn-accent',
    'bg-green-500 text-white font-bold py-3 px-8 rounded-full shadow-lg transform hover:scale-105 transition' => 'btn-accent',

    // ── Boutons Danger ──
    'text-red-600 hover:text-red-900' => 'text-red-600 hover:text-red-700 font-medium',

    // ── Formulaires ──
    'w-full border-gray-300 rounded-md shadow-sm' => 'form-input',
    'w-full border-gray-300 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400' => 'form-input',
    'block text-sm font-medium text-gray-700 mb-1' => 'form-label',
    'block text-sm font-medium border border-gray-300 rounded block w-full bg-white p-2 mb-2' => 'form-input',

    // ── Textes & Autres ──
    'text-gray-800' => 'text-slate-800',
    'text-gray-500' => 'text-slate-500',
    'text-gray-600' => 'text-slate-600',
    'text-gray-900' => 'text-slate-800',
    'bg-gray-50'  => 'bg-slate-50',
    'bg-gray-200' => 'bg-slate-200',
    'bg-gray-300' => 'bg-slate-300',
    'border-gray-200' => 'border-slate-200',
    'border-gray-300' => 'border-slate-300',
];

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsDir));

$count = 0;
foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $path = $file->getRealPath();
        $content = file_get_contents($path);
        
        $originalContent = $content;
        
        foreach ($replacements as $search => $replace) {
            $content = str_replace($search, $replace, $content);
        }

        if ($content !== $originalContent) {
            file_put_contents($path, $content);
            $count++;
        }
    }
}

echo "Refactored $count views.\n";
