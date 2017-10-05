<?php

function getMonthlyList()
{
	$url = 'http://www.gein.noa.gr/services/monthly-list.html';
	if ($fp = fopen($url, 'r'))
	{
		$content = '';
		while ($line = fread($fp, 1024)) 
		{
			$content .= $line;
		}
		// remove everything before tag <pre>
		$myvardelete = substr($content, 0, (stripos($content, "<pre>")+5));
		$content = str_replace($myvardelete, '', $content);
		
		// remove the first 2 rows
		$myvardelete = substr($content, 0, (stripos($content, "Local")+5));
		$content = str_replace($myvardelete, '', $content);
		
		// remove everything after tag <u>
		$content = substr($content, 0, (stripos($content, "<u>")-3) );
		$content = trim($content);
		
		$arrayContent = preg_split('/\n/', $content);
		return $arrayContent;
	}
	else
	{
		return 'error';
	}
}

?>