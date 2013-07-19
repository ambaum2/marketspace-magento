<?php require_once("includes/session.php"); ?>

<?php require_once("includes/connection.php"); ?>

<?php require_once("includes/functions.php"); ?>



<!--$sitebuilder version="2.6" extra="Java(1.6.0_18)" md5="8be7ba5095b2f4ef75bde442d5de4915"$-->

<?php 

ini_set('display_errors',1);

error_reporting(E_ALL & ~ E_NOTICE); 

?>

<!--$templateKey Blank||1.0.0$-->

<?php 

if($_GET["logout"]) {

	logout();

}

?>

<?php 

$user_admin = confirm_logged_in();

$north_loft = "";

$south_loft = "";

?>

<html>

  <head>

    <title>Alto Wine Trail Loft | Book Your Stay | Reservations</title>

    <meta name="generator" content="Yahoo! SiteBuilder/2.6/1.6.0_18">

    <meta name="author" content="IHM">

    <meta name="description" content="Book Your Stay at the Alto Wine Trail Lofts.  Make your reservations for a Southern Illinois getaway today!  A stylish alternative to the cabins of Southern Illinois - get away in style!">

    <meta name="keywords" content="Southern, Illinois, Cabins, Lofts, Vacation, Lodging, Inns, Bed, Breakfast, Alto, Pass, Shawnee, Wine, Trail, Makanda, Blue, Sky, Giant, City, Lodge, Cabin, Wineries, Carbondale, Cobden, Stone, Creek, Reserve, Rent, Room">

    <!--$page size 1000, 625$-->

    <!--$page margin 0, 0, 20, 0$-->

    <!--$centered$-->

    <!--$fontFamily Arial$-->

    <!--$fontSize 14$-->

    <script type="text/javascript" src="includes/jquery-1.3.2.min.js"></script>

    <script type="text/javascript" src="includes/functions.js"></script>



    <style type="text/css">

    <!--

      BODY {font-family:"Arial"; font-size:14;margin:0px;padding:0px;text-align:center;min-width:1000px;}

      P {font-family:"Arial"; font-size:14;}

      FORM {margin:0;padding:0;}

      #centerwrapper {text-align:left;width:1000px;margin-left:auto;margin-right:auto;}

	  #apDiv2 {
	position:absolute;
	width:989px;
	height:514px;
	z-index:1;
	left: -3px;
	top: 332px;
}

	  table.calendar td {margin:0px;text-align: center;font-size:12px;}

	  div.calendar {float:left;width:194px;font-size:12px;}

	  table.calendar {background: #CCCCCC;float:left;margin: 0px 10px 10px 10px;font-size:12px;border: 3px solid #333;}

	  #apDiv1 {
	position:absolute;
	width:368px;
	height:29px;
	z-index:1;
	left:2px;
	top: 258px;
	text-align: left;
}

	  #apDiv1 a {

	color:#ffffff;

	text-decoration:none;float:left;margin-right:9px;

}

	  

	  #apDiv3 {position:absolute;width:262px;height:27px;z-index:1;left:0px;top: 0px;text-align: left;}

	  #apDiv3 a {font-size:18px;color:white; text-decoration:none;}

	  #apDiv3 a:hover {text-decoration:underline;}

	  #apDiv1 a.textButton {background:#F92;color:#534741;padding:4px;margin-top:4px;-moz-border-radius:7;font-weight:bolder;}

	  #apDiv1 a.textButton:hover {background:#202020;color:white;}
#apDiv4 {
	position:absolute;
	width:503px;
	height:147px;
	z-index:1;
	left: 466px;
	top: 179px;
}

    -->



    </style>

    <script type="text/javascript">

<!--

function MM_swapImgRestore() { //v3.0

  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;

}

function MM_preloadImages() { //v3.0

  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();

    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)

    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}

}



function MM_findObj(n, d) { //v4.01

  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {

    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}

  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];

  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);

  if(!x && d.getElementById) x=d.getElementById(n); return x;

}



