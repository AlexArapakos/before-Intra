<?php		
	function showError($errorArray,$tag)
	{
		for($row=0;$row<count($errorArray);$row++)
		{
			if($errorArray[$row]['item']==$tag)
				return '<div class="err">'.$errorArray[$row]['error'].'</div>';
		}
		return "";
	}		
?>