<?php
#
# Includes
#

include_once('scripts/application.php');
include_once('scripts/settings.php');
include_once('scripts/util.php');

#
# Settings
#

if ($_POST['OPTIONS'] != '') {
	$SETTINGS['ERROR'] = in_array('ERROR', $_POST['OPTIONS']) ? 1 : 0;
	$SETTINGS['WARNING'] = in_array('WARNING', $_POST['OPTIONS']) ? 1 : 0;
}

$SETTINGS['LANGUAGE'] = $_POST['LANGUAGE'];

#
# Data
#

$DATA = array();
$DATA['TEXT'] = trim($_POST['TEXT']);

$DATA['FILE'] = array();
$DATA['FILE']['NAME'] = $_FILES['FILE']['name'];
$DATA['FILE']['PATH'] = $_FILES['FILE']['tmp_name'];

#
# Validate
#

if ($_POST['VALIDATE'] == 1){
	validate($DATA, $SETTINGS);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<title>Home | nclvs - NCL Validation Service</title>
    
    <link rel="stylesheet" type="text/css" href="css/default.css"/>
</head>

<body>
	<div id="MENU">
		<ul>
			<li><a href="index.php">Home</a></li>
            <li><a href="https://github.com/edcaraujo/nclvs/" target="_blank">Git</a></li>
            <li><a href="contact.php">Contato</a></li>
            <li><a href="about.php">Sobre</a></li>
		</ul>	
	</div>

    <div id="TITLE">
		<h1>nclvs</h1>
		<h2>NCL Validation Service</h2>
		<p><a href="<?php echo $SETTINGS['URL']; ?>"><?php echo $SETTINGS['URL']; ?></a></p>
	</div>
	    
	<div id="CONTENT">
		<h1>Home</h1>
        
        <div>
			<h2><?php echo $SETTINGS['VERSION']; ?></h2>

            <?php p('STATUS', $LOG);  ?>
            
            <form name="input" enctype="multipart/form-data" action="index.php" method="post">
            	<input type="hidden" name="VALIDATE" value="1"/>
            
            	<h3>1 - Escolha o seu arquivo</h3>
            	<p>Você pode fazer o upload de arquivos <span style="font-weight: bold;">*.ncl</span>, <span style="font-weight: bold;">*.zip</span> ou <span style="font-weight: bold;">*.tar.gz</span>...</p>
                <input type="file" name="FILE" style="width: 100%"/> 
                
                <p>ou copiar o seu código abaixo.</p>
                <textarea name="TEXT" style="width: 100%; height: 300px;" rows="0" cols="0"><?php echo stripslashes($DATA['TEXT']); ?></textarea>
                
                <h3>2 - Configure suas preferências</h3>
                <input type="checkbox" name="OPTIONS[]" value="ERROR" checked="checked"/>Erros
                <input type="checkbox" name="OPTIONS[]" value="WARNING" checked="checked"/>Alertas
                
                <select name="LANGUAGE">
                	<option value="en_US">Inglês</option>
                    <option value="es_ES">Espanhol</option>
                	<option value="pt_BR" selected="selected">Português (Brasil)</option> 
                </select>
                
                <h3>3 - Clique em &quot;Validar!&quot;</h3>
                <p><input type="submit" value="Validar!"/></p>
            </form>
            
            <?php p('RESULT', $LOG); ?>
        </div>
    </div>
	
    <div id="FOOTER">
		<p><a href="<?php echo $SETTINGS['URL']; ?>en/">English</a> | <a href="<?php echo $SETTINGS['URL']; ?>">Portugu&ecirc;s</a> - Copyright &copy; <a href="http://www.telemidia.puc-rio.br/~edcaraujo/">edcaraujo</a></p>
        <p><a href="http://jigsaw.w3.org/css-validator/check/referer"><img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!" /></a><a href="http://validator.w3.org/check?uri=referer"><img
      src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a></p>
      <p></p>
	</div>
</body>
</html>

