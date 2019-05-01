<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$kl=$_GET['kl']; 

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
   
include "../function.php";
require('../tfpdf/tfpdf.php');
 // створюємо FPDF обєкт
$pdf = new TFPDF();

$pdf->SetAutoPageBreak('true',2);
$pdf->SetMargins(05,05,2);
$pdf-> AddFont('dejavu','','DejaVuSans.ttf',true); 
$pdf-> AddFont('dejavub','','DejaVuSans-Bold.ttf',true);

// Вказуємо автора та заголовок
$pdf->SetAuthor('Шкурат А.О.');
$pdf->SetTitle('Замовлення');

// задаємо шрифт та його колiр
$pdf-> SetFont('dejavu','',10);
$pdf->SetTextColor(50, 60, 100);
 
//створюємо нову сторiнку та вказуємо режим її вiдображення
$pdf->AddPage('P');
$pdf->SetDisplayMode('real', 'default');

$pdf->SetXY(05, 05);
$pdf->SetDrawColor(50, 60, 100);

 $sql = "SELECT TIP FROM dlya_oformlennya, zamovlennya 
			WHERE '$kl'=zamovlennya.KEY AND zamovlennya.DL='1' AND zamovlennya.VUD_ROB!=19  
			AND zamovlennya.VUD_ROB=dlya_oformlennya.id_oform"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	$tup=$aut["TIP"]; 
 }
 mysql_free_result($atu); 
 
$k_vl=0;
$sql1="SELECT *,dlya_oformlennya.document,rayonu.RAYON,nas_punktu.NSP, tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL,zamovlennya.SZ,zamovlennya.NZ
				FROM zamovlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul, dlya_oformlennya
				WHERE 
					zamovlennya.KEY='$kl'
					AND zamovlennya.DL='1' AND zamovlennya.VUD_ROB!=19 
					AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB
					AND rayonu.ID_RAYONA=RN
					AND nas_punktu.ID_NSP=NS
					AND vulutsi.ID_VUL=VL
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					ORDER BY D_PR DESC";			
 $atu1=mysql_query($sql1);  
  while($aut1=mysql_fetch_array($atu1))
 {	$sz=$aut1["SZ"];
	$nz=$aut1["NZ"];
	$tip_zak=$aut1["TUP_ZAM"];
	$pr[$k_vl]=$aut1["PR"];
	$im[$k_vl]=$aut1["IM"];
    $pb[$k_vl]=$aut1["PB"]; 
	$dn[$k_vl]=german_date($aut1["D_NAR"]);
	$idn[$k_vl]=$aut1["IDN"]; 
	$d_vuh=german_date($aut1["DATA_VUH"]);
	$d_got=german_date($aut1["DATA_GOT"]);
	$rn=$aut1["RAYON"];
	$ns=$aut1["NSP"];
	$tns=$aut1["TIP_NSP"];
	$vl=$aut1["VUL"];
	$tvl=$aut1["TIP_VUL"];
	$bud=$aut1["BUD"];
	$kvar=$aut1["KVAR"];	
	$d_pr=german_date($aut1["D_PR"]);
	$v_rob=$aut1["document"];	
	$tel=$aut1["TEL"];	
	$meta=$aut1["META"];
	$pravo=$aut1["PRAVO"];
	$obj=$aut1["OBJ"];
	if($aut1["DOR"]!="") $dover=$aut1["DOR"];
	else $dover="-";
	$prop=$aut1["PROPISKA"];	
	$sm=$aut1["SUM"];	
	$kvut=$aut1["KVUT"];
	$pr_os=$aut1["PR_OS"];
	$k_vl=$k_vl+1;

$nn=substr_count($aut1["PRDOC"],":");
$ndoc=explode(":",$aut1["PRDOC"]);
if($aut1["BUD"]!="") $budd="буд. ".$aut1["BUD"]; else $budd="";
if($aut1["KVAR"]!="") $kvarr="кв. ".$aut1["KVAR"]; else $kvarr="";
 } 
 mysql_free_result($atu1); 
 if($tip_zak==2){$t_zm=" - термінове";}
 else {$t_zm="";}
 $sql2="SELECT PR, IM, PB, DN, IDN FROM zm_dod
			WHERE '$kl'=IDZM AND DL='1'"; 
 $atu2=mysql_query($sql2);  
  while($aut2=mysql_fetch_array($atu2))
 {
	$pr[$k_vl]=$aut2["PR"];
	$im[$k_vl]=$aut2["IM"];
    $pb[$k_vl]=$aut2["PB"];
	$dn[$k_vl]=german_date($aut2["DN"]);
	$idn[$k_vl]=$aut2["IDN"]; 	
	$k_vl=$k_vl+1;
 }
 mysql_free_result($atu2); 
 
