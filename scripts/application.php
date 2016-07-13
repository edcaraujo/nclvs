<?php
#
# Includes
#
include_once('settings.php');

#
# Variables
#
$LOG = array();

//
// / -
// 
//		Default:
//			$LOG['/'] = $SETTINGS['/'];
//
$LOG['/'] = $SETTINGS['/']; 

//
// Workspace -
//
//		Default:
//			$LOG['WORKSPACE'] = $SETTINGS['WORKSPACE'];
//
$LOG['WORKSPACE'] = $SETTINGS['WORKSPACE'];

//
// Binary -
//
//		Default:
//			$LOG['BINARY'] = $SETTINGS['BINARY'];
//
$LOG['BINARY'] = $SETTINGS['BINARY'];

//
// Version -
//
//		Default:
//			$LOG['VERSION'] = $SETTINGS['VERSION'];
//
$LOG['VERSION'] = $SETTINGS['VERSION'];

//
// Language -
//
//		Default:
//			$LOG['LANGUAGE'] = $SETTINGS['LANGUAGE'];
//
$LOG['LANGUAGE'] = $SETTINGS['LANGUAGE']; 

//
// Date -
//
//		Default:
//			$LOG['DATE'] = 'Unknow';
//
$LOG['DATE'] = 'Unknow';

//
// Status -
// 
//		Avaiable values:
//		   -1 - unknow
//			0 - normal
//			1 - no such file
//			2 - unable to copying
//			3 - unable to validate
//			4 - unable to log
//			5 - unable to remove
//
//		Default:
//			$LOG['STATUS'] = -1;
//
$LOG['STATUS'] = -1; 

//
// Files - 
// 
//		Default:
//			$LOG['FILES'] = array();
//
$LOG['FILES'] = array();

#
# Functions
#

