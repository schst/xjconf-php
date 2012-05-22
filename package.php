<?php
/**
 * script to automate the generation of the
 * package.xml file.
 *
 * $Id: package.php 442 2006-08-20 13:21:58Z schst $
 *
 * @author      Stephan Schmidt <schst@php-tools.net>
 * @package     XJConfForPHP
 * @subpackage  Tools
 */

/**
 * uses PackageFileManager
 */
require_once 'PEAR/PackageFileManager2.php';
require_once 'PEAR/PackageFileManager/Svn.php';

/**
 * current version
 */
$version = '0.4.0dev';

/**
 * Current API version
 */
$apiVersion = '0.4.0';

/**
 * current state
 */
$state = 'alpha';

/**
 * current API stability
 */
$apiStability = 'alpha';

/**
 * release notes
 */
$notes = <<<EOT
Feature additions:
- ported to PHP 5.3 using namespaces (mikey)
EOT;

/**
 * package description
 */
$description = <<<EOT
XJConfForPHP is a port of XJConf. It enables you to create complex data structures consisting of
objects, arrays and primitives from virtually any XML document. It provides a simple XML language
to define the XML-to-object mappings. It features namespace support and is easily extendible.
EOT;

$package = new PEAR_PackageFileManager2();

$result = $package->setOptions(array(
    'filelistgenerator' => 'svn',
    'ignore'            => array( 'package.php', 'package.xml', '.svn', 'rfcs' ),
    'simpleoutput'      => true,
    'baseinstalldir'    => '/',
    'packagedirectory'  => './',
    'dir_roles'         => array(
                                 'docs' => 'doc',
                                 'examples' => 'doc',
                                 'tests' => 'test',
                                 )
    ));
if (PEAR::isError($result)) {
    echo $result->getMessage();
    die();
}

$package->setPackage('XJConfForPHP');
$package->setSummary('XML-to-object mapper.');
$package->setDescription($description);

$package->setChannel('pear.php-tools.net');
$package->setAPIVersion($apiVersion);
$package->setReleaseVersion($version);
$package->setReleaseStability($state);
$package->setAPIStability($apiStability);
$package->setNotes($notes);
$package->setPackageType('php');
$package->setLicense('LGPL', 'http://www.gnu.org/copyleft/lesser.txt');

$package->addMaintainer('lead', 'schst', 'Stephan Schmidt', 'schst@xjconf.net', 'yes');
$package->addMaintainer('lead', 'mikey', 'Frank Kleine', 'mikey@xjconf.net', 'yes');

$package->setPhpDep('5.3.0-dev');
$package->setPearinstallerDep('1.4.0');

$package->addExtensionDep('required', 'xmlreader');

$package->generateContents();

if (isset($_GET['make']) || (isset($_SERVER['argv'][1]) && $_SERVER['argv'][1] == 'make')) {
    $result = $package->writePackageFile();
} else {
    $result = $package->debugPackageFile();
}

if (PEAR::isError($result)) {
    echo $result->getMessage();
    die();
}
?>