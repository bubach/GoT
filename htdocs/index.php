<?php

/***
 * Name:       JooX 2.0
 * About:      Streaming platform built on TinyMVC
 * Copyright:  (C) 2007-2014, Joox ltd.
 * Author:     Christoffer Bubach
 * License:    Public Domain and LGPL for the MVC
 ***/

/* PHP error reporting level, if different from default */
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(E_ALL);

/* if the /tinymvc/ dir is not up one directory, uncomment and set here */
//define('TMVC_BASEDIR','../tinymvc/');

/* if the /myapp/ dir is not inside the /tinymvc/ dir, uncomment and set here */
//define('TMVC_MYAPPDIR','/path/to/myapp/');

/* define to 0 if you want errors/exceptions handled externally */
define('TMVC_ERROR_HANDLING',1);

/* directory separator alias */
if(!defined('DS'))
  define('DS',DIRECTORY_SEPARATOR);

/* set the base directory */
if(!defined('TMVC_BASEDIR'))
  define('TMVC_BASEDIR',dirname(__FILE__) . DS . '..' . DS . 'tinymvc' . DS);

/* include main tmvc class */
require(TMVC_BASEDIR . 'sysfiles' . DS . 'TinyMVC.php');

/* instantiate */
$tmvc = new tmvc();

/* tally-ho! */
$tmvc->main();

?>
