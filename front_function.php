<?php
//front facing functions

function ooo_get_unit_html_front($key1, $value1, $val_override="")
{
	if($key1=="ooo_online_status")
	{
		$ooo_img =($value1=="1")? "ooo_online_class":"ooo_offline_class";
		$ooo_msg =($value1=="1")?"Online":"Offline";
		
		if(is_array($val_override))
		{
			if((count($val_override)>1)&&($val_override[0]!="")&&($val_override[1]!=""))
			{
			$ooo_msg =($value1=="1")?$val_override[0]:$val_override[1];
			}
		}
		
		return "<div ><p align='center' class='$ooo_img'  >" . __($ooo_msg, "out-of-office") . "</p></div>";
	}
	else
	{
		return "<p >" . __($value1 , "out-of-office") . "</p>";
	}
}

function ooo_get_form_unit($key, $name, $value)
{
/*
$ooo_default_vals = array(
"ooo_form_show"=>"1",
	
	"ooo_values"=>array(
	"ooo_title_form"=>"",
	"ooo_description"=>"",
	"ooo_online_status"=>array("ooo_online_stat"=>"0", "ooo_alternative_text_on" =>"", "ooo_alternative_text_off" =>""),
	"ooo_post_message"=>"")
	,
	"ooo_bools"=>array("ooo_title_form_bool"=>"1",
	"ooo_description_bool"=>"1",
	"ooo_online_status_bool"=>"1",
	"ooo_post_message_bool"=>"1")
	);
	*/
	switch($key)
	{
	case "ooo_form_show":
		$yes = $no = "";
		if($value=="1")
		{
		$yes = "checked";$no ="";
		}
		else
		{
		$yes = "";$no ="checked";
		}
		
		$ooo_input = __("Display all Widget? ", "out-of-office") .  '<input type="radio" name="' . $key . '"  ' . $yes . '  value="1" />' . __("yes", "out-of-office") . '<input type="radio" name="'. $key . '" ' . $no . ' value="0" />' . __("no", "out-of-office");
		return $ooo_input;
	break;
	
	case "ooo_title_form":
	case "ooo_post_message":
	case "ooo_alternative_text_on":
	case "ooo_alternative_text_off":
		return '<input type="text" name="' . $name . '" value="' . $value . '"/>';
	break;
	
	case "ooo_description":
		return '<textarea name="' . $name. '" >' . esc_attr($value) . '</textarea>';
	break;
	case "ooo_online_stat":
	$var_tmp = ($value=="1")?"checked":"";
		return __("Are you online?", "out-of-office") . ' <input type="checkbox" name="' . $key . '" value="1" ' . $var_tmp . ' >';
	break;
	
	}
}

function ooo_about_page()
{
?>
	<div class="wrap" >
		<h3>About</h3>
		<div class="of-caption" >
		Out-of-Office is our rudimentary online/offline indicator.
		<br><br>
		With this plugin/widget you can:
		<br>
		
		<ul>
		<li>
		set your status online,</li>
		<li>
		state a title</li>
		<li>state a description</li>
		<li>show the indicator</li>
		<li>and show a post message.</li>
		</ul>
		</div>
		
		<h3>Support Us</h3>
		<div class="of-caption" >
		Show your support for what we hope is a usefull product.<br>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="E2ZFXGBX9Z2PQ">
<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form>
<br>
<br>
<p>for more information visit us at<br><a href="http://codemarker.co.uk/codemarker/out-of-office/" >www.codemarker.co.uk/codemarker/out-of-office/</a>

		</div>
	
		
		<h3>Widget</h3>
		<div class="of-caption">
		Once installed, Out-of-Office is available as a widget. The same options are available on the widget screen as there are in the 'OOO settings' screen.
		</div>
		
		<h3>Shortcode</h3>
		<div class="of-caption" >
		Shortcodes can be used in pages, posts and created content.<br>
		To use the shortcode, place <h4>[out_of_office]</h4> into your content.
		<br><br>
		The shortcode is fairly simple right now but will be adding more advanced features and functionality in the near future.
		</div>
		
		<h3>Hooks</h3>
		<div class="of-caption" >
		hooks are placed within the php code. They allow for greater control of where the plugin is displayed.
		<br><br>
		eg
		<br>
		if((function_exists('out_of_office'))&&(is_front_page()))
		<br>{
		<br>do_action('out_of_office');
		<br>}
		
		</div>
		
		<h3>Styling</h3>
		<div class="of-caption" >
		For styling, Out-of-Office has 2 files to edit:
		<ul>
		<li>
		user_styles.css in the CSS folder &,</li>
		<li>
		my_jquery.js in the 'script' folder.</li>
		</ul>
		
		<br>
		feel free to edit the content of these files.
		</div>
		
	</div>

<?php
}

