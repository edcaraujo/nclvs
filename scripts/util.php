<?php
#
# Functions
#

function p($TYPE, $LOG)
{
	switch ($TYPE){
		// status
		case 'STATUS':
			pstatus($LOG);
			break;
			
		// result
		case 'RESULT':
			presult($LOG);
			break;
	}
}

function pstatus($LOG)
{
	switch ($LOG['STATUS']){
		// unknow
		case -1:
			break;
		
		// no such file
		case  1:
		
		// unable to copying
		case  2:
		
		// unable to validate
		case  3:
		
		// unable to log
		case  4:
		
		// unable to remove
		case  5:
			echo '<p style="border: #700 solid 3px; text-align:center; color: #FFF; background: #900; padding: 5px 5px 5px 5px;">';
		
			if ($LOG['LANGUAGE'] == 'en_US'){
				echo 'Sorry! This document cannot be checked.';
				
			}else if ($LOG['LANGUAGE'] == 'pt_BR'){
				echo 'Desculpe! Esse documento não pode ser avaliado.';
			}
			
			echo '</p>';
			
			break;
			
		// normal	
		case 0:
			$NERRORS = $NWARNINGS = 0;
			
			foreach ($LOG['FILES'] as $FILE){ 
				$NERRORS += count($FILE['ERRORS']); $NWARNINGS += count($FILE['WARNINGS']);
			}
			
			if ($NERRORS > 0){
				echo '<p style="border: #700 solid 3px; color: #FFF; background: #900;  text-align:center; padding: 5px 5px 5px 5px;">';
				if ($NWARNINGS > 0){
					
					if ($LOG['LANGUAGE'] == 'en_US'){
						// X errors and Y warnings found while checking Z document(s)!
						echo '<span style="font-weight: bold;">'.$NERRORS.'</span> errors and <span style="font-weight: bold;">'.$NWARNINGS.'</span> warnings found while checking <span style="font-weight: bold;">'.count($LOG['FILES']).'</span> '.(count($LOG['FILES']) > 1 ? 'documents' : 'document').'! '.'<a style="color: #FFF; text-decoration: underline;" href="#RESULT">Result</a>';
						
					}else if ($LOG['LANGUAGE'] == 'pt_BR'){
						// X erros e Y alertas foram encontrados em Z documento(s) avaliado(s)! Output
						echo '<span style="font-weight: bold;">'.$NERRORS.'</span> erros e <span style="font-weight: bold;">'.$NWARNINGS.'</span> alertas foram encontrados em <span style="font-weight: bold;">'.count($LOG['FILES']).'</span> '.(count($LOG['FILES']) > 1 ? 'documentos avaliados' : 'documento avaliado').'! '.'<a style="color: #FFF; text-decoration: underline;" href="#RESULT">Resultado</a>';
					}
					
				}else{
					
					if ($LOG['LANGUAGE'] == 'en_US'){
						// X errors found while checking Z document(s)! Result
						echo '<span style="font-weight: bold;">'.$NERRORS.'</span> errors found while checking <span style="font-weight: bold;">'.count($LOG['FILES']).'</span> '.(count($LOG['FILES']) > 1 ? 'documents' : 'document').'! '.'<a style="color: #FFF; text-decoration: underline;" href="#RESULT">Result</a>';
						
					}else if ($LOG['LANGUAGE'] == 'pt_BR'){
						// X erros foram encontrados em Z documento(s) avaliado(s)! Result
						echo '<span style="font-weight: bold;">'.$NERRORS.'</span> erros foram encontrados em <span style="font-weight: bold;">'.count($LOG['FILES']).'</span> '.(count($LOG['FILES']) > 1 ? 'documentos avaliados' : 'documento avaliado').'! '.'<a style="color: #FFF; text-decoration: underline;" href="#RESULT">Resultado</a>';
					}
					
				}
				
				echo '</p>';
			
			// warnings
			}else if ($NWARNINGS > 0){
				echo '<p style="border: #700 solid 3px; text-align:center; color: #FFF; background: #900; padding: 5px 5px 5px 5px;">';
				
				if ($LOG['LANGUAGE'] == 'en_US'){
						// Y warnings found while checking Z document(s)! Output
						echo '<span style="font-weight: bold;">'.$NWARNINGS.'</span> warnings found while checking <span style="font-weight: bold;">'.count($LOG['FILES']).'</span> '.(count($LOG['FILES']) > 1 ? 'documents' : 'document').'! '.'<a style="color: #FFF; text-decoration: underline;" href="#RESULT">Result</a>';
					
				}else if ($LOG['LANGUAGE'] == 'pt_BR'){
					// Y alertas foram encontrados em Z documento(s) avaliado(s)! Output
					echo '<span style="font-weight: bold;">'.$NWARNINGS.'</span> alertas foram encontrados em <span style="font-weight: bold;">'.count($LOG['FILES']).'</span> '.(count($LOG['FILES']) > 1 ? 'documentos avaliados' : 'documento avaliado').'! '.'<a style="color: #FFF; text-decoration: underline;" href="#RESULT">Resultado</a>';
				}
				
				echo '</p>';
			
			// 
			}else{
				echo '<p style="border: #050 solid 3px; text-align:center; color: #FFF; background: #063; padding: 5px 5px 5px 5px;">';
				if ($LOG['LANGUAGE'] == 'en_US'){
					// Z document(s) were successfully checked!
					echo '<span style="font-weight: bold;">'.count($LOG['FILES']).'</span> '.(count($LOG['FILES']) > 1 ? 'documents were' : 'document was').' successfully checked!';		
					
				}else if ($LOG['LANGUAGE'] == 'pt_BR'){
					// Z documento(s) foram avaliados com sucesso!
					echo '<span style="font-weight: bold;">'.count($LOG['FILES']).'</span> '.(count($LOG['FILES']) > 1 ? 'documentos foram avaliados' : 'documento foi avaliado').' com sucesso!';
				}
				
				echo '</p>';	
			}	
		
			break;
	}
}

