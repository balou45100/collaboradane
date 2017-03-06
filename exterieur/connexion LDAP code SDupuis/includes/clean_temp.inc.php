<?php
	$dir = opendir($temp_dir.'/');
	while ($file = readdir($dir))
	{
   	if(is_file($temp_dir.'/'.$file)) 
   	{      
	      $temp = file($temp_dir.'/'.$file);
	      list($key, $value) = split('[=]', $temp[1]);
	      $expire = substr($value,1,-1);
	      if (time() > $expire)
	      {
	      	unlink($temp_dir.'/'.$file);
	      }
		}
   }
?>