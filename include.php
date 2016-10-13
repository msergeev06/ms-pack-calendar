<?php

// ---- SETUP ----
$packageName = "calendar";
// ---------------

use \MSergeev\Core\Lib\Config;
use \MSergeev\Core\Lib\Loader;

$packageNameToUpper = strtoupper($packageName);
Config::addConfig($packageNameToUpper.'_ROOT',Config::getConfig('PACKAGES_ROOT').$packageName."/");
Config::addConfig($packageNameToUpper.'_PUBLIC_ROOT',Config::getConfig('PUBLIC_ROOT').$packageName."/");
Config::addConfig($packageNameToUpper.'_TOOLS_ROOT',str_replace(Config::getConfig("SITE_ROOT"),"",Config::getConfig('PACKAGES_ROOT').$packageName."/tools/"));
Config::addConfig($packageNameToUpper.'_DEFAULT_COLOR','#c6c6c6');

//***** Tables ********
Loader::includeFiles(Config::getConfig($packageNameToUpper.'_ROOT')."tables/");

//***** Lib ********
Loader::includeFiles(Config::getConfig($packageNameToUpper.'_ROOT')."lib/");