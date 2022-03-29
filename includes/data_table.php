<?php include(__DIR__."/style.php"); ?>

<?php
/*
global $wpdb;

$table_name = "wp_magic_img_web_lover_short_codes";

$data_array = array (
    'use_for' => 'test',
    'img_url' => 'test',
    'action_url' => 'test',
    'valid_date_range' => "03/11/2022 - 03/11/2022",
    'img_place_holder' => 'test'
);

$res = $wpdb->insert($table_name, $data_array);

var_dump($res); die();

*/
global $web_lover_page_link;
global $web_lover_data_add_link;
global $add_data_link;
global $action_name;
global $data_primary_id;

global $nonce_name;
global $nonce_verify_name;

global $edit_data_name;
global $delete_data_name;
global $table_heading;
global $form_heading;
global $add_edit_field_name_arr;

# custom Code For Fixing edit date
$start_date = date("m/d/Y");
$end_date  = date("m/d/Y");
# End custom Code For fixing edit date

?>

<div>

  <div style="margin-bottom: 20px; min-width: 500px;">
    <a href="<?php echo $add_data_link; ?>">
      <button  style="cursor:pointer; margin-top: 20px; margin-bottom: 10px; color: green;">Add New </button>
    </a>
    <h3 class='text-info' style="padding-bottom: 20px;border-bottom: 1px dotted black;">
      <?php 
        echo $table_heading; 
      ?>
    </h3>
  </div>

  <table id="web_lover_table">
   
    <thead>
      <?php
      
      #------------------------------------------
      # Table Header Dynamically Generation
      #------------------------------------------

     /* if( $add_edit_field_name_arr ){
        foreach($add_edit_field_name_arr as $v){
          $name = ucwords( str_replace("_", " ", $v["name"]) );
          echo "<th>$name</th>";
        }
      }*/

      #------------------------------------------
      # End Table  Header Dynamically Generation
      #------------------------------------------

      ?>

      <th>Use For</th>
      <th>Img</th>
      <th>Img Url</th>
      <th>Action Url</th>
      <th>Valid Date Range</th>
      <th>Img Place Holder</th>
      <th>Created At</th>

      <th>Actions</th>
    </thead>

    <tbody>
      
      <!-- loop data start -->
      <?php 

      global $wpdb;
      global $table_name;

      $res = $wpdb->get_results( "SELECT * FROM $table_name", OBJECT );
      // pr($plans);

      if($res):
        foreach($res as $k => $v):
      ?>
      <tr>
        <?php

        #------------------------------------------
        # Table Row data dynamically  Generation
        #------------------------------------------

        /* 
        foreach($add_edit_field_name_arr as $vv){
          $name = $vv["name"];
          $my_array = (array) $v;
          echo "<td> $my_array[$name] </td>";
        }*/

        #------------------------------------------
        # End Table Row data dynamically  Generation
        #------------------------------------------

        ?>

        <td><?php echo $v->use_for; ?></td>
        <td> <img src="<?php echo $v->img_url; ?>" width="200px" height="150px;"> </td>
        <td><?php echo $v->img_url; ?></td>
        <td><?php echo $v->action_url; ?></td>
        <td style="white-space: nowrap;"><?php echo $v->start_date."-".$v->end_date; ?></td>
        <td><?php echo $v->img_place_holder; ?></td>
        <td><?php echo $v->created_at; ?></td>

        <td style="min-width: 150px;">
          <a href="?page=<?php echo $web_lover_page_link. "&action=" . $edit_data_name; ?>&id=<?php echo $v->id; ?>" style="display: inline; text-decoration: none; margin-right: 10px;">
            <button style="cursor: pointer;">Edit</button>
          </a>

          <a href="?page=<?php echo $web_lover_page_link."&action=".$delete_data_name; ?>&id=<?php echo $v->id; ?>" onclick=" return confirm('Are you sure you wanna delete this ?')" style="cursor: pointer; text-decoration: none;">
            <button style="display: inline; color: red; cursor: pointer;">Delete</button>
          </a>
        </td>
      </tr>
    <?php endforeach; endif; ?>
      <!-- loop data end -->

    </tbody>
   
  </table>
</div>

<?php

