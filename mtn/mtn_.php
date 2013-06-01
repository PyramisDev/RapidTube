<?php
if (!defined('RAPIDLEECH')) { header("Location: ../index.php"); }

$user = $mtn['user'];	
$pass = $mtn['pass'];
$info = '<br /><center><b><a href="'.$PHP_SELF.'">Back to MTN</a></b>';
$protected = false;
require('login.php');
?>
<center>
<?php
if($mtn['showmtnconfig'] == true) {
	$mtn['c'] = $_POST['mtn_c'];
	$mtn['r'] = $_POST['mtn_r'];
	$mtn['w'] = $_POST['mtn_w'];
	$mtn['h'] = $_POST['mtn_h'];
	if($mtn['showmtntext'] == true) {
		$mtn['T'] = $_POST['mtn_T'];
		$mtn['o'] = $_POST['mtn_o'];
	}
	$mtn['k'] = $_POST['mtn_k'];
	$mtn['j'] = $_POST['mtn_j'];
	$mtn['g'] = $_POST['mtn_g'];
	$mtn['I'] = $_POST['mtn_I'];
	$mtn['N'] = $_POST['mtn_N'];
	$mtn['i'] = $_POST['mtn_i'];
	$mtn['Ts'] = $_POST['mtn_Ts'];
	$mtn['Tc'] = $_POST['mtn_Tc'];
	$mtn['f'] = $_POST['mtn_f'];
	$mtn['t'] = $_POST['mtn_t'];
	$mtn['tc'] = $_POST['mtn_tc'];
	$mtn['ts'] = $_POST['mtn_ts'];
	$mtn['iL'] = $_POST['mtn_iL'];
	$mtn['tL'] = $_POST['mtn_tL'];
	$mtn['C'] = $_POST['mtn_C'];
	$mtn['time'] = $_POST['mtn_time'];
}

$mtn_cal = $mtn['c'] * $mtn['r'] + 1;

if($mtn['time'] == 'min') { $cal_step = $mtn_cal * 60 * $mtn['C']; }
else if($mtn['time'] == 'sec') { $cal_step = $mtn_cal * $mtn['C']; }

