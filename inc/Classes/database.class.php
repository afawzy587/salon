<?php


class DB
{

	/**
	* str content database server
	* @private	str
	*/
    private $_dbhost;
	/**
	* str content database username
	* @private	str
	*/
    private $_dblogin;
	/**
	* str content database password
	* @private	str
	*/
    private $_dbpass;
	/**
	* str content database name
	* @private	str
	*/
    private $_dbname;
	/**
	* str content database connection link
	* @private	bol
	*/
    private $_dblink;
	/**
	* str content database query
	* @private	bol
	*/
    private $_queryid;
	/**
	* array content list of error's
	* @public	array
	*/
    public  $_error = array();
	/**
	* array content result of fetch sql query
	* @public	array
	*/
    public  $_record = array();
	/**
	* int content mysql num rows
	* @public	int
	*/
    public  $_totalrecords;
	/**
	* int content last insert id
	* @public	int
	*/
    public  $_last_insert_id;



	/**
	* Constructor
	* @param	str  	database username
	* @param	str  	database password
	* @param	str  	database name
	* @param	str  	database server
	* @return	void
	*/
 	public function __construct ($dblogin, $dbpass, $dbname, $dbhost)
 	{
	     $this->_dbhost 		= $dbhost;
	     $this->_dblogin 		= $dblogin;
	     $this->_dbpass 		= $dbpass;
	     $this->_dbname 		= $dbname;
	     $this->_dblink 		= NULL;
	     $this->_queryid 		= NULL;
	     $this->_error 			= array();
	     $this->_record 		= array();
	     $this->_totalrecords 	= 0;
	     $this->_last_insert_id = 0;
 	}


	/**
	* Make database connection
	* @return	boll
	*/
    public function connection()
    {

		# if all required data not null
    	if(!is_null($this->_dbhost) OR !is_null($this->_dblogin) OR !is_null($this->_dbpass) OR !is_null($this->_dbname))
    	{

			# make  connection
            $this->_dblink = mysqli_connect($this->_dbhost, $this->_dblogin, $this->_dbpass);

	        if (!$this->_dblink)
	        {
	        	# mysql can't make  connection
	            $this->return_error(mysqli_error());
	            return(FALSE);
	        }
	        else
	        {

				#select database to make connection
               $t = mysqli_select_db($this->_dblink,$this->_dbname);

		        if (!$t)
		        {
		        	#mysql can't select database
		            $this->return_error(mysqli_error());
		            return(FALSE);
		        }
		        else
		        {
          			$this->query("SET NAMES utf8");
					$this->query('SET character_set_results=utf8');
					$this->query('SET character_set_results=utf8');
					# successfully connection
		        	return(TRUE);

		        }
	        }
    	}
    	else
    	{

			# same of required data is null
    		return(FALSE);
    	}


    }



	/**
	* disconnect database connection
	* @return	boll
	*/
    public function disconnect()
    {

        #close connection
        $close = mysqli_close($this->_dblink);

        if (!$close)
        {
            $this->return_error(mysqli_error());
			#can't close connection
            return(FALSE);
        }
        else
        {

			unset($this->_dblink);

			#successfully disconnect
			return(TRUE);

        }

    }


	/**
	* set new error
	* @param	str  	error message
	* @return	error's array
	*/
    private function return_error($message)
    {

        return $this->_error[] = $message;

    }


	/**
	* FetchErrors
	* @return	error's array in success
	*/
    public function FetchErrors()
    {
    	# if isset error's
        if ($this->hasErrors())
        {
            reset($this->_error);

         	return($this->_error);

			# reset error array
            $this->resetErrors();
        }
        else
        {

			# no error's
        	return(FALSE);

        }

    }


	/**
	* Check if error's found
	* @return	boll
	*/
    public function hasErrors()
    {
        if (count($this->_error) > 0)
        {
            # we have error's
            return TRUE;
        }
        else
        {

    		# no error's
            return FALSE;
        }

    }



	/**
	* reset Error array
	* @return	boll
	*/
    public function resetErrors()
    {
        # if error's found
        if ($this->hasErrors())
        {
            unset($this->_error);
            $this->_error = array();

            return(TRUE);
        }
        else
        {

			# no error's found
        	return(FALSE);

        }

    }


	/**
	* Send a Mysql Query
	* @param	str  	mysql query
	* @return	query id in success
	*/
    public function query($sql)
    {
		# if NUll param
		if(!is_null($sql))
		{
			# if no connection
	        if (empty($this->_dblink))
	        {
	           # make database connection
	           $makecon = $this->connection();

	           if(!$makecon)
	           {

					# can't make database connection
	           		return(FALSE);

	           }

	        }
	        $this->_queryid = mysqli_query($this->_dblink,$sql);
	        # error in query
			echo mysqli_error($this->_dblink);
	        if (!$this->_queryid)
	        {
	            
	            $this->return_error(mysqli_error()."\n");
	        }
	        else
	        {

				#query Implemented
		        return $this->_queryid;

	        }

		}
		else
		{
			#  NUll param
			return(FALSE);
		}

    }