# --------------------------------------------------------------
# A function for dynamically generate input field upon call
# --------------------------------------------------------------

function web_lover_data_add_edit_form( $input_fields = '') {

  global $nonce_name;
  global $nonce_verify_name;
  global $action_name;
  global $data_primary_id;
  global $form_heading;

?>
<div style="min-width: 350px; border: 1px solid black; margin-left: 10%; margin-right: 50%; margin-top: 50px;">
  <h3 style='padding-left: 30px; padding-bottom: 20px; border-bottom: 1px dotted black;'>
    <?php echo $form_heading; ?>
  </h3>

  <div class="container">
    <form action="" method="post">
      
      <?php wp_nonce_field($nonce_verify_name, $nonce_name); ?>

      <?php echo "<input type='hidden' name='action_name' value='".$action_name."' >"; ?>
      <?php echo "<input type='hidden' name='data_primary_id' value='".$data_primary_id."' >"; ?>

       <?php echo $input_fields; ?>

      <br>
      <br>

      <input type="submit" name="submit" value="Submit">
    </form>
  </div>
</div>

<?php 
} // end of function  

# --------------------------------------------------------------
# End of  function for dynamically generate input field upon call
# --------------------------------------------------------------
?>

<?php
  
  $data_primary_id = NULL;
  $action_name = NULL;

  if( isset( $_GET['action'] ) &&  $_GET['action'] == $web_lover_data_add_link){
    $action_name = $web_lover_data_add_link;

   # --------------------------------------------------------------
   # We are here Because user Click Add data 
   # --------------------------------------------------------------


    # --------------------------------------------------------------
    # Here We are Creating dynamic Form input by calling our 
    # $add_edit_field_name_arr from Setting page
    # --------------------------------------------------------------

    $dynamic_form_inputs = "";

    if( $add_edit_field_name_arr ){
      foreach($add_edit_field_name_arr as $v){
        $dynamic_var = $v["name"];
        $dynamic_var_type = $v["type"];
        $dynamic_var_value = '';

        # Generating the Form inputs
        if( $dynamic_var_type == "string" ){

            $dynamic_form_inputs .= web_lover_form_input($dynamic_var, $dynamic_var_value, true);

        }else if( $dynamic_var_type == "date_range" ){
          
            $dynamic_form_inputs .= web_lover_form_date_range($dynamic_var, $dynamic_var_value, true);

        }else if( $dynamic_var_type == "text" ){
            $dynamic_form_inputs .= web_lover_form_textarea($dynamic_var, $dynamic_var_value, true);
        }

      }

    }

    # Calling the Form generation Function
    web_lover_data_add_edit_form( $dynamic_form_inputs );

    # --------------------------------------------------------------
    # End of Here We are Creating dynamic Form input by calling our 
    # $add_edit_field_name_arr from Setting page
    # --------------------------------------------------------------



  }else if(isset( $_GET['action'] ) && $_GET['action'] == $edit_data_name){

    # --------------------------------------------------------------
    # We are here Because user Click Edit data 
    # --------------------------------------------------------------

    $action_name = $edit_data_name;
    $data_primary_id = (int) $_GET['id'] ? $_GET['id'] : 0; 

    global $wpdb;
    $edit_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE id=$data_primary_id", OBJECT );


    # --------------------------------------------------------------
    # Here We are Creating dynamic Form input by calling our 
    # $add_edit_field_name_arr from Setting page
    # Here first We are Creating all the dynamic var for value field
    # --------------------------------------------------------------
    
    $dynamic_form_inputs = "";

    if($edit_data){

        $edit_data = $edit_data[0];

        # Fixing Edit form Date
        $start_date = $edit_data->start_date;
        $end_date  = $edit_data->end_date;
        # Fixing Edit form Date

        // pr($edit_data);

        # Rename this field Accordingly to
        # data Base save data Field

        if( $add_edit_field_name_arr ){
          foreach($add_edit_field_name_arr as $v){
            $dynamic_var = $v["name"];
            $dynamic_var_type = $v["type"];
            $dynamic_var_value = $edit_data->$dynamic_var;

            # Generating the Form inputs
            if( $dynamic_var_type == "string" ){

                $dynamic_form_inputs .= web_lover_form_input($dynamic_var, $dynamic_var_value, true);

            }else if( $dynamic_var_type == "date_range" ){
              
                $dynamic_form_inputs .= web_lover_form_date_range($dynamic_var, $dynamic_var_value, true);

            }else if( $dynamic_var_type == "text" ){
                $dynamic_form_inputs .= web_lover_form_textarea($dynamic_var, $dynamic_var_value, true);
            }

          }

        }

        # calling the form Input Gerneration function
        web_lover_data_add_edit_form( $dynamic_form_inputs );

        # End

    }

    # --------------------------------------------------------------
    # END of Here We are Creating dynamic Form input by calling our 
    # $add_edit_field_name_arr from Setting page
    # Here first We are Creating all the dynamic var for value field
    # --------------------------------------------------------------

    
  }else if( isset( $_GET['action'] ) 
    &&  $_GET['action'] == $delete_data_name )
  {

    # --------------------------------------------------------------
    # We are here Because user Click Delete data 
    # --------------------------------------------------------------

    # Delete Operation ..
    $action_name = $delete_data_name;
    $data_primary_id = (int) $_GET['id'] ? $_GET['id'] : NULL; 

    global $wpdb;
    $plan = $wpdb->delete( $table_name, array( 'id' => $data_primary_id ) );

    # Flash Message Call Here.. 
    web_lover_flash_msg($plan);

    # --------------------------------------------------------------
    # End We are here Because user Click Edit data 
    # --------------------------------------------------------------

  }

  /*==============================================
  =            Save the Post Data ...            =
  ==============================================*/

  if(isset($_POST['submit'])){

    // pr($_POST); die();
   
    if( wp_verify_nonce($_POST[$nonce_name], $nonce_verify_name) ){

      $data_primary_id = (int) $_POST['data_primary_id'];
      $action_name = $_POST['action_name'];

      # unset some data
      unset( $_POST['submit'] );
      unset( $_POST[$nonce_name] );
      unset( $_POST['data_primary_id'] );
      unset( $_POST['action_name'] );
      unset($_POST['_wp_http_referer']);
      # end data


      # --------------------------------------------------------------
      # We are Generating Dynamic array data for Add or Edit
      # --------------------------------------------------------------

      # Build the data Array
      $data_array = array();
      foreach($_POST as $k => $v){
        # Dynamic data Build
        $k = esc_html($k);
        $data_array["$k"] = esc_html($v);

      }
    
     /* pr($add_edit_field_name_arr);
      pr($table_name);
      pr( $data_array ); 
      var_dump( $data_array );
      die();*/

      # --------------------------------------------------------------
      # End We are Generating Dynamic array data for Add or Edit
      # --------------------------------------------------------------

      global $wpdb;
      global $table_name;

      if($action_name == $edit_data_name){
        # --------------------------------------------------------------
        # We are Updating the data From here
        # --------------------------------------------------------------
        $res = $wpdb->update( $table_name, $data_array, array("id" => $data_primary_id) );

      }else{
        # --------------------------------------------------------------
        # We are Creating New Data From here
        # --------------------------------------------------------------
        $res = $wpdb->insert($table_name, $data_array);

      }

      # Flash Message Call Here.. 
      web_lover_flash_msg($res);


    }else{
      echo "Nonce Verification Failed !";
    }

  }

  /*=====  End of Save the Post Data ...  ======*/

// pr($action_name);

?>


<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
  jQuery(document).ready(function($){

    // start fixing edit form
    $("input[name=start_date]").daterangepicker({
        singleDatePicker: true,
        startDate: "<?php echo $start_date; ?>"
    });
    $("input[name=end_date]").daterangepicker({
        singleDatePicker: true,
        startDate: '<?php echo $end_date; ?>'
    });
    //end fixing edit form


     $('#web_lover_table').DataTable();

    //  $('#web_lover_table_length').css({'margin-left': '10%'});
    //  $('#web_lover_table_info').css({'margin-left': '10%'});

    //  $('#web_lover_table_filter').css({'margin-right': '10%'});
    //  $('#web_lover_table_paginate').css({'margin-right': '10%'});

  });
</script>