if(isset($_POST['video']) && isset($_POST['generate']) != '') {
	
	if ($_POST['all'] == true) {
		$exts = array('.3gp', '.3g2', '.asf', '.avi', '.dat', '.divx', '.dsm', '.evo', '.flv', '.m1v', '.m2ts', '.m2v', '.m4a', '.mj2', '.mjpg', '.mjpeg', '.mkv', '.mov', '.moov', '.mp4', '.mpg', '.mpeg', '.mpv', '.nut', '.ogg', '.ogm', '.qt', '.swf', '.ts', '.vob', '.wmv', '.xvid');
		$files = array();
		$files = fileList($options['download_dir']);
	}
	else {
		$files = array();
		$files[0] = $_POST['video'];
	}
	
	reset($files);
	while (key($files) !== NULL) {
		
		if (substr(PHP_OS, 0, 3) == WIN) { $cmd = 'mtn\mtn'; } else { $cmd = 'mtn/mtn'; }
		if ($mtn['i'] == false) { $cmd .= ' -i '; }
		if ($mtn['t'] == false) { $cmd .= ' -t '; }
		if ($mtn['I'] == true) { $cmd .= ' -I '; }
		if ($mtn['w'] != '' && $mtn['w'] > 0 && $mtn['w'] < 2001) { $cmd .= ' -w '.$mtn['w']; }
		if($mtn['C'] != '') { $cmd .= ' -C '.$cal_step; }
		if($mtn['T'] != '') { $cmd .= ' -T '.escapeshellarg($mtn['T']); }
		if($mtn['h'] != '') { $cmd .= ' -h '.$mtn['h']; }
		if($mtn['N'] == true) { $cmd .= ' -N _'.escapeshellarg($mtn['o']).'.txt'; }
		$cmd .= ' -c '.$mtn['c'].' -r '.$mtn['r'].' -o _'.escapeshellarg($mtn['o']).'.jpg -k '.$mtn['k'].' -j '.$mtn['j'].' -g '.$mtn['g'].' -F '.$mtn['Tc'].':'.$mtn['Ts'].':mtn/font/'.$mtn['f'].':'.$mtn['tc'].':'.$mtn['ts'].':'.$mtn['Ts'].' -f mtn/font/'.$mtn['f'].' -L '.$mtn['iL'].':'.$mtn['tL'].' -P '.$options['download_dir'].escapeshellarg(current($files));
		
		echo execOutput($cmd);
		
		$ext = strtolower(strrchr(current($files), '.'));
		$vdofile = str_ireplace($ext, '_'.$mtn['o'].'.jpg', current($files));
		$image = $options['download_dir'].$vdofile;
		if (file_exists($options['download_dir'].$vdofile)) {
			echo '<div><a href="'.$image.'" title="'.$vdofile.'"><img src="'.$image.'"></a></div>';
		}
		else {
			echo '<div><br /><br />Error in generating Screen of <b><i>'.current($files).'</i></b></div>';
		}
		next($files);
	}
	echo '<div><br /><br /><b><a href="'.$PHP_SELF.'">Back</a></b><br /><br />'.CREDITS.'</div>';
	include_once(TEMPLATE_DIR.'footer.php');
	exit();
}
else if (isset($_POST['generate']) && isset($_POST['video']) == '') {
	echo '<div><br /><br /><b><i>No video selected for generate Screen</i><br /><br /><a href="'.$PHP_SELF.'">Back</a></b><br />'.CREDITS.'</div>';
	include_once(TEMPLATE_DIR.'footer.php');
	exit();
}
else {	
	if ($_COOKIE[$user] == md5($pass)) {
		echo '<form method="post"><center style="padding-left:600px;"><b><small class="rev-dev">Hi, '.$user.'  - <a href="'.$PHP_SELF.'?CPanel">CPanel</a> <input type="submit" name="logout" style="font-size:smaller" value="Logout" /></b></small></center></form>';
	}
	else {
		echo '<form method="post"><center style="padding-left:600px;">Hi, Guest<input type="submit" name="login" style="font-size:smaller" value="Login" /></center></form>';
	}	
?>
<form method="post" enctype="multipart/form-data" name="generate" action="<?php echo $PHP_SELF; ?>">
<table align="center" border="0" cellspacing="2">
<tr>
<td align="right"><span onMouseOver="document.getElementById('video_file').style.display='block'" onMouseOut="document.getElementById('video_file').style.display='none'" style="cursor:help">Video File</span> : </td><td>
<?php
$exts = array('.3gp', '.3g2', '.asf', '.avi', '.dat', '.divx', '.dsm', '.evo', '.flv', '.m1v', '.m2ts', '.m2v', '.m4a', '.mj2', '.mjpg', '.mjpeg', '.mkv', '.mov', '.moov', '.mp4', '.mpg', '.mpeg', '.mpv', '.nut', '.ogg', '.ogm', '.qt', '.swf', '.ts', '.vob', '.wmv', '.xvid');
$files = array();
$files = fileList($options['download_dir']);
echo '<select id="video" name="video">';
reset($files);
while (key($files) !== NULL) {
	echo '<option value="' . current($files) . '">' . current($files) . '</option>';
	next($files);
}
echo '</select>'
?> <input type="checkbox" id="all" name="all" value="true" /> Generate all.</td>
</tr>

<?php
if($mtn['showmtnconfig'] == true) {
?>

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

<?php
if($mtn['showmtntext'] == true) {
?>

<tr>
<td align="right"><span onMouseOver="document.getElementById('text').style.display='block'" onMouseOut="document.getElementById('text').style.display='none'" style="cursor:help">Text</span> : </td><td><input type="text" id="mtn_T" name="mtn_T" size="25" /></td>
</tr>

<tr>
<td align="right">Output Suffix : </td><td><input type="text" id="mtn_o" name="mtn_o" size="25" /></td>
</tr>

<?php
}
?>

<tr>
<td align="right">Background Color : </td><td><input class="color" id="mtn_k" name="mtn_k" size="5" /></td>
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
<td align="right">Video Info : </td><td><input type="checkbox" id="mtn_i"  name="mtn_i" value="true" />On &nbsp; <select id="mtn_Ts" name="mtn_Ts"><option value="8">8</option>
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
																																																																				   print '<option value="'.current($fonts).'"'.'>'.substr(current($fonts), 0, -4).'</option>';
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

<?php
}
?>

<tr>
<td></td>
</tr>

<tr>
<td></td>
</tr>

<tr>
<td colspan=2><center><input type="submit" id="generate" name="generate" value="Generate" disabled="disabled" /></center></td>
</tr>

</table>
<center>
<span id="video_file" style="display:none">File should be supported:<br />.3gp, .3g2, asf, avi, dat, divx, dsm, evo, flv, M1V, m2ts, m2v, m4a, MJ2, moov mjpg. mjpeg. mkv. mov .. mp4,. mpg,. mpeg,. mpv. nut. ogg. ogm. qt. swf. ts. vob,. wmv,. xvid.</span>
<span id="width" style="display:none">Width of output image; 0:column * movie width</span>
<span id="minimum_height" style="display:none">Minimum height of each shot; will reduce # of column to fit</span>
<span id="text" style="display:none">Add text above output image</span>
<span id="edge" style="display:none">Gap between each shot</span>
<span id="step" style="display:none">Cut movie and thumbnails not more than the specified seconds</span>
<span id="individual_shots" style="display:none">Save individual shots too</span>
<span id="save_info" style="display:none">Save info text to a file .txt</span>
</center>
</form>

<?php
}
?>