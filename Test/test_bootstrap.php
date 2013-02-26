<?php
/**
 * This file is declared to serve tests specific bootstrap logic
 * to provide global settings when running unit tests
 */

// Raise error reporting level
// and displays all errors
error_reporting( E_ALL | E_STRICT );
ini_set('display_errors','On');
ini_set('display_startup_errors','On');

// Autload project level bootstrap file
require_once( __DIR__ . '/../bootstrap.php' );

