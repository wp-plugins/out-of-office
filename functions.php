<?php
//Out-of-Office functions


////////////////START options functions///////////////
function bt_get_my_options()
	{
		$ooo_def_vals = get_option('ooo_widget_values');
		$ooo_tmp = unserialize($ooo_def_vals);
		if($ooo_def_vals=="")
		{
		return bt_get_form_default_vals();
		}
		else
		{
		return $ooo_def_vals;
		}
	}

function bt_update_my_options($vals_array)
	{
		$ser = serialize($vals_array);
		update_option('ooo_widget_values', $vals_array);
	}

function bt_add_my_options()
	{
	$ooo_default_vals = bt_get_form_default_vals();
	$ser = serialize($ooo_default_vals);
	add_option('ooo_widget_values', $ooo_default_vals);
	}

function bt_get_form_default_vals()
	{
	$ooo_default_vals = array("ooo_form_show"=>"1",
	
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
	
	return $ooo_default_vals;
	}
///////////////////////END of options functions/////////////////

function ooo_display_widget_tab()
{
$ooo_saved_var_array = bt_get_my_options();

	if($ooo_saved_var_array["ooo_form_show"]=="1")
	{
	
	wp_enqueue_style("ooo_css_script");
	wp_enqueue_style("ooo_css_script2");
	
	$ooo_vals = $ooo_saved_var_array['ooo_values'];
	$ooo_vals_bools = $ooo_saved_var_array['ooo_bools'];
	
	$return_val = "";
	$return_val .= "<table class='ooo-form-table' >";
		
		foreach($ooo_vals as $key=>$c_val)
		{
			if($ooo_vals_bools[$key . "_bool"]=="1")
			{
				if(($c_val!="")&&($key=="ooo_title_form"))
				{
				$return_val .= '<tr ><td><h2>' . ooo_get_unit_html_front($key, $c_val) . '</h2></td></tr>';
				continue;
				}
				
				if($key=="ooo_online_status")
				{
				$return_val .= '<tr ><td>' . 
				ooo_get_unit_html_front($key, $c_val['ooo_online_stat'], array($c_val['ooo_alternative_text_on'], $c_val['ooo_alternative_text_off']) )
				. '</td></tr>';
				
				continue;
				}
				
				if($c_val!="")
				{
				$return_val .= '<tr ><td>' . ooo_get_unit_html_front($key, $c_val) . '</td></tr>';
				}
			}
		}
		
		
		$return_val .='</table>';
		
	return  $return_val;
	}
}

function ooo_display_widget($on="", $off="")
{
$ooo_saved_var_array = bt_get_my_options();

	if($ooo_saved_var_array["ooo_form_show"])
	{
	wp_enqueue_style("ooo_css_script");
	wp_enqueue_style("ooo_css_script2");
	$ooo_tmp_values = array_reverse($ooo_saved_var_array, true);
	$ooo_tmp_chunks = array_chunk($ooo_tmp_values, 6, true);
	$ooo_final_array = array_reverse($ooo_tmp_chunks[1], true);
	$return_val = "";
	$return_val .= "<table class='ooo-form-table' ><tr><td>welcome!!!!!</td></tr>";
		
		foreach($ooo_final_array as $key=>$c_val)
		{
			if($ooo_tmp_values[$key . "_bool"]=="1")
			{
				if(($c_val!="")&&($key=="ooo_title_form"))
				{
				$return_val .= '<tr ><td><h2>' . ooo_get_unit_html_front($key, $c_val) . '</h2></td></tr>';
				continue;
				}
				
				if($c_val!="")
				{
				$return_val .= '<tr ><td>' . ooo_get_unit_html_front($key, $c_val) . '</td></tr>';
				}
			}
		}
		$return_val .='</table>';
	return $return_val;
	}
}



?>