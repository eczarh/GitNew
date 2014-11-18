<?php
$codeDir = str_replace(DIRECTORY_SEPARATOR, '/', realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . DIRECTORY_SEPARATOR);

// файлы, которые генерировал в процессе разработки - удаляем
{
    $generateResultDir = str_replace(
        DIRECTORY_SEPARATOR,
        '/',
        __DIR__ . DIRECTORY_SEPARATOR . 'generate-result' . DIRECTORY_SEPARATOR
    );

    if (is_dir($generateResultDir)) {
        removeDir($generateResultDir);
    }
    mkdir($generateResultDir, 0777, true);
}

$zipFileName = $codeDir . 'result.zip';
if (file_exists($zipFileName)) {
    unlink($zipFileName);
}

$zip = new ZipArchive;
if ($zip->open($zipFileName, ZipArchive::CREATE) !== true) {
    echo 'Could not create archive!';
    exit();
}
addFolderToZip($codeDir, $zip);
$zip->close();

echo 'done';

function addFolderToZip($dir, $zipArchive, $zipdir = '') {
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            if(!empty($zipdir)) {
                $zipArchive->addEmptyDir($zipdir); 
            }
           
            while (($file = readdir($dh)) !== false) {
                if(!is_file($dir . $file)) {
                    if( ($file !== '.') && ($file !== '..')){ 
                        addFolderToZip($dir . $file . '/', $zipArchive, $zipdir . $file . '/'); 
                    }
                } else {
                    $zipArchive->addFile($dir . $file, $zipdir . $file); 
                }
            }
            closedir($dh);
        }
    }
}

function removeDir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . '/' . $object) == 'dir') {
                    removeDir($dir . '/' . $object);
                } else {
                    unlink( $dir . '/' . $object);
                }
            }
        }
        reset($objects);
        rmdir($dir);
    }
}