function MM_swapImage() { //v3.0

  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)

   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}

}

//-->

    </script>

  </head>

  

  <body bgcolor="#FFFFFF" background="images/bigger_back_lofts_wl.gif" text="#000000" link="#0000FF" vlink="#800080" leftmargin="0" topmargin="0" onLoad="MM_preloadImages('images/reserve-now-linkroll-wl.png','images/northloft_link_roll_wl.png','images/southloft_link_roll_wl.png')">





<!--$begin exclude$-->



    <div id="centerwrapper"> 



      <div id="root" style="position:absolute; width:1000px; height:893px;">

<div id="apDiv1" style="color:#FFF">

<?php if($_GET['cabin']==1  || empty($_GET['cabin'])) : ?>

 <a href="reservations.php?cabin=1"><img src="images/frontloft_link_wl.png" name="northLoft" width="124" height="28" border="0"></a>

 <?php else : ?> 

 <!--<a href="reservations.php?cabin=1" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('northLoft','','images/northloft_link_roll_wl.png',1)"><img src="images/northloft_link_wl.png" name="northLoft" width="119" height="29" border="0"></a>&nbsp; -->
 <a href="reservations.php?cabin=1"><img src="images/frontloft_link_wl.png" name="northLoft" width="124" height="28" border="0"></a>
 <?php endif; ?>

 

<?php if($_GET['cabin']==2) : ?>

<a href="reservations.php?cabin=2"><img src="images/backloft_link_wl.png" name="southLoft" width="124" height="28" border="0"></a>

<?php else : ?>

<!-- <a href="reservations.php?cabin=2" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('southLoft','','images/southloft_link_roll_wl.png',1)"><img src="images/southloft_link_wl.png" name="southLoft" width="119" height="29" border="0"></a> -->
<a href="reservations.php?cabin=2"><img src="images/backloft_link_wl.png" name="southLoft" width="124" height="28" border="0"></a>

<?php endif; ?>

</div>
<div id="apDiv4">
<?php if($user_admin==false) : ?>

<!--<a href="contact.html" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('reserveNow','','images/reserve-now-linkroll-wl.png',1)"><img src="images/reserve-now-link-wl.png" name="reserveNow" width="148" height="29" border="0"></a> -->
<div id="e15" style="position:absolute;left:2px;top:0px;width:495;height:141;"><img src="images/reserve-box-wl2.png" width="495" height="141" alt=""></div>
<div id="e17" style="position:absolute; left:181px; top:90px; width:130; height:43;"><a href="javascript:void(0)" onMouseOver="window.status=''; document.images['i17'].src='images/paypal-link-small-roll-wl.png'; return true;"  onMouseOut="document.images['i17'].src='images/paypal-link-small-wl.png'"><!--$mouseOver %ImageAssetImpl:/images/paypal-link-small-roll-wl.png$--><img src="images/paypal-link-small-wl.png" width="130" height="43" border="0" alt="" name="i17"></a></div>
<div id="e16" style="position:absolute; left:297px; top:35px; width:168; height:18;"><a href="mailto:bstone1429@yahoo.com"><img src="images/emal-lil-wl.png" width="168" height="18" border="0" alt=""></a></div>

<?php else : ?>

<a href="reservations.php?logout=true" class="textButton">Logout</a><br />

