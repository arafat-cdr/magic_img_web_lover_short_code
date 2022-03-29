<?php

/*
Plugin Name: Magic Img Web Lover Short Codes 
Plugin URI: https://simplerscript.com/
Description: show Banner In specific date range Using Short Code <strong> [magic_img_web_lover use_for='col_1' width='200px' height='200px' class='my_test_class'] </strong>
Author: Yeasir Arafat (arafat.dml@gmail.com | fiverr.com/web_lover)
Author URI: https://www.fiverr.com/web_lover
Version: 1.0
*/

# Set up some Settings Here
global $table_name;
global $form_heading;
global $wpdb;
global $table_heading;
global $web_lover_page_link;
global $web_lover_data_add_link;
global $add_data_link;
global $edit_data_name;
global $delete_data_name;
global $nonce_name;
global $nonce_verify_name;


$table_name              = $wpdb->prefix . 'magic_img_web_lover_short_codes';
$table_heading           = "My Saved Data";
$web_lover_page_link     = "magic-img-weblover-plugin-start";
$web_lover_data_add_link = "magic_img_weblover_add_new_data";
$add_data_link           = "?page={$web_lover_page_link}&action={$web_lover_data_add_link}";

# ----------------------------------------------
# This edit_data_name and delete_data_name
# is hard coded in many places
# into the data_table.php page
# ----------------------------------------------

$edit_data_name   = "magic_img_weblover_edit_data";
$delete_data_name = "magic_img_weblover_delete_data";

# form Heading
$form_heading = "Magic Img Data Form";


# End set up the settings

# Nonce name
# ---------------------

$nonce_name         = "web_lover_nonce";
$nonce_verify_name  = "web_lover_secret_verify";

# Nonce End
#-----------



# ------------------------------------
# Add and Edit Data Field name and type
# This will use to dynamically create the 
# add and edit forms
# ---------------------------------------
global $add_edit_field_name_arr;

$add_edit_field_name_arr = array(
    array(
        'name' => 'use_for',
        'type' => 'string',
    ),

    array(
        'name' => 'img_url',
        'type' => 'string',
    ),

    array(
        'name' => 'action_url',
        'type' => 'string',
    ),
    array(
        'name' => 'start_date',
        'type' => 'date_range', // date, date_time, date_range
    ),
    array(
        'name' => 'end_date',
        'type' => 'date_range', // date, date_time, date_range
    ),
    array(
        'name' => 'img_place_holder',
        'type' => 'text',
    ),
    array(
        'name' => 'created_at',
        'type' => 'my_sql_date_time',
    ),

);


# End Add and Edit data Field name
# ------------------------------------
function web_lover_form_input($name, $value = '', $is_required = '', $is_label_name = '', $is_place_holder = '')
{
    # we will store the html here
    $input = '';
    $name_field  = "name='".$name."'"; 
    $value       = "value ='". $value . "'";
    $label_for   = "for = '".$name."'";
    
    # label Name
    $label_name  = str_replace("_", " ", $name);
    if( $is_label_name ){
        $label_name  = $is_label_name;
    }

    
    # place_holder
    $place_holder = "placeholder ='". str_replace("_", " ", $name) . "'";

    if($is_place_holder){
        $place_holder = "placeholder ='". $is_place_holder . "'";
    }

    # require
    $required = "";
    if( $is_required ){
        $required = "required='true'";
    }
    
    $input .=  "<label $label_for><strong>$label_name<strong></label> \n";
    $input .= "<input type='text' $name_field  $place_holder $value $required> \n";

    return $input;

}


function web_lover_form_date_range($name, $value = '', $is_required = '', $is_label_name = '', $is_place_holder = '')
{

    # we will store the html here
    $input = '';
    $name_field  = "name='".$name."'"; 
    $value       = "value ='". $value . "'";
    $label_for   = "for = '".$name."'";
    
    # label Name
    $label_name  = str_replace("_", " ", $name);
    if( $is_label_name ){
        $label_name  = $is_label_name;
    }

    
    # place_holder
    $place_holder = "placeholder ='". str_replace("_", " ", $name) . "'";

    if($is_place_holder){
        $place_holder = "placeholder ='". $is_place_holder . "'";
    }

    # require
    $required = "";
    if( $is_required ){
        $required = "required='true'";
    }

    $class = "class='date_range_picker'";
    
    $input .=   "<label $label_for><strong>$label_name<strong></label> \n";
    $input .=  "<input type='text' $name_field  $class $place_holder $value $required> \n";

    return $input;

}


