﻿-->
<?php
session_start();

$xmlFile = '';
if(isset($_SESSION['userEmail']) && isset($_SESSION['userName']) && isset($_SESSION['userRole']))
{
	if($_SESSION['userRole']=='admin')
		$xmlFile = 'adminMenu.xml';
	else
		$xmlFile = 'surferMenu.xml';
}
else
	$xmlFile="guestMenu.xml";

$dom = new DomDocument();
$dom->load($xmlFile);
$menuItems=$dom->getElementsByTagName("menuItem");
echo '<div id="verticalMenu">';
	
foreach($menuItems as $menuItem) 
{
	if($menuItem->getAttribute("link")=="#")
	{
		echo '<div onmouseover="showItem(\''.$menuItem->getAttribute("name").'_\');" onmouseout="hideItem(\''.$menuItem->getAttribute("name").'_\');"><a href="#" class="arrowSmall">'.$menuItem->getAttribute("name").'</a><div class="verticalSubMenu" id="'.$menuItem->getAttribute("name").'_">';
		$items=$menuItem->getElementsByTagName("item");   		
		foreach($items as $item) 
		{
			if($item->getAttribute("link")=="#")
			{
				echo '<div onmouseover="showItem(\''.$item->getAttribute("name").'_\');" onmouseout="hideItem(\''.$item->getAttribute("name").'_\');"><a href="#" class="arrowSmall">'.$item->getAttribute("name").'</a><div class="verticalSubMenu" id="'.$item->getAttribute("name").'_">';
				$items2=$item->getElementsByTagName("item2");   		
				foreach($items2 as $item2) 
				{
					if(substr($item2->getAttribute("link"), 0,8)=="contents")
					{				
						echo '<a href="#" onclick="loadBoxContent(\''.$item2->getAttribute("link").'\','.$item2->getAttribute("width").','.$item2->getAttribute("height").',\'\')">'.$item2->getAttribute("name").'</a>';
					}
					else
					{
						echo '<a href="#" onclick="'.$item2->getAttribute("link").'">'.$item2->getAttribute("name").'</a>';
					}
				}			
				echo '</div></div>';
			}
			else if(substr($item->getAttribute("link"), 0,8)=="contents")
			{				
				echo '<div><a href="#" onclick="loadBoxContent(\''.$item->getAttribute("link").'\','.$item->getAttribute("width").','.$item->getAttribute("height").',\'\')">'.$item->getAttribute("name").'</a></div>';
			}
			else
			{
				echo '<div><a href="#" onclick="'.$item->getAttribute("link").'">'.$item->getAttribute("name").'</a></div>';
			}
		}			
		echo '</div></div>';
	}
	else if (substr($menuItem->getAttribute("link"), 0,8)=="contents")
	{
		echo '<div><a href="#" onclick="loadBoxContent(\''.$menuItem->getAttribute("link").'\','.$menuItem->getAttribute("width").','.$menuItem->getAttribute("height").',\'\')">'.$menuItem->getAttribute("name").'</a></div>';
	}
	else
	{
		echo '<div><a href="#" onclick="'.$menuItem->getAttribute("link").'">'.$menuItem->getAttribute("name").'</a></div>';
	}	
}	

echo '</div>';
?>