<?php endif; ?>
</div>
<!--$end exclude$-->



        <div id="e0" style="position:absolute;left:0;top:11;width:403;height:120;"><a href="index.html" onMouseOver="document.images['i0'].src='images/altowtl_logo_roll_wl2.png'; return true;"  onMouseOut="document.images['i0'].src='images/altowtl_logo_wl2.png'"><!--$mouseOver %ImageAssetImpl:/images/altowtl_logo_roll_wl2.png$--><img src="images/altowtl_logo_wl2.png" width="403" height="120" border="0" alt="" name="i0"></a></div>        <div id="e1" style="position:absolute;left:0;top:860;width:219;height:13;"><span class="text"><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;">Copyright &#169; 2010 ALTO WINE TRAIL LOFT.<br soft></span></font></span>        </div>



        <div id="e2" style="position:absolute;left:249;top:860;width:226;height:13;"><span class="text"><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;">Site Design by </span></font><a href="http://www.ihorizonsmedia.com" target="_blank"><font face="Georgia" color="#FFFFFF" size="1"><span style="font-size:10px;line-height:13px;">Infinite Horizons Media {IHM}<br soft></span></font></a></span>        </div>



        <div id="e3" style="position:absolute;left:527;top:860;width:465;height:13;"><span class="text"><a href="index.html"><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;">H</span></font></a><a href="index.html"><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;">OME </span></font></a><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;">&nbsp;&nbsp;| &nbsp;&nbsp;</span></font><a href="lofts.html"><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;">THE LOFT</span></font></a><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;"> &nbsp;&nbsp;| &nbsp;&nbsp;</span></font><a href="reservations.html"><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;">BOOK YOUR STAY</span></font></a><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;"> &nbsp;&nbsp;| &nbsp;&nbsp;</span></font><a href="explore.html"><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;">EXPLORE THE AREA</span></font></a><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;"> &nbsp;&nbsp;| &nbsp;&nbsp;</span></font><a href="connect.html"><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;">CONNECT</span></font></a><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;"> &nbsp;&nbsp;| &nbsp;&nbsp;</span></font><a href="contact.html"><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;">CONTACT<br soft></span></font></a></span>        </div>



        <!--<div id="e4" style="position:absolute;left:678;top:34;width:322;height:84;"><a href="reservations.html" onMouseOver="document.images['i4'].src='images/open-late-summ-roll-wl.png'; return true;"  onMouseOut="document.images['i4'].src='images/open-late-summ-wl.png'"><!--$mouseOver %ImageAssetImpl:/images/open-late-summ-roll-wl.png$--><!--<img src="images/open-late-summ-wl.png" width="322" height="84" border="0" alt="" name="i4"></a></div>-->        <div id="e5" style="position:absolute;left:770;top:3;width:230;height:18;"><span class="text"><font face="Georgia" color="#FFFFFF" size="2"><span style="font-size:12px;line-height:14px;">Call for Reservations! </span></font><b><font face="Georgia" color="#FFFFFF"><span style="font-size:14px;line-height:17px;">&nbsp;618-698-7474<br soft></span></font></b></span>        </div>



        <div id="e6" style="position:absolute;left:32;top:133;width:936;height:42;"><img src="images/nav-bar-frame_wl.png" width="936" height="42" alt=""></div>        <div id="e7" style="position:absolute;left:76;top:148;width:46;height:15;"><a href="index.html" onMouseOver="document.images['i7'].src='images/main_nav_home_roll_wl.png'; return true;"  onMouseOut="document.images['i7'].src='images/main_nav_home_wl.png'"><!--$mouseOver %ImageAssetImpl:/images/main_nav_home_roll_wl.png$--><img src="images/main_nav_home_wl.png" width="46" height="15" border="0" alt="" name="i7"></a></div>        <div id="e8" style="position:absolute;left:143;top:148;width:69;height:15;"><a href="lofts.html" onMouseOver="document.images['i8'].src='images/main_nav_loft_roll_wl.png'; return true;"  onMouseOut="document.images['i8'].src='images/main_nav_loft_wl.png'"><!--$mouseOver %ImageAssetImpl:/images/main_nav_loft_roll_wl.png$--><img src="images/main_nav_loft_wl.png" width="69" height="15" border="0" alt="" name="i8"></a></div>        <div id="e9" style="position:absolute;left:235;top:148;width:115;height:15;"><a href="reservations.html" onMouseOver="document.images['i9'].src='images/main_nav_book_roll_wl.png'; return true;"  onMouseOut="document.images['i9'].src='images/main_nav_book_wl.png'"><!--$mouseOver %ImageAssetImpl:/images/main_nav_book_roll_wl.png$--><img src="images/main_nav_book_wl.png" width="115" height="15" border="0" alt="" name="i9"></a></div>        <div id="e10" style="position:absolute;left:375;top:148;width:129;height:15;"><a href="explore.html" onMouseOver="document.images['i10'].src='images/main_nav_explore_roll_wl.png'; return true;"  onMouseOut="document.images['i10'].src='images/main_nav_explore_wl.png'"><!--$mouseOver %ImageAssetImpl:/images/main_nav_explore_roll_wl.png$--><img src="images/main_nav_explore_wl.png" width="129" height="15" border="0" alt="" name="i10"></a></div>        <div id="e11" style="position:absolute;left:699;top:148;width:123;height:15;"><a href="connect.html" onMouseOver="document.images['i11'].src='images/main_nav_connect_roll_wl.png'; return true;"  onMouseOut="document.images['i11'].src='images/main_nav_connect_wl.png'"><!--$mouseOver %ImageAssetImpl:/images/main_nav_connect_roll_wl.png$--><img src="images/main_nav_connect_wl.png" width="123" height="15" border="0" alt="" name="i11"></a></div>        <div id="e12" style="position:absolute;left:852;top:148;width:84;height:15;"><a href="contact.html" onMouseOver="document.images['i12'].src='images/main_nav_contact_roll_wl.png'; return true;"  onMouseOut="document.images['i12'].src='images/main_nav_contact_wl.png'"><!--$mouseOver %ImageAssetImpl:/images/main_nav_contact_roll_wl.png$--><img src="images/main_nav_contact_wl.png" width="84" height="15" border="0" alt="" name="i12"></a></div>        <div id="e13" style="position:absolute;left:528;top:147;width:145;height:17;"><a href="partners.html" onMouseOver="document.images['i13'].src='images/main_nav_prefpart_roll_wl.png'; return true;"  onMouseOut="document.images['i13'].src='images/main_nav_prefpart_wl.png'"><!--$mouseOver %ImageAssetImpl:/images/main_nav_prefpart_roll_wl.png$--><img src="images/main_nav_prefpart_wl.png" width="145" height="17" border="0" alt="" name="i13"></a></div>        <div id="e14" style="position:absolute;left:0;top:193;width:370;height:54;"><img src="images/book-title-onyl-wl.png" width="370" height="54" alt=""></div>        