function validate($DATA, $SETTINGS)
{
	global $LOG;
	
	// configuring...
	date_default_timezone_set("America/Sao_Paulo");
	
	$LOG['/'] = $SETTINGS['/'];
	$LOG['WORKSPACE'] = $SETTINGS['WORKSPACE'];
	
	$LOG['BINARY'] = $SETTINGS['BINARY'];
	$LOG['VERSION'] = $SETTINGS['VERSION'];
	$LOG['LANGUAGE'] = $SETTINGS['LANGUAGE'];
	
	$LOG['DATE'] = date("Y-m-d G:i:s");
	
	// checking data...
	if ($DATA['FILE']['NAME'] == '' && $DATA['TEXT'] == ''){
		return ($LOG['STATUS'] = 1);
	}
	
	// copying data...
	$FILES = array();
	
	if ($DATA['FILE']['NAME'] != ''){
		$TYPE = end(explode('.', $DATA['FILE']['NAME']));
		
		switch ($TYPE){
			case 'ncl':
				$FILES[0] = array();
				$FILES[0]['UID'] = md5(time());
				$FILES[0]['NAME'] = $DATA['FILE']['NAME'];
				$FILES[0]['PATH'] = $LOG['WORKSPACE'].'/'.$FILES[0]['UID'].'.ncl';
				
				$FILES[0]['LOG'] = $FILES[0]['PATH'].'.log';
				
				if (move_uploaded_file($DATA['FILE']['PATH'], $FILES[0]['PATH']) == FALSE){
					return ($LOG['STATUS'] = 2);
				}
				
				break;
				
			case 'zip':
				$ZIP = array();
				$ZIP['UID'] = md5(time());
				$ZIP['NAME'] = $DATA['FILE']['NAME'];
				$ZIP['PATH'] = $LOG['WORKSPACE'].'/'.$ZIP['UID'].'.zip';
			
				if (move_uploaded_file($DATA['FILE']['PATH'], $ZIP['PATH']) == FALSE){
					return ($LOG['STATUS'] = 2);
				}
			
				$DIR['NAME'] = $ZIP['UID'];
				$DIR['PATH'] = $LOG['WORKSPACE'].'/'.$DIR['NAME'];
				
				exec('unzip '.$ZIP['PATH'].' -d '.$DIR['PATH']);
				
				$FILES = search('ncl', $DIR['PATH']); 
			
				break;
				
			case 'gz':
				$GZ = array();
				$GZ['UID'] = md5(time());
				$GZ['NAME'] = $DATA['FILE']['NAME'];
				$GZ['PATH'] = $LOG['WORKSPACE'].'/'.$GZ['UID'].'.tar.gz';
			
				if (move_uploaded_file($DATA['FILE']['PATH'], $GZ['PATH']) == FALSE){
					return ($LOG['STATUS'] = 2);
				}
			
				$DIR['NAME'] = $GZ['UID'];
				$DIR['PATH'] = $LOG['WORKSPACE'].'/'.$DIR['NAME'];
				
				exec('mkdir '.$DIR['PATH']);
				exec('tar -xzf '.$GZ['PATH'].' -C '.$DIR['PATH']);
				
				$FILES = search('ncl', $DIR['PATH']); 
			
				break;
				
			default:
				return ($LOG['STATUS'] = 2);
				break;
		}
	}else if ($DATA['TEXT'] != ''){
		$FILES[0] = array();
		$FILES[0]['UID'] = md5(time());
		$FILES[0]['NAME'] = $FILES[0]['UID'].'ncl';
		$FILES[0]['PATH'] = $LOG['WORKSPACE'].'/'.$FILES[0]['UID'].'.ncl';
		
		$FILES[0]['LOG'] = $FILES[0]['PATH'].'.log';
		
		if (($handle = fopen($FILES[0]['PATH'], "w")) !== FALSE){
			if (fwrite($handle, stripcslashes($DATA['TEXT'])) == FALSE){
				return ($LOG['STATUS'] = 2);
			}
		}else{
			return ($LOG['STATUS'] = 2);
		}
	}
	
	foreach($FILES as $FILE){
		// validating data...		
		if (`which java`) {
			exec('java -jar '.$LOG['/'].'/bin/'.$LOG['BINARY'] .' -nl '.$LOG['LANGUAGE'].' -o '.$FILE['LOG'].' '.$FILE['PATH']);
		}else{
			die('Sorry, but I couldn\'t find Java. :(');
		}
		
		// loggging data...
		$FILE['DATE'] = date("Y-m-d G:i:s");
		
		$FILE['ERRORS'] = $FILE['WARNINGS'] = array();
		
		if (($handle = fopen($FILE['LOG'], "r")) !== FALSE){	
			while (!feof($handle)){		
				$line = fgets($handle);
	
				if (strpos($line, "[E]") !== FALSE && $SETTINGS['ERROR'] == 1){
					list($STATUS, $LINE, $COLUMN, $MESSAGE) = explode(":", $line, 4);
					
					$N = count($FILE['ERRORS']);
					
					$FILE['ERRORS'][$N] = array();
					$FILE['ERRORS'][$N]['L'] = trim($LINE);
					$FILE['ERRORS'][$N]['C'] = trim($COLUMN);
					$FILE['ERRORS'][$N]['M'] = trim(htmlspecialchars($MESSAGE));
				
				}else if (strpos($line, "[W]") !== FALSE && $SETTINGS['WARNING'] == 1){
					list($STATUS, $LINE, $COLUMN, $MESSAGE) = explode(":", $line, 4);
					
					$N = count($FILE['WARNINGS']);
					
					$FILE['WARNINGS'][$N] = array();
					$FILE['WARNINGS'][$N]['L'] = trim($LINE);
					$FILE['WARNINGS'][$N]['C'] = trim($COLUMN);
					$FILE['WARNINGS'][$N]['M'] = trim(htmlspecialchars($MESSAGE));
				}
			}
			
			fclose($handle);
		}else{
			die("NAO CONSEGUI ABRIR O ARQUIVO PARA LEITURA");

			return ($LOG['STATUS'] = 4);
		}
		
		$LOG['FILES'][count($LOG['FILES'])] = $FILE;
		
		// removing data...
		exec('rm -rf '.$FILE['PATH'].' '.$FILE['LOG']);
	}
	
	// removing data...
	exec('rm -rf '.$DIR['PATH']);
	exec('rm -rf '.$ZIP['PATH']);
	exec('rm -rf '.$GZ['PATH']);
	
	return ($LOG['STATUS'] = 0);
}

function errors()
{
	global $LOG;

	$ERRORS = array();
	
	foreach ($LOG['FILES'] as $FILE){
		$ERRORS = array_merge($ERRORS, $FILE['ERRORS']);
	}
	
	return $ERRORS;
}

function warnings()
{
	global $LOG;

	$WARNINGS = array();
	
	foreach ($LOG['FILES'] as $FILE){
		$WARNINGS = array_merge($WARNINGS, $FILE['WARNINGS']);
	}
	
	return $WARNINGS;
}

function search($TYPE, $DIR)
{
	$FILES = array();
	
	if ($handle = opendir($DIR)){
		while (($entry = readdir($handle)) !== FALSE){
			if ($entry != '.' && $entry != '..'){			
				if ($TYPE == strtolower(end(explode('.', $entry)))) {
					$FILE = array();
					$FILE['NAME'] = $entry;
					$FILE['PATH'] = $DIR.'/'.$FILE['NAME'];
					
					$FILE['LOG'] = $FILE['PATH'].'.log'; 
					
					$FILES[count($FILES)] = $FILE;
				
				}else if (is_dir($DIR.'/'.$entry)){
					$FILES = array_merge($FILES, search($TYPE, $DIR.'/'.$entry));
				}
			}
		}
		
		closedir($handle);
	}
	
	return $FILES;
}

?>