function ooo_settings_page() 
{
?>
<div class="wrap">
<h2><?php _e("Out of Office", "out-of-office"); ?></h2>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <?php settings_fields( 'ooo-settings-group' ); ?>
    <?php do_settings_sections('ooo-settings-group' ); 
	
	$ooo_tmp_values = bt_get_my_options();
	
	if(count($ooo_tmp_values)>0)
	{
	$ooo_vals = $ooo_tmp_values['ooo_values'];
	$ooo_vals_bools = $ooo_tmp_values['ooo_bools'];
	
	//$ooo_tmp_values = array_reverse($ooo_tmp_values, true);
	//$ooo_tmp_chunks = array_chunk($ooo_tmp_values, 6, true);
	//$ooo_final_array = array_reverse($ooo_tmp_chunks[1], true);
	
	}
	?>
	
	<table>
	<tr>
	<td>
	<table>
	<tr valign="top">
        <td width="600px"  style="padding: 15px" >
		<p>
		Out-of-Office is a plugin that shows clients/visitors whether you're online or offline.
		</p>
		<p>
		You can have a title description, status (online/offline or a wording of your choosing) & a post message.
		</p>
		<p>
		Each one can be toggled on/off so that it is displayed or its hidden.
		</p>
		</td>
		</tr>
	</table>
	
	
    <table width="100%" class="ooo-form-table" style="padding:20px; padding-top:50px; background-color: white;"  >
        <tr valign="top">
        <td  ><?php   
		echo ooo_get_form_unit('ooo_form_show', 'ooo_form_show', $ooo_tmp_values['ooo_form_show']); ?></td>
		<td  ></td>
		<td ></td>
		</tr>
		<?php
		foreach($ooo_vals as $key=>$value)
		{
		?>
		<tr>
		<td>
		
		<label>
		<?php 
		$ooo_tmp1 = explode('_', $key);
		echo __(implode(' ', $ooo_tmp1) . ": ", "out-of-office"); ?>
		</label>
		</td>
		<td>
		<?php //insert function 
			if($key=="ooo_online_status")
			{
			echo ooo_get_form_unit("ooo_online_stat", "ooo_online_stat", $value["ooo_online_stat"]) . "<br>";
			echo __("alternative 'On' status: ", "out-of-office") . ooo_get_form_unit("ooo_alternative_text_on", "ooo_alternative_text_on", $value["ooo_alternative_text_on"]) . "<br>";
			echo __("alternative 'Off' status: ", "out-of-office") . ooo_get_form_unit("ooo_alternative_text_off", "ooo_alternative_text_off", $value["ooo_alternative_text_off"]);
			}
			else
			{
			echo ooo_get_form_unit($key, $key, $value);
			}
		?>
		</td>
		<td>
		<input type="checkbox" name="<?php echo $key."_bool" ?>" value="1" <?php echo (($ooo_vals_bools[$key."_bool"])=="1")?"checked":""; ?>  >
		</td>
		</tr>

		<?php
		}
		?>
		
		
		
    </table>
	</td>
	<td width="40%" style="background-color:#FAFCFC;" >
	<table >
			<tr>
        <td width="600px" style="padding: 15px" >
		<p>
		We are a 2-man team. We love to code and we have putting many hours making sure our work is the best it can be.
		For this, please consider donating something to help us carry on our work and show that the work is appreciated.
		</p>
		<br>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="E2ZFXGBX9Z2PQ">
<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form>
		<br><br>
		<p>
		If you have any feedback or enquiries, we are always here to help the best we can.<br>
		Please email us at <a href="mailto:admin@codemarker.co.uk?Subject=Enquiry" target="_top">admin@codemarker.co.uk</a>
		<br><br>
		To quote Abu Bakr: "there is no wealth like knowledge, no poverty like ignorance"<br>
		So happy coding and we wish you a rich existence.
		</p>
		</td>
		</tr>
	</table>
	</td>
	</tr>
	</table>
	
    <input type="hidden" name="submitted" value="1" />
    <?php submit_button(); ?>

</form>
</div>
<?php 

}

?>