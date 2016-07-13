<?php
#
# Settings
#

$SETTINGS = array();

//
// / - the root directory. 
// 
//		Default:
//			$LOG['/'] = '.';
//
$SETTINGS['/'] = '.'; 

//
// Workspace - default directory where the 
// 		*.ncl and *.log files are handled.
//
//		Default:
//			$SETTINGS['WORKSPACE'] = '/tmp';
//
$SETTINGS['WORKSPACE'] = '/tmp';

//
// Binary -
//
//		Default:
//			$SETTINGS['BINARY'] = 'nclvalidator-1.7.0.jar';
//
$SETTINGS['BINARY'] = 'nclvalidator-1.7.0.jar';

//
// Version - current version.
//
//		Default:
//			$SETTINGS['VERSION'] = 'Unknow';
//
$SETTINGS['VERSION'] = '1.5.0';


//
// URL -
//
//		Default:
//			$SETTINGS['URL'] = 'http://localhost/nclvs/';
//
$SETTINGS['URL'] = 'http://localhost/nclvs/';


//
// Language -
// 
//		Avaiable values:
//		   	pt_BR
//			en_US
//
//		Default:
//			$LOG['LANGUAGE'] = 'en_US';
//
$SETTINGS['LANGUAGE'] = 'pt_BR'; 
?>