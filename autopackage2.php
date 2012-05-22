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
 * Base version
 */
$baseVersion = '0.2.0';

/**
 * current version
 */
$version    = $baseVersion . 'dev' . $argv[1];
$dir        = dirname( __FILE__ );

/**
 * Current API version
 */
$apiVersion = '0.2.0';

/**
 * current state
 */
$state = 'devel';

/**
 * current API stability
 */
$apiStability = 'alpha';

/**
 * release notes
 */
$notes = <<<EOT
Feature additions:
- New feature to define abstract tags, which enables yo to define the concrete type in the tag instead of the definition (mikey)
- It is now possible to define an explicit setter method for character data inside a tag (schst)
- Added possibility to declare tags as static (schst)
- Added several unit tests (mikey)
- Added possibility to package XJConfForPHP as a STAR archive (mikey, schst)
- Added new value type "xjonf:auto-primitive" to guess the type of a scalar value (schst)
- Added implicit and explicit call to __set as well as possibility for setting public properties (mikey)
Bugfixes:
- Fixed bug #6: Enable factory methods without parameters in PHP 5.0.x (schst)
- Fixed bug #7: check, whether factory method can be called statically (schst)
- Fixed bug: prevent errors in case factory method does not return an instance of an object (mikey)
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
    'filelistgenerator' => 'file',
    'ignore'            => array( 'package.php', 'autopackage2.php', 'package.xml', '.svn', 'rfcs' ),
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

$package->setPhpDep('5.0.0');
$package->setPearinstallerDep('1.4.0');

$package->addExtensionDep('required', 'xmlreader');

$package->generateContents();

$result = $package->writePackageFile();

if (PEAR::isError($result)) {
    echo $result->getMessage();
    die();
}
?>