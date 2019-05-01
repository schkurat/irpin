<?php
function german_date($oldat)
{ 
   if($oldat=="") $vdat="-";
   else { 
   $oldat1=explode('-',$oldat);
	if($oldat1[1]>0)
	{
		$mdt=mktime(0,0,0,$oldat1[1],$oldat1[2],$oldat1[0]);	  
		$vdat=date("d.m.Y",$mdt);
	}
	else 
	$vdat="-";
	}
   return $vdat;
}
?>