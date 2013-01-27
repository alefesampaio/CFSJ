<?

function meses() {
	$mes[1] = 'Enero';
	$mes[] = 'Febrero';
	$mes[] = 'Marzo';
	$mes[] = 'Abril';
	$mes[] = 'Mayo';
	$mes[] = 'Junio';
	$mes[] = 'Julio';
	$mes[] = 'Agosto';
	$mes[] = 'Septiembre';
	$mes[] = 'Octubre';
	$mes[] = 'Noviembre';
	$mes[] = 'Diciembre';
	
	return $mes;
}

function preparar($value, $do_like = false)
{   $value = stripslashes($value);
    if ($do_like){
	$value = str_replace(array('%', '_'), array('\%', '\_'), $value);
		}
    if (function_exists('mysql_real_escape_string')){
	return mysql_real_escape_string($value);
		}
    else { return mysql_escape_string($value); 	}
}

function validEmail($email) {
	$isValid = true;
	$atIndex = strrpos($email, "@");
	if (is_bool($atIndex) && !$atIndex) {
		$isValid = false;
	} else {
		$domain = substr($email, $atIndex+1);
		$local = substr($email, 0, $atIndex);
		$localLen = strlen($local);
		$domainLen = strlen($domain);
		if ($localLen < 1 || $localLen > 64) {
		 // local part length exceeded
		 $isValid = false;
		} else if ($domainLen < 1 || $domainLen > 255) {
		 // domain part length exceeded
		 $isValid = false;
		} else if ($local[0] == '.' || $local[$localLen-1] == '.') {
		 // local part starts or ends with '.'
		 $isValid = false;
		} else if (preg_match('/\\.\\./', $local)) {
		 // local part has two consecutive dots
		 $isValid = false;
		} else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
		 // character not valid in domain part
		 $isValid = false;
		} else if (preg_match('/\\.\\./', $domain)) {
		 // domain part has two consecutive dots
		 $isValid = false;
		} else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))) {
		 // character not valid in local part unless 
		 // local part is quoted
		 if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local))) {
			$isValid = false;
		 }
		}
		if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))) {
		 // domain not found in DNS
		 $isValid = false;
		}
	}
	return $isValid;
}

function obtenerExtensionFichero($str)
{
        return end(explode(".", $str));
}

function obtenerTamanio($peso , $decimales = 2 ) {
$clase = array(" Bytes", " KB", " MB", " GB", " TB"); 
return round($peso/pow(1024,($i = floor(log($peso, 1024)))),$decimales ).$clase[$i];
}

?>