function web_lover_form_textarea( $name, $value = '', $is_required = '', $is_label_name = '', $is_place_holder = '' )
{
    # we will store the html here
    $input = '';
    $name_field  = "name='".$name."'"; 
    if($value){
        $value       = $value;
    }else{
        $value = NULL;
    }
    
    $label_for   = "for = '".$name."'";
    
    # label Name
    $label_name  = str_replace("_", " ", $name);
    if( $is_label_name ){
        $label_name  = $is_label_name;
    }

    # require
    $required = "";
    if( $is_required ){
        $required = "required='true'";
    }

    
    # place_holder
    $place_holder = "placeholder ='". str_replace("_", " ", $name) . "'";

    if($is_place_holder){
        $place_holder = "placeholder ='". $is_place_holder . "'";
    }

    $input .=   "<label $label_for><strong>$label_name<strong></label> \n";
    $input .= "<textarea  $name_field  $place_holder style='height:200px' $required>$value</textarea> \n";

    return $input;

}

function web_lover_form_select($name, $options = [], $value = '', $is_required = '', $is_label_name = '')
{

    # we will store the html here
    $input = '';
    $name_field  = "name='".$name."'"; 
    $value       = "value ='". $value . "'";
    $label_for   = "for = '".$name."'";
    
    # label Name
    $label_name  = str_replace("_", " ", $name);
    if( $is_label_name ){
        $label_name  = $is_label_name;
    }


    # require
    $required = "";
    if( $is_required ){
        $required = "required='true'";
    }
    
    $input .=  "<label $label_for><strong>$label_name<strong></label> \n";
    $input .= "<select $name_field $required>\n";
    $input .= "<option val=''>--select one--</option>\n";

    if($options){
        foreach($options as $k => $option){
            if($k == $value){
                $input .= "<option val='".$k."' selected>".$option."</option>\n";
            }else{
                $input .= "<option val='".$k."'>".$option."</option>\n";  
            }
           
        }
    }
    $input .= "</select> \n";

    return $input;

}

function web_lover_form_radio($name, $value = '', $is_required = '', $is_label_name = '')
{

    # we will store the html here
    $input = '';
    $name_field  = "name='".$name."'";
    $value       = "value ='". $value . "'";
    $label_for   = "for = '".$name."'";
    
    # label Name
    $label_name  = str_replace("_", " ", $name);
    if( $is_label_name ){
        $label_name  = $is_label_name;
    }

    # require
    $required = "";
    if( $is_required ){
        $required = "required='true'";
    }
    
    $input .=   "<label $label_for><strong>$label_name<strong></label> \n";
    $input .=  "<input type='radio' $name_field $value $required> \n";

    return $input;
}

function web_lover_form_checkbox($name, $value = '', $is_required = '', $is_label_name = '')
{
    # we will store the html here
    $input = '';
    $name_field  = "name='".$name."'";
    $value       = "value ='". $value . "'";
    $label_for   = "for = '".$name."'";
    
    # label Name
    $label_name  = str_replace("_", " ", $name);
    if( $is_label_name ){
        $label_name  = $is_label_name;
    }

    # require
    $required = "";
    if( $is_required ){
        $required = "required='true'";
    }
    
    $input .=   "<label $label_for><strong>$label_name<strong></label> \n";
    $input .=  "<input type='checkbox' $name_field $value $required> \n";

    return $input;
}

# Create Dynamic Form function
# ------------------------------------



# End Create Dynamic Form function


# Step 1: Creating the Require table

global $magic_img_web_lover_version;
$magic_img_web_lover_version = '1.0';

function magic_img_web_lover_short_code_install() {
    global $wpdb;
    global $magic_img_web_lover_version;
    global $table_name;
    
    $charset_collate = $wpdb->get_charset_collate();
    $db_name = $wpdb->dbname;

    $sql = "CREATE TABLE `$db_name`.`$table_name` ( `id` INT NOT NULL AUTO_INCREMENT, `use_for` VARCHAR(255) NULL DEFAULT NULL , `img_url` VARCHAR(255) NULL DEFAULT NULL , `action_url` VARCHAR(255) NULL DEFAULT NULL , `start_date` VARCHAR(255) NULL DEFAULT NULL , `end_date` VARCHAR(255) NULL DEFAULT NULL , `img_place_holder` TEXT NULL DEFAULT NULL , `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY id (id) ) ENGINE = InnoDB";

    // echo "$db_name <br/> $charset_collate <br/>";
    // echo $sql;

    // die();

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( 'magic_img_web_lover_version', $magic_img_web_lover_version );
}


