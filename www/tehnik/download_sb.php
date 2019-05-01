<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include_once "../function.php";

$kl=$_GET['kl'];

if($kl=='eks_pb'){$im_file="/home/shablonu/eks_pb.xls"; $fl="eks_pb.xls";}
if($kl=='eks_vb'){$im_file="/home/shablonu/eks_vb.xls"; $fl="eks_vb.xls";}
if($kl=='eks_gb'){$im_file="/home/shablonu/eks_gb.xls"; $fl="eks_gb.xls";}
if($kl=='eks_sv'){$im_file="/home/shablonu/eks_sv.xls"; $fl="eks_sv.xls";}
if($kl=='eks_kb'){$im_file="/home/shablonu/eks_kb.xls"; $fl="eks_kb.xls";}
if($kl=='har'){$im_file="/home/shablonu/har.xls";}

$download_size = filesize($im_file);
//header("Content-type: application/msword");
header("Content-type: application/msexcel");
header("Content-Disposition: attachment; filename=".$fl.";");
header("Accept-Ranges: bytes");
header("Content-Length: " . $download_size );
readfile($im_file);
?>