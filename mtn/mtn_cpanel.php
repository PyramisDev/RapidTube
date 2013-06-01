<?php if (!defined('RAPIDLEECH')) { header("Location: ../index.php"); }

if (isset($_POST['setup_save']) && $_POST['setup_save'] == 1) {
	
	$mtn = array();
	reset($default_mtn);
	while (key($default_mtn) == !array_key_exists(key($default_mtn), $mtn)) { $mtn[key($default_mtn)] = current($default_mtn); next($default_mtn); }
	
	reset($default_mtn);
	while (key($default_mtn) !== NULL) {
		if (is_array($default_mtn[key($default_mtn)])) { continue; }
		if (is_bool($default_mtn[key($default_mtn)])) {
			$mtn[key($default_mtn)] = (isset($_POST['mtn_'.key($default_mtn)]) && $_POST['mtn_'.key($default_mtn)] ? true : false);
		}
		else if (is_numeric($default_mtn[key($default_mtn)])) {
			$mtn[key($default_mtn)] = (isset($_POST['mtn_'.key($default_mtn)]) && $_POST['mtn_'.key($default_mtn)] ? $_POST['mtn_'.key($default_mtn)] : 0);
		}
		else {
			$mtn[key($default_mtn)] = (isset($_POST['mtn_'.key($default_mtn)]) && $_POST['mtn_'.key($default_mtn)] ? stripslashes($_POST['mtn_'.key($default_mtn)]) : '');
		}
		next($default_mtn);
	}
	
	ob_start(); var_export($mtn); $mtn_ = ob_get_contents(); ob_end_clean();
	$mtn_ = (strpos($mtn_, "\r\n") === false ? str_replace(array("\r", "\n"), "\r\n", $mtn_) : $mtn_);
	$mtn_ = "<?php\r\n if (!defined('RAPIDLEECH')) { require_once('index.html'); exit; }\r\n\r\n\$mtn = ".
	$mtn_.
	"; \r\n?>";
	if (!@write_file(MTN_DIR.'config.php', $mtn_, 1)) {
		echo '<div align="center">It was not possible to write the configuration<br />Set permissions of "mtn" folder to 0777 and try again<br /><b><a href="'.$PHP_SELF.'?CPanel">Continue to CPanel</a><br />or</b></div>';
	}
	else {
		echo '<center><br /><b class="rev-dev">Configuration saved!<br /><a href="'.$PHP_SELF.'?CPanel">Continue to CPanel</a><br />or<br /><b class="rev-dev"><a href="'.$PHP_SELF.'">Back to MTN</a></b></center>';
	}
}
else {
$user = $mtn['user'];	
$pass = $mtn['pass'];
$info = '<br /><center><b><a href="'.$PHP_SELF.'">Back to MTN</a></b>';
$protected = true;
require('login.php');
?>

<form method="post">
<center style="padding-left:600px;"><b><small class="rev-dev">Hi, <?php echo $user; ?> - <a href="<?php echo $PHP_SELF; ?>">Back to MTN</a><input type="submit" style="font-size:smaller" name="logout" value="Logout" /></small></b></center>
</form>

<center><b style="font-size:15px">Control Panel</b><br /><b><small class="rev-dev"><?php echo ($old_mtn ? 'Your' : 'Default'); ?> Config loaded</small></b></center>

<form method="post" enctype="multipart/form-data" name="setup_form" action="<?php echo $PHP_SELF.'?CPanel'; ?>">
<table align="center" border="1" cellspacing="0" cellpadding="2">
<tr>
<td align="right">MTN Login : </td><td><input type="text" id="mtn_user" name="mtn_user" size="14" />User &nbsp; <input type="text" id="mtn_pass" name="mtn_pass" size="14" />Pass</td>
</tr>

<tr>
<td align="right"><label for="mtn_showmtnconfig">&nbsp;Show Config at MTN : </label></td> <td><input type="checkbox" id="mtn_showmtnconfig" name="mtn_showmtnconfig" onclick="var displ=this.checked?'':'none';document.getElementById('showmtn_text1').style.display=displ;document.getElementById('showmtn_text2').style.display=displ;" value"true">Show Configuration at Movie Thumbnailer</td>
</tr>

<tr id="showmtn_text1" style="display:<?php echo ($mtn['showmtnconfig']? '':'none');?>">
<td align="right"></td> <td><input type="checkbox" id="mtn_showmtntext" name="mtn_showmtntext" value"true" />Show Text &amp; Output Suffix at Movie Thumbnailer</td>
</tr>

<tr>
<td align="right">Columns x Rows : </td><td><select id="mtn_c" name="mtn_c"><option value="1">1</option>
                                                                              <option value="2">2</option>
                                                                              <option value="3">3</option>
                                                                              <option value="4">4</option>
                                                                              <option value="5">5</option></select> x <select id="mtn_r" name="mtn_r"><option value="1">1</option>
                                                                                                                                                        <option value="2">2</option>
                                                                                                                                                        <option value="3">3</option>
                                                                                                                                                        <option value="4">4</option>
                                                                                                                                                        <option value="5">5</option>
                                                                                                                                                        <option value="6">6</option>
                                                                                                                                                        <option value="7">7</option>
                                                                                                                                                        <option value="8">8</option>
                                                                                                                                                        <option value="9">9</option>
                                                                                                                                                        <option value="10">10</option></select></td>
</tr>

<tr>
<td align="right"><span onMouseOver="document.getElementById('width').style.display='block'" onMouseOut="document.getElementById('width').style.display='none'" style="cursor:help">Width</span> : </td><td><input type="text" id="mtn_w" name="mtn_w" size="3" /></td>
</tr>

<tr>
<td align="right"><span onMouseOver="document.getElementById('minimum_height').style.display='block'" onMouseOut="document.getElementById('minimum_height').style.display='none'" style="cursor:help">Minimum Height</span> : </td><td><input type="text" id="mtn_h" name="mtn_h" size="3" /></td>
</tr>

<tr>
<td align="right"><span onMouseOver="document.getElementById('text').style.display='block'" onMouseOut="document.getElementById('text').style.display='none'" style="cursor:help">Text</span> : </td><td><input type="text" id="mtn_T" name="mtn_T" size="25" /></td>
</tr>

<tr>
<td align="right">Output Suffix : </td><td><input type="text" id="mtn_o" name="mtn_o" size="25" /></td>
</tr>

<tr>
<td align="right">Background Color : </td><td><input class="color" id="mtn_k" name="mtn_k" size="7" /></td>
</tr>

<tr>
<td align="right">Jpeg Quality : </td><td><select id="mtn_j" name="mtn_j"><option value="60">60%</option>
                                                                          <option value="70">70%</option>
                                                                          <option value="80">80%</option>
                                                                          <option value="90">90%</option>
                                                                          <option value="100">100%</option></select></td>
</tr>

<tr>
<td align="right"><span onMouseOver="document.getElementById('edge').style.display='block'" onMouseOut="document.getElementById('edge').style.display='none'" style="cursor:help">Edge</span> : </td><td><select id="mtn_g" name="mtn_g"><option value="0">Off</option>
                                                                                                                                                                                                                                                                           <option value="1">1</option>
                                                                                                                                                                                                                                                                           <option value="2">2</option>
                                                                                                                                                                                                                                                                           <option value="3">3</option>
                                                                                                                                                                                                                                                                           <option value="4">4</option>
                                                                                                                                                                                                                                                                           <option value="5">5</option></select></td>
</tr>

<tr>
<td align="right"><span onMouseOver="document.getElementById('step').style.display='block'" onMouseOut="document.getElementById('step').style.display='none'" style="cursor:help">Step</span> : </td><td><input type="text" id="mtn_C" name="mtn_C" size="5" /> <select id="mtn_time" name="mtn_time"><option value="min">minutes</option>
                                                                                                                                                                                                                                                                                                                                        <option value="sec">seconds</option></select></td>
</tr>

<tr>
<td align="right"><span onMouseOver="document.getElementById('individual_shots').style.display='block'" onMouseOut="document.getElementById('individual_shots').style.display='none'" style="cursor:help">Individual Shots</span> : </td><td><input type="checkbox" id="mtn_I" name="mtn_I" value="true" />On</td>
</tr>

<tr>
<td align="right"><span onMouseOver="document.getElementById('save_info').style.display='block'" onMouseOut="document.getElementById('save_info').style.display='none'" style="cursor:help">Save Info</span> : </td><td><input type="checkbox" id="mtn_N"  name="mtn_N" value="true" />On</td>
</tr>

<tr>
<td align="right">Video Info : </td><td><input  name="mtn_i" type="checkbox" id="mtn_i" value="true" />On &nbsp; <select id="mtn_Ts" name="mtn_Ts"><option value="8">8</option>
                                                                                                                                                   <option value="9">9</option>
                                                                                                                                                   <option value="10">10</option>
                                                                                                                                                   <option value="11">11</option>
                                                                                                                                                   <option value="12">12</option>
                                                                                                                                                   <option value="13">13</option>
                                                                                                                                                   <option value="14">14</option>
                                                                                                                                                   <option value="15">15</option></select> Size &nbsp; <input class="color" id="mtn_Tc" name="mtn_Tc" size="7" /> Color &nbsp; <?php
																																																																			   $exts = array('.ttf', '.otf');
																																																																			   $fonts = array();
																																																																			   $fonts = fileList('mtn/font/');
																																																																			   echo '<select id="mtn_f" name="mtn_f">';
																																																																			   reset($fonts);
																																																																			   while (key($fonts) !== NULL) {
																																																																				   echo '<option value="'.current($fonts).'"'.'>'.substr(current($fonts), 0, -4).'</option>';
																																																																				   next($fonts);
																																																																			   }
																																																																			   echo '</select>'
																																																																			   ?> Font</td>
</tr>

<tr>
<td align="right">Time : </td><td><input type="checkbox" id="mtn_t" name="mtn_t" value="true" />On &nbsp; <input class="color" id="mtn_tc" name="mtn_tc" size="7" /> Color &nbsp; <input class="color" id="mtn_ts" name="mtn_ts" size="7" /> Shadow</td>
</tr>

<tr>
<td align="right">Location : </td><td><select id="mtn_iL" name="mtn_iL"><option value="1">Lower Left</option>
                                                                        <option value="4">Upper Left</option></select> Info &nbsp; <select id="mtn_tL" name="mtn_tL"><option value="1">Lower Left</option>
                                                                                                                                                                     <option value="2">Lower Right</option>
                                                                                                                                                                     <option value="3">Upper Right</option>
                                                                                                                                                                     <option value="4">Upper Left</option></select> Time</td>
</tr>
</table>
<center><input type="hidden" value="1" name="setup_save" /><input type="button" value="Save Configuration" id="save" name="save" disabled="disabled" /><input type="button" value="Reset" id="reset" name="reset" disabled="disabled" /></center>
</form>

<?php if ($old_mtn){ echo '<form method="post" ><center><input type="submit" id="delete" name="delete" value="Default" /><span class="nav_text" onMouseOver="document.getElementById(\'help_text8\').style.display=\'block\'" onMouseOut="document.getElementById(\'help_text8\').style.display=\'none\'" style="cursor:help"> [?]<br /></center></form>';}
}
?>

<center>
<span id="width" style="display:none">Width of output image; 0:column * movie width</span>
<span id="minimum_height" style="display:none">Minimum height of each shot; will reduce # of column to fit</span>
<span id="text" style="display:none">Add text above output image</span>
<span id="edge" style="display:none">Gap between each shot</span>
<span id="step" style="display:none">Cut movie and thumbnails not more than the specified seconds</span>
<span id="individual_shots" style="display:none">Save individual shots too</span>
<span id="save_info" style="display:none">Save info text to a file .txt</span>
</center>