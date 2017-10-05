<?php

function formatDatetime($current_date)
{
	settype($current_date, 'string');
	for ($b=0; $b<20; ++$b)
	{
		$current_date = str_replace("  ", " ", $current_date);
	}
	$list = preg_split('/\s/', $current_date);
	for ($a=0; $a<sizeof($list); ++$a) { $list[$a]=trim($list[$a]); }
	
	if ($list[1]=='JAN') { $list[1]='01'; }
	else if ($list[1]=='FEB') { $list[1]='02'; }
	else if ($list[1]=='MAR') { $list[1]='03'; }
	else if ($list[1]=='APR') { $list[1]='04'; }
	else if ($list[1]=='MAY') { $list[1]='05'; }
	else if ($list[1]=='JUN') { $list[1]='06'; }
	else if ($list[1]=='JUL') { $list[1]='07'; }
	else if ($list[1]=='AUG') { $list[1]='08'; }
	else if ($list[1]=='SEP') { $list[1]='09'; }
	else if ($list[1]=='OCT') { $list[1]='10'; }
	else if ($list[1]=='NOV') { $list[1]='11'; }
	else if ($list[1]=='DEC') { $list[1]='12'; }
	
	$lastDigit = substr($list[5], -1);
	$list[5]=substr($list[5], 0, -2);
	if ($lastDigit=='5' || $lastDigit=='6' || $lastDigit=='7' || $lastDigit=='8' || $lastDigit=='9')
	{
		$list[5]=intval($list[5]);
		$list[5]++;
		if($list[5]=='60')
		{
			$list[5]='00';
			$list[4]=intval($list[4]);
			$list[4]++;
			if($list[4]=='60')
			{
				$list[4]='00';
				$list[3]=intval($list[3]);
				$list[3]++;
				if($list[3]=='24')
				{
					$list[3]='00';
					$list[2]=intval($list[2]);
					$list[2]++;
					if(($list[1]=='02') && ($list[2]=='30'))
					{
						$list[2]='1';
						$list[1]='3';
					}
					else if(($list[1]=='02') && ($list[2]=='29') && ((($list[0]%4)!=0) || ((($list[0]%100)==0) && (($list[0]%400)!=0))))
					{
						$list[2]='1';
						$list[1]='3';
					}
					else if((($list[1]=='04') || ($list[1]=='06') || ($list[1]=='09') || ($list[1]=='11')) && ($list[2]=='31'))
					{
						$list[2]='1';
						$list[1]=intval($list[1]);
						$list[1]++;
					}
					else if($list[2]=='32')
					{
						$list[2]='1';
						$list[1]=intval($list[1]);
						$list[1]++;
						if($list[1]=='13')
						{
							$list[1]='01';
							$list[0]=intval($list[0]);
							$list[0]++;
						}
					}
				}
			}
		}
	}
	
	$mk=mktime($list[3], $list[4], $list[5], $list[1], $list[2], $list[0]);
	return strftime('%Y-%m-%d %H:%M:%S',$mk);
}

?>