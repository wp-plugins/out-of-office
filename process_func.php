<?php
////// this file contains process functions///////////////

function ooo_update_post_values_hook()
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
	$ooo_curr_var = bt_get_my_options();
	$ooo_tmp_array = bt_get_form_default_vals();
	
	foreach($ooo_curr_var as $key=>$value)
	{
		switch($key)
		{
		case "ooo_form_show":
			$ooo_tmp_array["ooo_form_show"] = ($_POST["ooo_form_show"]=="1")?"1":"0";
		break;
		case "ooo_values":
			foreach($value as $key_base=>$base_val)
			{
				if($key_base=="ooo_online_status")
				{
						$ooo_tmp_array["ooo_values"]["ooo_online_status"]["ooo_online_stat"] = (isset($_POST["ooo_online_stat"]))?"1":"0";
						$ooo_tmp_array["ooo_values"]["ooo_online_status"]["ooo_alternative_text_on"] = esc_attr($_POST["ooo_alternative_text_on"]);
						$ooo_tmp_array["ooo_values"]["ooo_online_status"]["ooo_alternative_text_off"] = esc_attr($_POST["ooo_alternative_text_off"]);
				}
				else
				{
					$ooo_tmp_array["ooo_values"][$key_base]= esc_attr($_POST[$key_base]);
				}
			}
		break;
		case "ooo_bools":
			foreach($value as $key_base=>$base_val)
			{
			$ooo_tmp_array["ooo_bools"][$key_base] = (isset($_POST[$key_base]))?"1":"0";
			}
		break;
		}
	}
	
	$ooo_new_args = wp_parse_args( $ooo_tmp_array, $ooo_curr_var);
	
	bt_update_my_options($ooo_new_args);
}


?>