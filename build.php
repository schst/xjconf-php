<?php
require 'star/starWriter.php';
$starArchive = new StarArchive(new StarWriter('build/xjconf.star'));
$dirIt       = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('XJConf'));
foreach ($dirIt as $file) {
    if ($file->isFile() == false || substr($file->getPathname(), -4) != '.php') {
        continue;
    }
    
    $fqClassName = str_replace('/', '::', str_replace('XJConf/', 'net/xjconf/', str_replace(DIRECTORY_SEPARATOR, '/', str_replace('.php', '', $file->getPathname()))));
    $starArchive->add(new StarFile($file->getPathname(), __DIR__), $fqClassName);
}
$starArchive->addMetaData('title', 'XJConf for PHP');
$starArchive->addMetaData('package', 'net::xjconf');
$starArchive->addMetaData('version', '0.4.0dev');
$starArchive->addMetaData('author', 'XJConf Development Team <http://php.xjconf.net>');
$starArchive->addMetaData('copyright', '(c) 2007-2008 XJConf Development Team');
$starArchive->create();
?>