<?php if(!defined("inside")) exit;

class logs
{
	var $tableLogTypeName 	= "log_type";
	var $tableLogParamsName = "log_params";
	var $tableName 			= "logs";

	public function addLog ($typeId, $logData, $who, $id, $update = 0)
	{
		$typeId = intval($typeId);
		if($typeId == 0)
		{
			//$this->terminate('error','missing type id in log',50);
		}else
		{
			$_logQuery 				= $GLOBALS['db']->query("SELECT * FROM `".$this->tableLogTypeName."` WHERE `id` = '".$typeId."' LIMIT 1 ");//$queryLimit
			$_logQueryCount 	= $GLOBALS['db']->resultcount();
			if($_logQueryCount == 1)
			{
				$_logData 		= $GLOBALS['db']->fetchitem($_logQuery);

				$logParams = unserialize($_logData['params']);

				if(!is_array($logData))
				{
					//$this->terminate('error','missing log data in log',50);
				}else
				{
					if( sizeof($logData) != sizeof($logParams) )
					{
						if($update == 1)
						{
							//echo "updating log keys: \n";
							//print_r(array_keys($logData));

							$GLOBALS['db']->query("UPDATE `".$this->tableLogTypeName."` SET `params`='".serialize(array_keys($logData))."' WHERE `id` = '".$typeId."' LIMIT 1");
							return 1;
						}else
						{
							//$this->terminate('error','wrong count( log data : ('.sizeof($logParams).' , '.sizeof($logData).') )  in log',50);
						}
					}else
					{
						foreach($_GET as $pName => $pData)
						{
							$data .= "[ G_".sanitize($pName)." => ".sanitize($pData)."] , ";
						}
						foreach($_POST as $pName => $pData)
						{

							$data .= "[ P_".sanitize($pName)." => ".sanitize($pData)."] , ";
						}

						if($who == "")
						{
							//$this->terminate('error','missing who in log',50);
						}else
						{
							$userId = intval($id);
							if($userId == 0)
							{
								//$this->terminate('error','missing user_id in log',50);
							}else
							{
								$GLOBALS['db']->query("UPDATE `".$this->tableLogTypeName."` SET `params`='".serialize(array_keys($logData))."' WHERE `id` = '".$typeId."' LIMIT 1");

								$GLOBALS['db']->query( "INSERT INTO `".$this->tableName."` (`id` , `type` ,`who` ,`user_id` ,`time` , `message`, `data`, `periority`) VALUES (NULL , '".$typeId."' , '".$who."' , '".$userId."' , NOW() , '', '".$data."', '1' ) " );

								$logId = $GLOBALS['db']->fetchLastInsertId();

								$message = ucfirst($who)." #".$userId."opened ";

								foreach($logParams as $paramId => $param)
								{
									$GLOBALS['db']->query( "INSERT INTO `".$this->tableLogParamsName."` (`id` , `log_id` ,`position` , `value`) VALUES (NULL , '".$logId."' , '".$param."' , '".$logData[$param]."' ) " );
									$message .= "[ ".$param." => ".$logData[$param]."] , ";
								}
								$GLOBALS['db']->query("UPDATE `".$this->tableName."` SET `message`='".$message."' WHERE `id` = '".$logId."' AND `type` = '".$typeId."' LIMIT 1");
							}
						}
					}
				}
			}else
			{
				// insert new log id
				if(!is_array($logData))
				{
					//$this->terminate('error','missing log data in log',50);
				}else
				{
					if($who == "")
					{
						//$this->terminate('error','missing who in log',50);
					}else
					{
						$userId = intval($id);
						if($userId == 0)
						{
							//$this->terminate('error','missing user_id in log',50);
						}else
						{
							//echo "adding new log keys:\n";
							//print_r($logData);

							$params = array_keys ($logData);
							//print_r($params);


							$GLOBALS['db']->query( "INSERT INTO `".$this->tableLogTypeName."` (`id` , `type` ,`module` ,`mode` ,`params`) VALUES
							('".$typeId."' , '".$who."' , '".$logData['module']."' , '".$logData['mode']."' , '".serialize($params)."' ) " );
							$this->addLog($typeId, $logData, $who, $id, $update);
							//exit;
						}
					}
				}
				//$this->terminate('error','wrong log id',50);
			}
		}
	}
	function getsitelogs($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `logs` ORDER BY `id` DESC ".$addon);
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getTotallogs()
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `logs` ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
	function getlogsInformation($mId)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `id` = '".$mId."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{

				$siteCategory = $GLOBALS['db']->fetchitem($query);

				return array(
					"id"			=> 		$siteCategory['id'],
					"type"			=> 		$siteCategory['type'],
					"who"			=> 		$siteCategory['who'],
					"user_id"	    => 		$siteCategory['user_id'],
					"time"		    => 		$siteCategory['time'],
					"message"	    => 		$siteCategory['message'],
					"data"		    => 		$siteCategory['data'],
					"periority"  	=> 		$siteCategory['periority']

				);


			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}



}
?>