	/**
	* fetch a result row in array
	* @return	array  in success
	*/
    public function fetchRow()
    {

    	# if isset query
        if (isset($this->_queryid))
        {
            return $this->_record = mysqli_fetch_array($this->_queryid);
        }
        else
        {
        	# can't find query to fetch
            $this->return_error('ÇáÇÓÊÚáÇã ÛíÑ ãÊæÝÑ');
            return(FALSE);
        }

    }


	/**
	* get Last Insert Id
	* @return	int
	*/

    public function fetchLastInsertId()
    {

		# if isset connection
    	if(isset($this->_dblink))
    	{

			# get last insert id
	        $this->_last_insert_id = mysqli_insert_id($this->_dblink);

	        if (!$this->_last_insert_id)
	        {
	            $this->return_error('ÛíÑ ÞÇÏÑ Úáí ÌáÈ ÇáÇí Ïí');
	        }
	        else
	        {
	        	return $this->_last_insert_id;
	        }

    	}
    	else
    	# no connection found
    	{
    		return(FALSE);
    	}

    }


	/**
	* get number of rows in result
	* @return	int
	*/
    public function resultCount()
    {

		# if isset query
        if (isset($this->_queryid))
        {

	        $this->_totalrecords = mysqli_num_rows($this->_queryid);

	        return $this->_totalrecords;

        }
        else
        {
        	#no query
            $this->return_error('ÇáÇÓÊÚáÇã ÛíÑ ãÊæÝÑ');
            return(FALSE);
        }

    }


	/**
	* Check if result found
	* @return	boll
	*/
    public function resultExist()
    {
        if (isset($this->_queryid) && ($this->resultCount() > 0))
        {
            return TRUE;
        }
        else
        {
			return FALSE;
        }
    }
    
    
    



	/**
	* free esult memory
	* @return	boll
	*/
    public function clear($result = 0)
    {
        if ($result != 0)
        {
            $t = mysqli_free_result($result);

            if (!$t)
            {
                $this->return_error('ÛíÑ ÞÇÏÑ Úáí ÊÝÑíÛ ÇáÐÇßÑÉ');
                return(FALSE);
            }
            else
            {
            	return(TRUE);
            }

        }
        else
        {
            if (isset($this->_queryid))
            {
                $t = mysqli_free_result($this->_queryid);

                if (!$t)
                {
                    $this->return_error('ÛíÑ ÞÇÏÑ Úáí ÊÝÑíÛ ÇáÐÇßÑÉ');
                    return(FALSE);
                }
                else
                {

					return(TRUE);

                }

            }
            else
            {
                $this->return_error('áã ÊÞã ÈÇÎÊíÇÑ ÇÓÊÚáÇã áíÊã ÊÝÑíÛå');

                return(FALSE);
            }

        }

    }

	public function fixFldName($array)
	{
		if(is_array($array))
		{
			$new = array();
			foreach($array as $k => $v)
			{
				$new['`'.$k.'`'] = $v;
			}

			return($new);
		}
		else
		{
			return(false);
		}
	}

	/**
	* INSERT statment
	* @param	str  	table name
	* @param	array
	* @return	boll
	*/
	public function insert($info,$data ,$fix = false)
	{

		if(is_array($data) AND !is_null($data))
		{

			if($fix == true)
			{
				$data = $this->fixFldName($data);
			}

			$fld_names = implode(',', array_keys($data)).',';
			$fld_values = '\''.implode('\',\'', array_values($data)).'\',';

			$sql = 'INSERT INTO '.$info.'('.substr_replace($fld_names, '',-1,1).') VALUES('.substr_replace($fld_values, '',-1,1).')';

			$this->query($sql);

			return(TRUE);
		}
		else
		{

			return(FALSE);

		}
	}


	/**
	* UPDATE statment
	* @param	array  	table info
	* @param	array
	* @return	boll
	*/
	public function update($info,$data)
	{

        if(is_array($info) AND is_array($data))
        {
			$sql_set = '';

			foreach($data as $k=>$v)
					 	$sql_set .= ',`'.$k.'`=\''.addslashes($v).'\'';

			$query = 'UPDATE `'.$info[table].'` SET '.substr($sql_set,1).' WHERE `'.$info[row].'` =\''.$info[id].'\'';



			$this->query($query);

			return(TRUE);

		}
		else
		{

			return(FALSE);

		}
	}
    
    


	public function fetchlist()
	{
		while($this->fetchrow())
		{
			$list[] = $this->_record;
		}
		return($list);
	}


	public function fetchitem()
	{
		while($this->fetchrow())
		{
			$list[] = $this->_record;
		}

		if(is_array($list))
		{
			foreach($list as $k => $v)
			{
				$data = $v;
			}

        	return($data);
		}
		else
		{
			return(false);
		}
	}

	public function queryfirst($query)
	{
		$q = $this->query($query);
		$data = $this->fetchitem();
		if($data)
		{
			return($data);
		}
		else
		{
			return(false);
		}
	}
    
    
    

	public function __destruct ()
	{
	     $this->_dbhost 		= NULL;
	     $this->_dblogin 		= NULL;
	     $this->_dbpass 		= NULL;
	     $this->_dbname 		= NULL;
	     $this->_dblink 		= NULL;
	     $this->_queryid 		= NULL;
	     $this->_error 			= NULL;
	     $this->_record 		= NULL;
	     $this->_totalrecords 	= NULL;
	     $this->_last_insert_id = NULL;
 	}
    
    
    





}



?>
