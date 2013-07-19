<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<!--$sitebuilder version="2.6" extra="Java(1.6.0_18)" md5="321ea0b2502768ae8ecf3a7a70fd000c"$-->

<!--$templateKey Blank||1.0.0$-->
<?php 
ini_set('display_errors',1);
error_reporting(E_ALL & ~ E_NOTICE); 
	if (logged_in()) {
		redirect_to("reservations.php");
	}

	include_once("includes/form_functions.php");
	
	// START FORM PROCESSING
	if (isset($_POST['submit'])) { // Form has been submitted.
		$errors = array();

		// perform validations on the form data
		$required_fields = array('username', 'password');
		$errors = array_merge($errors, check_required_fields($required_fields, $_POST));

		$fields_with_lengths = array('username' => 30, 'password' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));

		$username = trim(mysql_prep($_POST['username']));
		$password = trim(mysql_prep($_POST['password']));
		//$hashed_password = sha1($password);
		
		if ( empty($errors) ) {
			// Check database to see if username and the hashed password exist there.
			$query = "SELECT id, username ";
			$query .= "FROM users ";
			$query .= "WHERE username = '{$username}' ";
			$query .= "AND password = '{$password}' ";
			$query .= "LIMIT 1";
			$result_set = mysql_query($query);
			confirm_query($result_set);
			if (mysql_num_rows($result_set) == 1) {
				// username/password authenticated
				// and only 1 match
				$found_user = mysql_fetch_array($result_set);
				$_SESSION['user_id'] = $found_user['id'];
				$_SESSION['username'] = $found_user['username'];
				
				redirect_to("reservations.php");
			} else {
				// username/password combo was not found in the database
				$message = "Username/password combination incorrect.<br />
					Please make sure your caps lock key is off and try again.";
			}
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {
				$message = "There were " . count($errors) . " errors in the form.";
			}
		}
		
	} else { // Form has not been submitted.
		if (isset($_GET['logout']) && $_GET['logout'] == 1) {
			$message = "You are now logged out.";
		} 
		$username = "";
		$password = "";
	}

?>
<html>

  <head>

    <title>Alto Wine Trail Loft | The Loft | Accommodations &amp; Amenities</title>

    <meta name="generator" content="Yahoo! SiteBuilder/2.6/1.6.0_18">

    <meta name="author" content="IHM">

    <meta name="description" content="Alto Wine Trail Lofts - the lofts.  Currently under renovation, the development will feature two loft units - unique among the cabins and inns of Southern Illinois.">

    <meta name="keywords" content="Southern, Illinois, Cabins, Lofts, Vacation, Lodging, Inns, Bed, Breakfast, Alto, Pass, Shawnee, Wine, Trail, Makanda, Blue, Sky, Giant, City, Lodge, Cabin, Wineries, Carbondale, Cobden, Stone, Creek, Rent, Cottage, Room, Rooms, Marion">

    <!--$page size 1000, 630$-->

    <!--$page margin 0, 0, 20, 0$-->

    <!--$centered$-->

    <!--$fontFamily Arial$-->

    <!--$fontSize 14$-->

    <style type="text/css"><!--

      BODY {font-family:"Arial"; font-size:14;margin:0px;padding:0px;text-align:center;min-width:1000px;}

      P {font-family:"Arial"; font-size:14;}

      FORM {margin:0;padding:0;}

      #centerwrapper {text-align:left;width:1000px;margin-left:auto;margin-right:auto;}

    --></style>
    <script type="text/javascript" src="includes/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="includes/functions.js"></script>
  </head>

  <body bgcolor="#FFFFFF" background="images/background_loft_wl.png" text="#000000" link="#0000FF" vlink="#800080" topmargin="0" leftmargin="0">



<!--$begin exclude$-->

    <div id="centerwrapper">

      <div id="root" style="position:absolute;width:1000px;height:614px;">