<div id="loftinfo" style="position:absolute;left:4;top:239;width:407;height:16;"><img src="images/text-two-units-wl.png" width="407" height="16" alt=""></div>         

<div id="e15">

        <?php if($_GET['cabin']==2) : ?>

      <div id="backloft" style="position:absolute;left:1px;top:287;width:269;height:37;"><img src="images/backloft-title-wl.png" width="269" height="37" alt=""></div>

        <?php else : ?>

      <div id="frontloft" style="position:absolute; left:1px; top:287px; width:269; height:37;"><img src="images/front-loft-title-wl.png" width="269" height="37" alt=""></div>

        <?php endif; ?><br soft>     

</div>

<div id="apDiv2">



	<?php	

	// **********should count the lofts in the database and check for >0  <num_cabins //

if(isset($_GET['cabin']) && $_GET['cabin']>0 && !is_null($_GET['cabin'])) {

	$cabin = $_GET['cabin'];

} else {

	$cabin = 1; //default

}



if (isset($cabin)) {

		$calendar_counter = 1;

		$num_calendars = 12;

 		$weekNames = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');

		$output = "";

		$outputEnd = "";

		$daysArray = array();

		



while($calendar_counter<=$num_calendars) {



			$i=1;

			$k=1;

			$start_day = 0;

			$found_start=false;

			$row_counter = 0;

			$edit_type = 'insert';

            $booked = false;

			$id = 0;



			//need to also check the database for records that match the current month and year and store the matching days into an array called booked_days, using mysql fetch array



			if($calendar_counter ==1) {



				$curr_month = strftime("%B");

				$curr_month_stamp = strtotime('this month');

				$last_day = date("t",$curr_month_stamp);

				$curr_year = strftime("%Y",$curr_month_stamp);

				settype($last_day, "integer");

				settype($curr_year, "integer");

				settype($curr_month, "string");

				$curr_month_stamp_first_day = strtotime('1 ' . $curr_month . ' ' . $curr_year);

				$first_day = strftime("%a",$curr_month_stamp_first_day);

				$calendar_counter++;

			} else {

                                

				$curr_month_stamp = strtotime('+1 month',$curr_month_stamp);

				$curr_month = strftime("%B",$curr_month_stamp);

				$last_day = date("t",$curr_month_stamp);

				$curr_year = strftime("%Y",$curr_month_stamp);

				settype($last_day, "integer");

				settype($curr_year, "integer");

				settype($curr_month, "string");

				$curr_month_stamp_first_day = strtotime('1 ' . $curr_month . ' ' . $curr_year);

				$first_day = strftime("%a",$curr_month_stamp_first_day);

				$calendar_counter++;

			}

			//Query mysql for array of reserved days given the month and year

			//Connect to Database

			$query = "SELECT * 

				FROM rooms ";

		$query .= "WHERE year = {$curr_year} ";

		$query .= "AND month ='{$curr_month}' "; //must have single quotes for strings

		$query .= " AND room = {$cabin} ";

		$query .= "ORDER BY day ASC";



			while ($i <= $last_day) {

				if($i==1) {

					$output = "<div class=\"calendar\"><table class=\"calendar\"><tr align=\"center\"><td align=\"center\" colspan=\"7\">{$curr_month} {$curr_year}</td></tr><tr>";

					print $output;

					foreach($weekNames as $day) {

						print "<td>{$day}</td>";

						if($found_start==false) {

							if($day==$first_day) { //need to set first_day

								$found_start = true;

							}

						$start_day++;

						}

					}

					print "</tr><tr>";

					if($found_start==true) {

						while($i < $start_day) { //the indent over counts so no <=

							print "<td></td>";

							$i++;

						}

					$i=1;

					} 

				}

				if($k==8) { //we reached the end of the week

					print "</tr>";

					$k=1;

					$row_counter++;

				} elseif($found_start && (($k+$start_day-1)==8)) { //case for the first week

					print "</tr>";

					$k=1;

					$found_start=false;

					$row_counter++;

				} else {

				//Put in a while loop to check the mysql array for a match to this day if so highlight background else put in link editType={$edit_type}&

				   if($r = mysql_query($query)) {

                        while($row= mysql_fetch_array($r)) {

							if($i == $row['day']) {

								$booked = true;

								$edit_type = 'delete';

								$id = $row['id'];

							}

						}

                    }

				

					$output ="<td";

                        if($booked == true) { $output .= " style=\"background-color:red;\""; }

					if($user_admin == true) {

					$output .= "><a href=\"edit.php?editType={$edit_type}&year={$curr_year}&month={$curr_month}&day={$i}";

						if($id > 0) { $output .= "&id={$id}";}

					$output .="&cabin={$cabin}\">$i</a></td>";

					} else {

						$output .= ">$i</td>";

					}

							

					echo $output;

								$i++;

								$k++;

                                $edit_type = 'insert';

                                $booked = false;

								$id = 0;

				}

			}

			if($row_counter==4) { print "<tr><td>&nbsp;</td></tr>";} // for formatting rows even we add an extra row

			 print "</table></div>";

		}

} else {

	$output = '<div id="apDiv3" style="color:#FFF"><a href="reservations.php?cabin=1"'; 

	   if($_GET['cabin']==1) {$output .= "style=\"font-weight:900\"";} 

	$output .= '>Cabin 1 </a>&nbsp;';

    $output .= '<a href="reservations.php?cabin=2"';

	   if($_GET['cabin']==2) {$output .= "style=\"font-weight:900\"";}

	$output .= '>Cabin 2 </a></div>';

	echo $output;

}





	?>

		</div>

        <!--$begin exclude$-->

     </div>

</div>

<!--$end exclude$-->

</body>

</html>