$sql3="SELECT * FROM config"; 
 $atu3=mysql_query($sql3);  
  while($aut3=mysql_fetch_array($atu3))
 {
	$bti=$aut3["NAME"];
	$edrpou=$aut3["EDRPOU"];
    $adr_bti=$aut3["ADR"];
	$ipn=$aut3["IPN"];
	$sv=$aut3["SV"];
 }
 mysql_free_result($atu3); 
 
$sql4="SELECT * FROM rahunku WHERE ID_RAH=1"; 
 $atu4=mysql_query($sql4);  
  while($aut4=mysql_fetch_array($atu4))
 {
	$viddil=$aut4["VIDDIL"];
	$rah=$aut4["RAH"];
    $mfo=$aut4["MFO"];
 }
 mysql_free_result($atu4);  

if ($tup==3){	 
//-------------------Зичайна заява-------------------------
$pdf->Text(05,10,'Комунальне підприємство ');
$pdf->Text(05,15,'"Лубенське міжрайонне ');
$pdf->Text(05,20,'бюро технічної інвентаризації"');
$pdf-> SetFont('dejavub','',12);
$pdf->Text(65,10,'Від гр. ');
//----------------------vstavka-----------------------------
$pdf-> SetFont('dejavu','',10);
$z=0;
for($i=0; $i<$k_vl; $i++){
$pdf->Text(85,10+$z,$pr[$i].' '.$im[$i].' '.$pb[$i].' '.$dn[$i].' код '.$idn[$i]);
$z=$z+5;
}
$pdf->Text(30,30,$d_vuh);
$pdf->Text(30,40,$d_got);
$pdf->Text(80,45,$dover);
$pdf->Text(70,50,$rn.' '.$tns.' '.$ns.' '.$tvl.' '.$vl.' '.$budd.' '.$kvarr);
$pdf->Text(115,60,$sz.'*'.$nz.' '.$t_zm);
$pdf->Text(170,60,$d_pr);
$pdf->Text(60,75,$v_rob);
$pdf->Text(50,90,$tel);
$pdf->Text(50,100,$prop);
$pdf->Text(40,105,'Сплачено аванс');
$pdf->Text(75,105,$sm);
$pdf->Text(90,105,'грн.  по квитанції № '.$kvut);
$pdf->Text(90,115,'______________ '.$pr_os);
$pdf-> SetFont('dejavub','',12);
//------------------------------------------------------------------
$pdf->Text(50,45,'Доручення: ');
$pdf->Text(50,50,'Адреса: ');
$pdf-> SetFont('dejavub','',16);
$pdf->Text(58,60,'ЗАМОВЛЕННЯ № ');
$pdf-> SetFont('dejavub','',14);
$pdf->Text(160,60,'від ');
$pdf-> SetFont('dejavu','',12);
$pdf->Text(05,75,'Вид робіт ');
$pdf->Text(05,90,'Телефон ');
$pdf->Text(05,100,'Адреса: ');
$pdf-> SetFont('dejavu','',10);
$pdf->Text(05,125,'Вартість робіт зобов`язуюсь сплатити згідно пред`явленого рахунку _________________________ ');
$pdf-> SetFont('dejavu','',8);
$pdf->Text(145,128,'(підпис замовника)'); 
$pdf-> SetFont('dejavu','',10);
$pdf->Text(05,135,'Документи отримав(ла) ________________________ дата _____________'); 
//------------------------------------------------------------------------
}
if ($tup==1){
//-------------------Заява про державну реєстрацію--------------------------
$pdf->SetFont('dejavu','',10);
$pdf->Text(40,29,$d_got);
$z=0;
for($i=0; $i<$k_vl; $i++){
$pdf->Text(80,29+$z,$pr[$i].' '.$im[$i].' '.$pb[$i].' '.$dn[$i].' код '.$idn[$i]);
$z=$z+7;
}
$pdf->Text(80,76,$prop);
$pdf->SetFont('dejavub','',14);
$pdf->Text(130,90,$sz.'*'.$nz.' '.$t_zm);
$pdf->SetFont('dejavu','',10);
$pdf->Text(160,95,'від '.$d_pr);
switch($pravo){
case '1': $pdf->Text(120,104,'право власності');
break;
case '2': $pdf->Text(120,104,'інше речове право');
break;
}

switch($obj){
case '1': $pdf->Text(20,124,'Житловий будинок');
break;
case '2': $pdf->Text(20,124,'Квартира');
break;
case '3': $pdf->Text(20,124,'Садовий будинок');
break;
case '4': $pdf->Text(20,124,'Гараж');
break;
case '5': $pdf->Text(20,124,'Кімната');
break;
case '6': $pdf->Text(20,124,'Цілісний майновий комплекс');
break;
case '7': $pdf->Text(20,124,'Нежитлове приміщення');
break;
case '8': $pdf->Text(20,124,'Нежитлова будівля');
break;
}
$pdf->Text(50,141,$rn.' '.$tns.' '.$ns.' '.$tvl.' '.$vl.' '.$budd.' '.$kvarr);
$pdf->Text(50,151,$pr[0].' '.$im[0].' '.$pb[0]);
$pdf->Text(160,151,'тел. '.$tel);
$pdf->Text(10,185,'Доручення: '.$dover);
$pdf->Text(20,239,'Сума '.$sm.'        Квитанція № '.$kvut);
$pdf->Text(150,239,$pr[0].' '.p_buk($im[0]).'. '.p_buk($pb[0]).'.');
$pdf->Text(85,264,$pr_os);

$z2=0;
for($i=0; $i<=$nn; $i++){
$sql5 = "SELECT PRDOC FROM pravo_doc WHERE ID_PRDOC='$ndoc[$i]'";
$atu5=mysql_query($sql5);
  while($aut5=mysql_fetch_array($atu5))
 {$pdf->Text(80,192+$z2,$aut5["PRDOC"]);}
mysql_free_result($atu5);
$z2=$z2+7;
} 

$pdf-> SetFont('dejavu','',10);
$pdf->Text(120,8,'Додаток 1');
$pdf->Text(120,12,'до Тимчасового положення про порядок');
$pdf->Text(120,16,'державної реєстрації та інших речових прав');
$pdf->SetFont('dejavub','',14);
$pdf->Text(120,21,'КП "Лубенське МБТІ"');
$pdf->Line(120,22,193,22);
$pdf-> SetFont('dejavu','',12);
$pdf->Text(10,30,'Готовність');
$pdf->Line(35,30,65,30);
$pdf->Line(75,30,203,30);
$pdf->Line(75,37,203,37);
$pdf->Line(75,44,203,44);
$pdf->Line(75,51,203,51);
$pdf->Line(75,58,203,58);
$pdf->Line(75,65,203,65);
$pdf->Text(75,70,'що проживає за адресою:');
$pdf->Line(75,77,203,77);
$pdf->SetFont('dejavub','',18);
$pdf->Text(95,90,'ЗАЯВА');
$pdf->SetFont('dejavub','',14);
$pdf->Text(65,95,'про державну реєстрацію прав');
$pdf-> SetFont('dejavu','',12);
$pdf->Text(20,105,'Прошу провести державну реєстрацію ');
$pdf->Line(110,105,203,105);
$pdf->Line(10,112,203,112);
$pdf-> SetFont('dejavu','',8);
$pdf->Text(18,115,'(право власності (вид спільної власності, розмір часток (якщо майно належить на прві спільної часткової власності))');
$pdf->Text(90,118,'чи інше речове право)');
$pdf-> SetFont('dejavu','',12);
$pdf->Text(10,125,'на');
$pdf->Line(17,125,203,125);
$pdf-> SetFont('dejavu','',8);
$pdf->Text(60,128,'(об`єкт, права щодо якого підлягають державнії реєстрації)');
$pdf-> SetFont('dejavu','',12);
$pdf->Text(10,135,'що знаходиться');
$pdf->Line(10,142,203,142);
$pdf-> SetFont('dejavu','',8);
$pdf->Text(75,145,'(поштова чи будівельна адреса об`єкта)');
$pdf-> SetFont('dejavu','',12);
$pdf->Text(10,152,'і належить');
$pdf->Line(36,152,203,152);
$pdf-> SetFont('dejavu','',8);
$pdf->Text(72,155,'(П.І.Б. фізичної особи чи найменування юридичної особи)');
$pdf->Line(10,162,203,162);
$pdf->Text(60,165,'підстава виникнення права власності чи іншого речового права)');
$pdf->Line(10,172,203,172);
$pdf->Line(10,179,203,179);
$pdf->Line(10,186,203,186);
$pdf-> SetFont('dejavu','',12);
$pdf->Text(10,193,'До заяви додаються:');
$pdf->Line(59,193,203,193);
$pdf->Line(10,200,203,200);
$pdf->Line(10,207,203,207);
$pdf->Line(10,214,203,214);
$pdf->Line(10,221,203,221);
$pdf->Line(10,228,203,228);
$pdf-> SetFont('dejavu','',8);
$pdf->Text(90,231,'(перелік документів)');
$pdf->Line(10,240,95,240);
$pdf->SetFont('dejavub','',12);
$pdf->Text(110,240,'Заявник');
$pdf->Line(132,240,200,240);
$pdf-> SetFont('dejavu','',8);
$pdf->Text(160,243,'(підпис)');
$pdf-> SetFont('dejavu','',12);
$pdf->Text(10,253,'------------------------------------------------------------------------------------------------------------------------------');
$pdf->SetFont('dejavub','',12);
$pdf->Text(20,265,'Заяву прийняв');
$pdf->Line(58,265,140,265);
$pdf->Line(150,265,200,265);
$pdf-> SetFont('dejavu','',8);
$pdf->Text(80,268,'(П.І.Б. реєстратора БТІ)');
$pdf->Text(170,268,'(підпис)');
$pdf->SetFont('dejavu','',12);
$pdf->Text(10,275,'Порядковий номер заяви в журналі обліку заяв про державну реєстрацію прав');
$pdf->Line(10,285,75,285);
$pdf->Text(77,285,'від');
$pdf->Line(85,285,180,285);
$pdf->Text(182,285,'року.'); 
//--------------------rozpuska--------------------------
$pdf->AddPage('P');
$pdf->SetDisplayMode('real', 'default');
$pdf->SetXY(05, 05);
$pdf->SetDrawColor(50, 60, 100);
$pdf-> SetFont('dejavu','',14);
$pdf->Text(90,15,'РОЗПИСКА');
$pdf-> SetFont('dejavu','',10);
$pdf->Text(15,20,'Мною, '.$pr_os.' прийнято в гр-на(ки) '.$pr[0].' '.p_buk($im[0]).'. '.p_buk($pb[0]).' заяву про реєстрацію права власності на');
$pdf->Text(10,25,'нерухоме майно.');
$pdf->Text(10,30,'До заяви  додається:');

$z2=0;
for($i=0; $i<=$nn; $i++){
$sql6 = "SELECT PRDOC FROM pravo_doc WHERE ID_PRDOC='$ndoc[$i]'";
$atu6=mysql_query($sql6);
  while($aut6=mysql_fetch_array($atu6))
 {$pdf->Text(52,30+$z2,$aut6["PRDOC"]);}
mysql_free_result($atu6);
$z2=$z2+5;
} 

$pdf->Text(15,60,'Заяву зареєстровано в Реєстрі заяв та запитів за № '.$sz.'*'.$nz.' квитанція № '.$kvut);
$pdf->Text(10,65,'ПІБ особи, що прийняла заяву: '.$pr_os);
$pdf->Text(10,70,'Документи згідно переліком отримано:');
$pdf->Text(15,85,'_________________               '.$pr[0].' '.p_buk($im[0]).'. '.p_buk($pb[0]));
$pdf-> SetFont('dejavu','',8);
$pdf->Text(16,88,'(підпис заявника)');
//----------------------------------------------------------
//--------------------------------------------------------------------------------------------
}
if ($tup==2){
//-------------------Заява про витяг з реєстру-------------------------
$pdf->SetFont('dejavu','',10);
$pdf->Text(40,29,$d_got);
$z=0;
for($i=0; $i<$k_vl; $i++){
$pdf->Text(80,29+$z,$pr[$i].' '.$im[$i].' '.$pb[$i].' '.$dn[$i].' код '.$idn[$i]);
$z=$z+8;
}
$pdf->Text(80,82,$prop);
$pdf->Text(130,95,$sz.'*'.$nz.' '.$t_zm.' від '.$d_pr);
$pdf->Text(50,145,$rn.' '.$tns.' '.$ns.' '.$tvl.' '.$vl.' '.$budd.' '.$kvarr);
$pdf->Text(50,156,$pr[0].' '.$im[0].' '.$pb[0]);
$pdf->Text(160,156,'тел. '.$tel);
$pdf->Text(10,178,'Доручення: '.$dover);
$pdf->Text(50,186,'Сума     '.$sm.'          квитанція   '.$kvut);
$pdf->Text(50,211,$pr[0].' '.p_buk($im[0]).'. '.p_buk($pb[0]).'.');
$pdf->Text(85,245,$pr_os);

switch($meta){
case '1': $pdf->Text(20,106,'для дарування');
break;
case '2': $pdf->Text(20,106,'для відчудження');
break;
case '3': $pdf->Text(20,106,'для міни');
break;
case '4': $pdf->Text(20,106,'для іпотеки');
break;
case '5': $pdf->Text(20,106,'для спадщини');
break;
case '6': $pdf->Text(20,106,'для встановлення ідеальних часток');
break;
case '7': $pdf->Text(20,106,'для договору аренди');
break;
}

switch($obj){
case '1': $pdf->Text(20,129,'Житловий будинок');
break;
case '2': $pdf->Text(20,129,'Квартира');
break;
case '3': $pdf->Text(20,129,'Садовий будинок');
break;
case '4': $pdf->Text(20,129,'Гараж');
break;
case '5': $pdf->Text(20,129,'Кімната');
break;
case '6': $pdf->Text(20,129,'Цілісний майновий комплекс');
break;
case '7': $pdf->Text(20,129,'Нежитлове приміщення');
break;
case '8': $pdf->Text(20,129,'Нежитлова будівля');
break;
}

$pdf-> SetFont('dejavu','',10);
$pdf->Text(120,8,'Додаток 1');
$pdf->Text(120,12,'до Тимчасового положення про порядок');
$pdf->Text(120,16,'державної реєстрації та інших речових прав');
$pdf->SetFont('dejavub','',14);
$pdf->Text(120,21,'КП "Лубенське МБТІ"');
$pdf->Line(120,22,193,22);
$pdf-> SetFont('dejavu','',12);
$pdf->Text(10,30,'Готовність');
$pdf->Line(35,30,65,30);
$pdf->Line(75,30,203,30);
$pdf->Line(75,38,203,38);
$pdf->Line(75,46,203,46);
$pdf->Line(75,54,203,54);
$pdf->Line(75,62,203,62);
$pdf->Line(75,70,203,70);
$pdf->Text(75,75,'що проживає за адресою:');
$pdf->Line(75,83,203,83);
$pdf->SetFont('dejavub','',18);
$pdf->Text(95,95,'ЗАЯВА');
$pdf->SetFont('dejavub','',14);
$pdf->Text(16,102,'про надання витягу з реєстру прав власності на нерухоме майно');
$pdf-> SetFont('dejavu','',12);
$pdf->Text(20,112,'Відповідно до підпункту 7.1.1 пункту 7.1 Тимчасового положення про порядок');
$pdf->Text(10,117,'державної реєстрації права власності та інших речових прав прошу надати мені витяг');
$pdf->Text(10,122,'з Реєстру прав власності на нерухоме майно на');
$pdf->Line(10,130,203,130);
$pdf-> SetFont('dejavu','',8);
$pdf->Text(60,133,'(об`єкт, права щодо якого підлягають державнії реєстрації)');
$pdf-> SetFont('dejavu','',12);
$pdf->Text(10,138,'що знаходиться');
$pdf->Line(10,146,203,146);
$pdf-> SetFont('dejavu','',8);
$pdf->Text(75,149,'(поштова чи будівельна адреса об`єкта)');
$pdf-> SetFont('dejavu','',12);
$pdf->Text(10,157,'і належить');
$pdf->Line(36,157,203,157);
$pdf-> SetFont('dejavu','',8);
$pdf->Text(72,160,'(П.І.Б. фізичної особи чи найменування юридичної особи)');
$pdf->Line(10,168,203,168);
$pdf->Text(60,171,'(підстава виникнення права власності чи іншого речового права)');
$pdf->Line(10,179,203,179);
$pdf->Line(10,187,203,187);
$pdf-> SetFont('dejavu','',12);
$pdf->Text(18,194,'Реєстраційний номер об`єкта, права щодо якого підлягають державній реєстрації');
$pdf->Line(10,202,90,202);
$pdf->SetFont('dejavub','',12);
$pdf->Text(20,212,'Заявник');
$pdf->Line(42,212,120,212);
$pdf->Line(132,212,200,212);
$pdf-> SetFont('dejavu','',8);
$pdf->Text(160,215,'(підпис)');
$pdf-> SetFont('dejavu','',12);
$pdf->Text(10,230,'------------------------------------------------------------------------------------------------------------------------------');
$pdf->SetFont('dejavub','',12);
$pdf->Text(20,246,'Заяву прийняв');
$pdf->Line(58,246,140,246);
$pdf->Line(150,246,200,246);
$pdf-> SetFont('dejavu','',8);
$pdf->Text(80,249,'(П.І.Б. реєстратора БТІ)');
$pdf->Text(170,249,'(підпис)');
$pdf->SetFont('dejavu','',12);
$pdf->Text(10,257,'Порядковий номер заяви в журналі обліку заяв та запитів про надання інформації з');
$pdf->Text(10,265,'Реєстру прав власності на нерухоме майно');
$pdf->Line(110,265,180,265);
$pdf->Text(10,274,'від');
$pdf->Line(18,274,100,273);
$pdf->Text(102,274,'року.'); 
//----------------------------------------------------------------------------------
//--------------------rozpuska--------------------------
$pdf->AddPage('P');
$pdf->SetDisplayMode('real', 'default');
$pdf->SetXY(05, 05);
$pdf->SetDrawColor(50, 60, 100);
$pdf-> SetFont('dejavu','',14);
$pdf->Text(90,15,'РОЗПИСКА');
$pdf-> SetFont('dejavu','',10);
$pdf->Text(15,20,'Мною, '.$pr_os.' прийнято в гр-на(ки) '.$pr[0].' '.p_buk($im[0]).'. '.p_buk($pb[0]).' заяву про надання витягу з реєстру прав');
$pdf->Text(10,25,'власності на нерухоме майно.');
$pdf->Text(10,30,'До заяви  додається:');

$z2=0;
for($i=0; $i<=$nn; $i++){
$sql6 = "SELECT PRDOC FROM pravo_doc WHERE ID_PRDOC='$ndoc[$i]'";
$atu6=mysql_query($sql6);
  while($aut6=mysql_fetch_array($atu6))
 {$pdf->Text(52,30+$z2,$aut6["PRDOC"]);}
mysql_free_result($atu6);
$z2=$z2+5;
} 

$pdf->Text(15,60,'Заяву зареєстровано в Реєстрі заяв та запитів за № '.$sz.'*'.$nz.' квитанція № '.$kvut);
$pdf->Text(10,65,'ПІБ особи, що прийняла заяву: '.$pr_os);
$pdf->Text(10,70,'Документи згідно переліком отримано:');
$pdf->Text(15,85,'_________________               '.$pr[0].' '.p_buk($im[0]).'. '.p_buk($pb[0]));
$pdf-> SetFont('dejavu','',8);
$pdf->Text(16,88,'(підпис заявника)');
//----------------------------------------------------------
}
/* if ($tup==3 or $tup==1){$k=150;}
else {
$pdf->AddPage('P');
$pdf->SetDisplayMode('real', 'default');

$pdf->SetXY(05, 05);
$pdf->SetDrawColor(50, 60, 100);
$k=0;} */