function presult($LOG)
{
	switch ($LOG['STATUS']){
		// unknow
		case -1:
		
		// no such file
		case  1:
		
		// unable to copying
		case  2:
		
		// unable to validate
		case  3:
		
		// unable to log
		case  4:
		
		// unable to remove
		case  5:
			break;
			
		// normal	
		case 0:
			$NE = $NW = 0;

			foreach ($LOG['FILES'] as $FILE){
				$NE += count($FILE['ERRORS']);
				$NW += count($FILE['WARNINGS']);
			}
			
			if ($NE > 0 || $NW > 0){
				echo '<div id="RESULT">';
	
				if ($LOG['LANGUAGE'] == 'en_US'){
					echo '<h2>Result</h2>';
					
				}else if ($LOG['LANGUAGE'] == 'pt_BR'){
					echo '<h2>Resultado</h2>';
				}
				
				$TOTAL = 0;
	
				foreach ($LOG['FILES'] as $FILE){
					$NERROR = count($FILE['ERRORS']);
					$NWARNING = count($FILE['WARNINGS']);
									
					if (($NERROR + $NWARNING) > 0){ 			
						if ($LOG['LANGUAGE'] == 'en_US'){
							echo '<p><span style="font-weight: bold;">File:</span> '.$FILE['NAME'].'<br/><span style="font-weight: bold;">Date:</span> '.$FILE['DATE'].'</p>';
						
						}else if ($LOG['LANGUAGE'] == 'pt_BR'){
							echo '<p><span style="font-weight: bold;">Arquivo:</span> '.$FILE['NAME'].'<br/><span style="font-weight: bold;">Data:</span> '.$FILE['DATE'].'</p>';
						}
					}	
					
					echo '<table cellspacing="0" cellpadding="5px">';    
						
						for ($N = 0; $N < $NERROR; $N++){
							if ($N%2 !== 0){
								echo '<tr>';
							}else{
								echo '<tr style="background-color: #EEE;">';
							}
							
							echo '<td style="text-align: center;"><img style="width: 16px; height:16px; padding: 0px 0px 0px 0px;"  src="'.$LOG['/'].'/images/png/icon-error.png" alt="Error"/></td>';			
							echo '<td style="width: 25px; text-align: center; font-weight: bold;">#'.($TOTAL+1).':</td>';
							echo '<td style="width: 25px; text-align: center;">'.$FILE['ERRORS'][$N]['L'].'</td>';
							echo '<td style="width: 25px; text-align: center;">'.$FILE['ERRORS'][$N]['C'].'</td>';
							echo '<td style="width: 400px;">'.$FILE['ERRORS'][$N]['M'].'</td>';
							echo '</tr>';
							
							$TOTAL++;
						}
						
						for ($N = 0; $N < $NWARNING; $N++){
							if (($NERROR+$N)%2 !== 0){
								echo '<tr>';
							}else{
								echo '<tr style="background-color: #EEE;">';
							}
							
							echo '<td style="text-align: center;"><img style="width: 16px; height:16px; padding: 0px 0px 0px 0px;" src="'.$LOG['/'].'/images/png/icon-warning.png" alt="Error"/></td>';			
							echo '<td style="width: 25px; text-align: center; font-weight: bold;">#'.($TOTAL+1).':</td>';
							echo '<td style="width: 25px; text-align: center;">'.$FILE['WARNINGS'][$N]['L'].'</td>';
							echo '<td style="width: 25px; text-align: center;">'.$FILE['WARNINGS'][$N]['C'].'</td>';
							echo '<td style="width: 400px;">'.$FILE['WARNINGS'][$N]['M'].'</td>';
							echo '</tr>';
							
							$TOTAL++;
						}
						
						echo "</table>";
					
				}
				
				echo '</div>';
			}
	
	}
}
