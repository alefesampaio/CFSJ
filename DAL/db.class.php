<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DB2
 *
 * @author David
 */
 
/* Clase encargada de gestionar las conexiones a la base de datos */ 
class Db{
private $servidor; 

   private $usuario; 
   private $password; 
   private $base_datos; 
   private $link; 
   private $stmt; 
   private $array; 
  
   private $recent_link = null;

   private $sql = '';   
   private $query_count = 0;
   private $error = '';
   private $errno = '';
   private $is_locked = false;
   private $show_errors = false;
 
   static $_instance; 
 
   /*La función construct es privada para evitar que el objeto pueda ser creado mediante new*/ 
   private function __construct(){ 
      $this->setConexion(); 
      $this->conectar(); 
   } 
 
   /*Método para establecer los parámetros de la conexión*/ 
   private function setConexion(){ 
      $conf = Conf::getInstance(); 
      $this->servidor=$conf->getHostDB(); 
      $this->base_datos=$conf->getDB(); 
      $this->usuario=$conf->getUserDB(); 
      $this->password=$conf->getPassDB(); 
   } 
 
   /*Evitamos el clonaje del objeto. Patrón Singleton*/ 
   private function __clone(){ } 
 
   /*Función encargada de crear, si es necesario, el objeto. Esta es la función que debemos llamar desde fuera de la clase para instanciar el objeto, y así, poder utilizar sus métodos*/ 
   public static function getInstance(){ 
      if (!(self::$_instance instanceof self)){ 
         self::$_instance=new self(); 
      } 
         return self::$_instance; 
   } 
 
   /*Realiza la conexión a la base de datos.*/ 
   private function conectar(){ 
      $this->link=mysql_connect($this->servidor, $this->usuario, $this->password); 
      mysql_select_db($this->base_datos,$this->link); 
      @mysql_query("SET NAMES 'utf8'"); 
      @mysql_query("SET CHARACTER_SET 'utf8'"); 
   } 
 
 
   public function query($sql, $only_first = false)
	{
		$this->recent_link =& $this->link;
		$this->sql =& $sql;
		$result = @mysql_query($sql, $this->link);

		$this->query_count++;

		if ($only_first)
		{
			$return = $this->fetch_array($result);
			$this->free_result($result);
			return $return;
		}
		return $result;
	}
   public function fetch_array($result)
	{
		return @mysql_fetch_assoc($result);
	}
   public function fetch_object($result)
	{	
		return @mysql_fetch_object($result);
	}
	
   public function fetch_row($result)
	{
		return @mysql_fetch_row($result);
	}
	
   public function rows()
	{
		$numr = mysql_query("SELECT FOUND_ROWS()");
		$result = mysql_fetch_row($numr);
		return $result[0];
	}
   public function rows_count($quer)
	{ 
        $total = mysql_query($quer); 
        $total = mysql_fetch_array($total); 
        return $total[0]; 
	} 

	/**
	* Returns the number of rows in a result set.
	*
	* @param  string  The query result we are dealing with.
	* @return integer
	*/
    public function num_rows($result)
	{
		return @mysql_num_rows($result);
	}
	
    public function all_rows($qry) {
		$result = array();
		while ($d = $this->fetch_array($qry)) {
			$result[] = $d;
		}
		return $result;
	}

	/**
	* Retuns the number of rows affected by the most recent query
	*
	* @return integer
	*/
	public function affected_rows()
	{
		return @mysql_affected_rows($this->recent_link);
	}

	/**
	* Returns the number of queries executed.
	*
	* @param  none
	* @return integer
	*/
	public function num_queries()
	{
		return $this->query_count;
	}

	/**
	* Lock database tables
	*
	* @param   array  Array of table => lock type
	* @return  void
	*/
	public function lock($tables)
	{
		if (is_array($tables) AND count($tables))
		{
			$sql = '';

			foreach ($tables AS $name => $type)
			{
				$sql .= (!empty($sql) ? ', ' : '') . "$name $type";
			}

			$this->query("LOCK TABLES $sql");
			$this->is_locked = true;
		}
	}

	/**
	* Unlock tables
	*/
	public function unlock()
	{
		if ($this->is_locked)
		{
			$this->query("UNLOCK TABLES");
			$this->is_locked = false; 
		}
	}