if($sm!=0){
//-------------------------Квитанція-------------------------------------------
$k=150;
$grn=(int)$sm;
$kop=fract($sm);
$sm_pg=in_str($grn);

$pdf->SetFont('dejavu','',8);
$pdf->Text(82,15+$k,$bti.' ЄДРПОУ - '.$edrpou);
$pdf->Text(82,19+$k,'Р/р '.$rah.' в '.$viddil.', МФО '.$mfo);
$pdf->Text(82,23+$k,'ІПН '.$ipn.', свідоцтво № '.$sv);
$pdf->Text(82,27+$k,'Адреса: '.$adr_bti);
$pdf->Text(160,35+$k,$kvut.'             АВАНС');
$pdf->Text(120,40+$k,date('d.m.Y').'р.');
$pdf->Text(90,45+$k,'Гром. '.$pr[0].' '.p_buk($im[0]).'. '.p_buk($pb[0]).'.');
$pdf->Text(90,50+$k,'Адреса:'.$rn.' '.$tns.' '.$ns.' '.$tvl.' '.$vl.' '.$budd.' '.$kvarr);
$pdf->Text(110,55+$k,$v_rob);
$pdf->Text(90,60+$k,'Замовлення:   '.$sz.'*'.$nz);
$pdf->Text(90,65+$k,'Сума:   '.$sm);
$pdf->Text(90,70+$k,$sm_pg." грн. ".$kop." коп.");

$pdf->Text(82,15+65+$k,$bti.' ЄДРПОУ - '.$edrpou);
$pdf->Text(82,19+65+$k,'Р/р '.$rah.' в '.$viddil.', МФО '.$mfo);
$pdf->Text(82,23+65+$k,'ІПН '.$ipn.', свідоцтво № '.$sv);
$pdf->Text(82,27+65+$k,'Адреса: '.$adr_bti);
$pdf->Text(160,35+65+$k,$kvut.'             АВАНС');
$pdf->Text(120,40+65+$k,date('d.m.Y').'р.');
$pdf->Text(90,45+65+$k,'Гром. '.$pr[0].' '.p_buk($im[0]).'. '.p_buk($pb[0]).'.');
$pdf->Text(90,50+65+$k,'Адреса:'.$rn.' '.$tns.' '.$ns.' '.$tvl.' '.$vl.' '.$budd.' '.$kvarr);
$pdf->Text(110,55+65+$k,$v_rob);
$pdf->Text(90,60+65+$k,'Замовлення:   '.$sz.'*'.$nz);
$pdf->Text(90,65+65+$k,'Сума:   '.$sm);
$pdf->Text(90,70+65+$k,$sm_pg." грн. ".$kop." коп.");
	
$pdf->Line(10,75+$k,203,75+$k);
$pdf->Line(80,10+$k,80,140+$k);
$pdf->SetFont('dejavu','',10);
$pdf->Text(13,73+$k,'Касир');
$pdf->SetFont('dejavub','',12);
$pdf->Text(105,35+$k,'ПОВІДОМЛЕННЯ № _______________');
$pdf->Text(112,100+$k,'КВИТАНЦІЯ № _______________');
//----------------------------------------------------------------------------------
}

if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
		  
//виводимо документ на екран
$pdf->Output('spvuk.pdf','I');
?>