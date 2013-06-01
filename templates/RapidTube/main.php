<?php
if (!defined('RAPIDLEECH')) {
	require_once("index.html");
	exit;
}
?>
<table align="center">
<tbody>
<tr>
<td valign="top">
<table width="100%"  border="0">
<tr>
<td valign="top">
<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="131" height="100%">

</td>
</tr>
<tr>
<td>

</tr>
<tr>

</div>
</div>
<br />


</td>
</tr>
</table>
</td>
</tr>
</table></td>
<td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="1">
<tbody>
<tr>

<body>	

</ul>
  </div>
</div>
</tr>
</tbody>
</table>
<table id="tb_content">
<tbody>
<tr>
<ul class="nav nav-list">

	 <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-download {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-download .form-download-heading,
      .form-download .checkbox {
        margin-bottom: 10px;
      }
      .form-download input[type="text"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>

<td align="center">
<form id="form" class="form-download" action="<?php echo $PHP_SELF; ?>" name="transload" method="post"<?php if ($options['new_window']) { echo ' target="_blank"'; } ?>>
<h1 class="form-download-heading"><?php echo lang(390); ?></h1>
<table class="tab-content" id="tb1" cellspacing="5" width="100%">
<tbody>
<tr>
<td align="left">
<b>Youtube link:</b><br />&nbsp;<input type="text" name="link" id="link" size="50" /><br /><br />

</td>
<td align="center">

<div style="text-align: center;">
<input id="transload-button" class="btn btn-success" value="<?php echo lang(391); ?>" type="<?php echo ($options['new_window'] && $options['new_window_js']) ? 'button" onclick="new_transload_window();' : 'submit'; ?>" />
</form>
</td>
</tr>

<tr>

</td>
</tr>
<tr>


