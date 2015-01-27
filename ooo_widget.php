<?php

////////////////////////////////////START WIDGET////////////////////
class ooo_widget_plugin extends WP_Widget 
{
	// constructor
	function ooo_widget_plugin() 
	{
		parent::WP_Widget(false, $name = __('Out Of Office', 'ooo_widget_plugin') );
	}

	// widget form creation
	function form($instance) 
	{	
	?>
<div class="wrap">
<?php
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
    <table class="ooo-form-table">
        <tr valign="top">
        <td><?php   
		echo ooo_get_form_unit('ooo_form_show', 'ooo_form_show', $ooo_tmp_values['ooo_form_show']); ?></td>
		<td></td>
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
		echo __(implode(' ', $ooo_tmp1), "out-of-office"); ?>
		</label>
		
		
		<?php //insert function 
			if($key=="ooo_online_status")
			{
			echo "<br>" . ooo_get_form_unit("ooo_online_stat", "ooo_online_stat", $value["ooo_online_stat"]) . "<br><br>";
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
    <input type="hidden" name="submitted" value="1" />
</div>
<?php 
	}

	function update($new_instance, $old_instance) 
	{
	$ooo_curr_var = bt_get_my_options();
	$ooo_tmp_array = bt_get_form_default_vals();
	
	foreach($ooo_curr_var as $key=>$value)
	{
		switch($key)
		{
		case "ooo_form_show":
			$ooo_tmp_array["ooo_form_show"] = ($new_instance["ooo_form_show"]=="1")?"1":"0";
		break;
		case "ooo_values":
			foreach($value as $key_base=>$base_val)
			{
				if($key_base=="ooo_online_status")
				{
					if(isset($new_instance["ooo_online_stat"]))
					{
					$ooo_tmp_bool=($new_instance["ooo_online_stat"]=="1")?"1":"0";
					}
					else
					{
					$ooo_tmp_bool="0";
					}
						
						$ooo_tmp_array["ooo_values"]["ooo_online_status"]["ooo_online_stat"] = $ooo_tmp_bool;
						$ooo_tmp_array["ooo_values"]["ooo_online_status"]["ooo_alternative_text_on"] = esc_attr($new_instance["ooo_alternative_text_on"]);
						$ooo_tmp_array["ooo_values"]["ooo_online_status"]["ooo_alternative_text_off"] = esc_attr($new_instance["ooo_alternative_text_off"]);
				}
				else
				{
					$ooo_tmp_array["ooo_values"][$key_base]= esc_attr($new_instance[$key_base]);
				}
			}
		break;
		case "ooo_bools":
			foreach($value as $key_base=>$base_val)
			{
			$ooo_tmp_array["ooo_values"][$key_base] = (isset($new_instance[$key_base]))?"1":"0";
			}
		break;
		}
	}
	
	/*
	$ooo_curr_var = bt_get_my_options();
	$ooo_tmp_array = array();
	foreach($ooo_curr_var as $key=>$child)
	{
		if((strpos($key, "bool")!==false)||($key=="ooo_form_show")||($key=="ooo_online_status"))
		{
			if(isset($new_instance[$key]))
			{
			$ooo_tmp_array[$key] = ($new_instance[$key]=="1")?"1":"0";
			}
			else
			{
			$ooo_tmp_array[$key] = "0";
			}
		}
		else
		{
		$ooo_tmp_array[$key] = esc_attr($new_instance[$key]);
		}
	}
	*/
	
	$ooo_new_args = wp_parse_args($ooo_tmp_array, $ooo_curr_var);
	
	//bt_update_my_options($ooo_new_args);
	return $ooo_new_args;
	//return $ooo_tmp_array;
	}

	// widget display
	function widget($args, $instance) 
	{
	/*
	if(has_filter( 'ooo_plugin_display_hook', 'ooo_display_widget'))
	{
	$ooo_wid_comp= apply_filter('ooo_plugin_display_hook', "welcome", "go away");
	echo $ooo_wid_comp;
	}*/
	
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
				ooo_get_unit_html_front($key, $c_val['ooo_online_stat'], array($c_val['ooo_alternative_text_on'], $c_val['ooo_alternative_text_off']))
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
		
	echo $return_val;
	}
	/*
	$ooo_saved_var_array = bt_get_my_options();

	if($ooo_saved_var_array["ooo_form_show"])
	{
	wp_enqueue_style("ooo_css_script");
	wp_enqueue_style("ooo_css_script2");
	
	$ooo_values = $ooo_saved_var_array['ooo_values'];
	$ooo_bools = $ooo_saved_var_array['ooo_bools'];
	$ooo_alt_values = $ooo_saved_var_array['ooo_custom_vars'];
	
	$return_val = "";
	$return_val .= "<table class='ooo-form-table' >";
		
		foreach($ooo_values as $key=>$c_val)
		{
			if($ooo_bools[$key . "_bool"]=="1")
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
		
		foreach($ooo_alt_values as $key =>$val1)
		{
			$return_val .= '<tr ><td>' . ooo_get_unit_html_front($key, $val1) . '</td></tr>';
		}
		
		$return_val .='</table>';
		
	echo  $return_val;
	}*/
	}
	
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("ooo_widget_plugin");'));
////////////////////////////////////END WIDGET////////////////////


?>