<!--$end exclude$--><div id="e1" style="position:absolute;left:0;top:11;width:403;height:120;"><a href="index.html" onMouseOver="document.images['i1'].src='images/altowtl_logo_roll_wl2.png'; return true;"  onMouseOut="document.images['i1'].src='images/altowtl_logo_wl2.png'"><!--$mouseOver %ImageAssetImpl:/images/altowtl_logo_roll_wl2.png$--><img src="images/altowtl_logo_wl2.png" width="403" height="120" border="0" alt="" name="i1"></a></div>        <div id="e2" style="position:absolute;left:32;top:133;width:936;height:42;"><img src="images/nav-bar-frame_wl.png" width="936" height="42" alt=""></div>        <div id="e3" style="position:absolute;left:128;top:148;width:46;height:15;"><a href="index.html" onMouseOver="document.images['i3'].src='images/main_nav_home_roll_wl.png'; return true;"  onMouseOut="document.images['i3'].src='images/main_nav_home_wl.png'"><!--$mouseOver %ImageAssetImpl:/images/main_nav_home_roll_wl.png$--><img src="images/main_nav_home_wl.png" width="46" height="15" border="0" alt="" name="i3"></a></div>        <div id="e4" style="position:absolute;left:199;top:148;width:69;height:15;"><a href="lofts.html" onMouseOver="document.images['i4'].src='images/main_nav_loft_roll_wl.png'; return true;"  onMouseOut="document.images['i4'].src='images/main_nav_loft_wl.png'"><!--$mouseOver %ImageAssetImpl:/images/main_nav_loft_roll_wl.png$--><img src="images/main_nav_loft_wl.png" width="69" height="15" border="0" alt="" name="i4"></a></div>        <div id="e5" style="position:absolute;left:297;top:148;width:115;height:15;"><a href="reservations.php" onMouseOver="document.images['i5'].src='images/main_nav_book_roll_wl.png'; return true;"  onMouseOut="document.images['i5'].src='images/main_nav_book_wl.png'"><!--$mouseOver %ImageAssetImpl:/images/main_nav_book_roll_wl.png$--><img src="images/main_nav_book_wl.png" width="115" height="15" border="0" alt="" name="i5"></a></div>        <div id="e6" style="position:absolute;left:443;top:148;width:129;height:15;"><a href="explore.html" onMouseOver="document.images['i6'].src='images/main_nav_explore_roll_wl.png'; return true;"  onMouseOut="document.images['i6'].src='images/main_nav_explore_wl.png'"><!--$mouseOver %ImageAssetImpl:/images/main_nav_explore_roll_wl.png$--><img src="images/main_nav_explore_wl.png" width="129" height="15" border="0" alt="" name="i6"></a></div>        <div id="e7" style="position:absolute;left:609;top:148;width:123;height:15;"><a href="connect.html" onMouseOver="document.images['i7'].src='images/main_nav_connect_roll_wl.png'; return true;"  onMouseOut="document.images['i7'].src='images/main_nav_connect_wl.png'"><!--$mouseOver %ImageAssetImpl:/images/main_nav_connect_roll_wl.png$--><img src="images/main_nav_connect_wl.png" width="123" height="15" border="0" alt="" name="i7"></a></div>        <div id="e8" style="position:absolute;left:772;top:148;width:84;height:15;"><a href="contact.html" onMouseOver="document.images['i8'].src='images/main_nav_contact_roll_wl.png'; return true;"  onMouseOut="document.images['i8'].src='images/main_nav_contact_wl.png'"><!--$mouseOver %ImageAssetImpl:/images/main_nav_contact_roll_wl.png$--><img src="images/main_nav_contact_wl.png" width="84" height="15" border="0" alt="" name="i8"></a></div>        <div id="e9" style="position:absolute;left:0;top:581;width:219;height:13;"><span class="text"><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;">Copyright &#169; 2010 ALTO WINE TRAIL LOFT.<br soft></span></font></span>        </div>

        <div id="e10" style="position:absolute;left:249;top:581;width:226;height:13;"><span class="text"><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;">Site Design by </span></font><a href="http://www.ihorizonsmedia.com" target="_blank"><font face="Georgia" color="#FFFFFF" size="1"><span style="font-size:10px;line-height:13px;">Infinite Horizons Media {IHM}<br soft></span></font></a></span>        </div>

        <div id="e11" style="position:absolute;left:527;top:581;width:465;height:13;"><span class="text"><a href="index.html"><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;">H</span></font></a><a href="index.html"><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;">OME </span></font></a><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;">&nbsp;&nbsp;| &nbsp;&nbsp;</span></font><a href="lofts.html"><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;">THE LOFT</span></font></a><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;"> &nbsp;&nbsp;| &nbsp;&nbsp;</span></font><a href="reservations.php"><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;">BOOK YOUR STAY</span></font></a><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;"> &nbsp;&nbsp;| &nbsp;&nbsp;</span></font><a href="explore.html"><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;">EXPLORE THE AREA</span></font></a><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;"> &nbsp;&nbsp;| &nbsp;&nbsp;</span></font><a href="connect.html"><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;">CONNECT</span></font></a><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;"> &nbsp;&nbsp;| &nbsp;&nbsp;</span></font><a href="contact.html"><font face="Georgia" color="#CCCCCC" size="1"><span style="font-size:10px;line-height:13px;">CONTACT<br soft></span></font></a></span>        </div>

        <div id="e12" style="position:absolute;left:678;top:34;width:322;height:84;"><a href="reservations.php" onMouseOver="document.images['i12'].src='images/open-late-summ-roll-wl.png'; return true;"  onMouseOut="document.images['i12'].src='images/open-late-summ-wl.png'"><!--$mouseOver %ImageAssetImpl:/images/open-late-summ-roll-wl.png$--><img src="images/open-late-summ-wl.png" width="322" height="84" border="0" alt="" name="i12"></a></div>        <div id="e13" style="position:absolute;left:770;top:3;width:230;height:18;"><span class="text"><font face="Georgia" color="#FFFFFF" size="2"><span style="font-size:12px;line-height:14px;">Call for Reservations! </span></font><b><font face="Georgia" color="#FFFFFF"><span style="font-size:14px;line-height:17px;">&nbsp;618-698-7474<br soft></span></font></b></span>        </div>
        <div id="e16" style="position:absolute; left:25; top:193; width:222; height:44; font-size: 36px; color: #FFF;">Login</div>        
        
        <div id="e17" style="position:absolute; left:186px; top:255px; width:522; height:247;">


		<?php //echo output_message($message); ?>

		<form action="login.php" method="post">
		  <table>
		    <tr>
		      <td>Username:</td>
		      <td>
		        <input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username); ?>" />
		      </td>
		    </tr>
		    <tr>
		      <td>Password:</td>
		      <td>
		        <input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password); ?>" />
		      </td>
		    </tr>
		    <tr>
		      <td colspan="2">
		        <input type="submit" name="submit" value="Login" />
		      </td>
		    </tr>
		  </table>
		</form>
        </div>

<!--$begin exclude$-->

      </div>

    </div>

<!--$end exclude$-->

  </body>

</html>

