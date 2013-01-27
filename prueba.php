<? 
//ini_set("display_errors", 1);
//echo (mysql_select_db('taller',mysql_connect('186.129.253.108', 'root' , 'cydonia'))) ? "Conectado a la base de datos" : "No se pudo conectar";
require_once 'DAL/db.class.php';	  
require_once 'DAL/conf.class.php';
$db = Db::getInstance();
        
        
			//$db->query("SET NAMES 'utf8'");
            $consulta = $db->query("select idUser from users ");
            $lista = array();
            while ($r = $db->fetch_array($consulta)) {
                $db->query("insert into servicioporusuario(idServicio,idUser) values('1','$r[idUser]')");
            }
            
        
        return $lista;
?>