register_activation_hook( __FILE__, 'magic_img_web_lover_short_code_install' );

# End of Step 1: Creating the Require table


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!function_exists('pr')){
    function pr($data, $die = false){
        echo "<pre>";
        print_r($data);
        echo "</pre>";

        if($die){
            die();
        }
    }
}



if( !function_exists('web_lover_flash_msg') ){

    function web_lover_flash_msg($res){

        global $web_lover_page_link;

        if($res){
          $web_lover_msg = "<span style='color: green;'> Data Operation Successfull </span>";
        }else{
          $web_lover_msg = "<span style='color: red;'> Data Operation failed ! </span>";
        }

        $_SESSION['web_lover_msg'] = $web_lover_msg;

        # url
        $url = admin_url("admin.php?page=$web_lover_page_link");
        echo "<script>window.location.href='".$url."'</script>";
        exit();
    }
}
 
function web_lover_menu_creation(){
    #  add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function = '', $icon_url = '', $position = null )

    global $web_lover_page_link;

    add_menu_page( 'Magic Img WebLover Shortcodes', 'Magic Img WebLover Shortcodes Data', 'edit_pages', "$web_lover_page_link", 'web_lover_plugin_init' );
}
add_action('admin_menu', 'web_lover_menu_creation');

 
function web_lover_plugin_init(){

    # Flash Method ...
    if(isset($_SESSION['web_lover_msg'])){

      $flash_msg = $_SESSION['web_lover_msg'];

      echo <<<EOD
      "<div class='updated notice' style='margin-left: 18%; margin-right: 15%; text-align: center;'>
    <h3> <strong> $flash_msg </strong> </h3>
</div>"
EOD;

      unset($_SESSION['web_lover_msg']);
    }

    include(__DIR__."/includes/data_table.php");

} // end of a function


# ------------------------------------------
#     ---- let's make our magic ShortCode
# ------------------------------------------

function magic_img_web_lover_shortcode( $atts = [], $content = null, $tag = '' )
{

    global $wpdb;
    global $table_name;

    $my_atts  = shortcode_atts(
            array(
                'use_for'   => '',
                'width'     => '',
                'height'    => '',
                'class'     => '',
            ), $atts, $tag
        );

    $use_for = $my_atts["use_for"];

    if( $use_for ){

        $today_date = date("m/d/Y");
        $img_url    = '';
        $img_action_url = '';
        $img_place_holder = '';

        $res = $wpdb->get_results("SELECT * FROM $table_name WHERE use_for='$use_for' AND '$today_date' BETWEEN start_date AND end_date ");

        if($res){
            $res = $res[0];
            $img_url            = "src='".esc_url($res->img_url)."' ";
            $img_action_url     = "data-actionurl='".esc_url($res->action_url)."' ";
            $img_place_holder   = "alt='".esc_html($res->img_place_holder)."' ";
            $a_href             = "href='".esc_url($res->action_url)."'"; 

            # Set the width, Height And Class
            $width = '';
            $height = '';
            $class = '';
            if( $my_atts["width"] ){
                $width = "width='".esc_html($my_atts["width"])."'";
            }
            if( $my_atts["height"] ){
                $height = "height='".esc_html($my_atts["height"])."'";
            }
            if( $my_atts["class"] ){
                $class = "class='".esc_html($my_atts["class"])."'";
            }

            # End Set the width, Height And Class


            return "<a $a_href > <img $img_url $img_action_url $img_place_holder $width $height $class> </a>";
        }

        return '';

    }
  

}

function magic_img_web_lover_init() {
    add_shortcode( 'magic_img_web_lover', 'magic_img_web_lover_shortcode' );
}
 
add_action( 'init', 'magic_img_web_lover_init' );

# ------------------------------------------
#  End   ---- let's make our magic ShortCode
# ------------------------------------------
