<?php

namespace NovaBi\NovaDashboardManager\Helpers\Files;

//https://stackoverflow.com/questions/31837075/laravel-get-list-of-models
function getClassesList($dir)
{
    $classesFiles = \File::allFiles($dir);
    foreach ($classesFiles as $classesFile) {
        $classesFile->classname = str_replace(
            [app_path(), base_path(), '/', '.php'],
            ['App', 'base', '\\', ''],
            $classesFile->getRealPath()
        );
    }
    return $classesFiles;
}

function getFilesList($dir)
{
    $files = \File::allFiles($dir);
    return $files;
}
