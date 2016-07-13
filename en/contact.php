<?php
#
# Includes
#

include_once('../scripts/settings.php');

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<title>Contact | nclvs - NCL Validation Service</title>

    <link rel="stylesheet" type="text/css" href="../css/default.css"/>
</head>

<body>
	<div id="MENU">
		<ul>
			<li><a href="index.php">Home</a></li>
            <li><a href="https://github.com/edcaraujo/nclvs/" target="_blank">Git</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="about.php">About</a></li>
		</ul>	
	</div>

    <div id="TITLE">
		<h1>nclvs</h1>
		<h2>NCL Validation Service</h2>
		<p><a href="<?php echo $SETTINGS['URL']; ?>"><?php echo $SETTINGS['URL']; ?></a></p>
	</div>
	    
	<div id="CONTENT">
		<h1>Contact</h1>
        
        <div>
        	<h2>Email</h2>
            <p><img style="height:20px; width: 220px;" src="../images/png/img-mail.png" alt="Email"/></p>
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