	/**
	* //Devuelve el último id del insert introducido 
	*
	* @return  integer
	*/
	public function insert_id()
	{
		return @mysql_insert_id($this->link);
	}

	/**
	* Escapes a value to make it safe for using in queries.
	*
	* @param  string  Value to be escaped
	* @param  bool    Do we need to escape this string for a LIKE statement?
	* @return string
	*/
	public function prepare($value, $do_like = false)
	{
		$value = stripslashes($value);

		if ($do_like)
		{
			$value = str_replace(array('%', '_'), array('\%', '\_'), $value);
		}

		if (function_exists('mysql_real_escape_string'))
		{
			return mysql_real_escape_string($value, $this->link);
		}
		else
		{
			return mysql_escape_string($value);
		}
	}

	/**
	* Frees memory associated with a query result.
	*
	* @param  string   The query result we are dealing with.
	* @return boolean
	*/
	public function free_result($result)
	{
		return @mysql_free_result($result);
	}

	/**
	* Turns database error reporting on
	*/
	public function show_errors()
	{
		$this->show_errors = true;
	}

	/**
	* Turns database error reporting off
	*/
	public function hide_errors()
	{
		$this->show_errors = false;
	}

	/**
	* Closes our connection to MySQL.
	*
	* @param  none
	* @return boolean
	*/
	public function close()
	{
		$this->sql = '';
		return @mysql_close($this->link);
	}

	/**
	* Returns the MySQL error message.
	*
	* @param  none
	* @return string
	*/
	public function error()
	{
		$this->error = (is_null($this->recent_link)) ? '' : mysql_error($this->recent_link);
		return $this->error;
	}

	/**
	* Returns the MySQL error number.
	*
	* @param  none
	* @return string
	*/
	public function errno()
	{
		$this->errno = (is_null($this->recent_link)) ? 0 : mysql_errno($this->recent_link);
		return $this->errno;
	}

	/**
	* Gets the url/path of where we are when a MySQL error occurs.
	*
	* @access private
	* @param  none
	* @return string
	*/
	public function _get_error_path()
	{
		if ($_SERVER['REQUEST_URI'])
		{
			$errorpath = $_SERVER['REQUEST_URI'];
		}
		else
		{
			if ($_SERVER['PATH_INFO'])
			{
				$errorpath = $_SERVER['PATH_INFO'];
			}
			else
			{
				$errorpath = $_SERVER['PHP_SELF'];
			}

			if ($_SERVER['QUERY_STRING'])
			{
				$errorpath .= '?' . $_SERVER['QUERY_STRING'];
			}
		}

		if (($pos = strpos($errorpath, '?')) !== false)
		{
			$errorpath = urldecode(substr($errorpath, 0, $pos)) . substr($errorpath, $pos);
		}
		else
		{
			$errorpath = urldecode($errorpath);
		}
		return $_SERVER['HTTP_HOST'] . $errorpath;
	}

	/**
	* If there is a database error, the script will be stopped and an error message displayed.
	*
	* @param  string  The error message. If empty, one will be built with $this->sql.
	* @return string
	*/
	public function raise_error($error_message = '')
	{
		if ($this->recent_link)
		{
			$this->error = $this->error($this->recent_link);
			$this->errno = $this->errno($this->recent_link);
		}

		if ($error_message == '')
		{
			$this->sql = "Error in SQL query:\n\n" . rtrim($this->sql) . ';';
			$error_message =& $this->sql;
		}
		else
		{
			$error_message = $error_message . ($this->sql != '' ? "\n\nSQL:" . rtrim($this->sql) . ';' : '');
		}

		$message = "<textarea rows=\"10\" cols=\"80\">MySQL Error:\n\n\n$error_message\n\nError: {$this->error}\nError #: {$this->errno}\nFilename: " . $this->_get_error_path() . "\n</textarea>";

		if (!$this->show_errors)
		{
			$message = "<!--\n\n$message\n\n-->";
		}
		die("Parece que hay un pequeño inconveniente con nuestra base de datos, por favor intenta nuevamente en unos minutos.<br /><br />\n$message");
	}
}

?>
