<?php

// load search functions
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/lt-api-spoon-functions.php';

// spoonacular API Searches ----------------------------
add_shortcode( 'ltspoondata', 'spoonacular_api_shortcode' );


function spoonacular_api_shortcode() { 
  
  if (isset( $_POST['search-food'] )) { 
       //      display_spoonacular_forms();
  $buffer = search_by_food( $_POST['search-food'] );
  return $buffer;

  }else if(isset( $_POST['search-summary-id'] )) {  
          //   display_spoonacular_forms();
   $buffer = search_by_summary_id( $_POST['search-summary-id'] );
  return $buffer;
  
  }else if(isset( $_POST['search-recipe-id'] )) {  
           //  display_spoonacular_forms();
  $buffer = search_by_recipe_id( $_POST['search-recipe-id'] );  
  return $buffer;

  }else if(isset( $_POST['search-recipe-ingredient'] )) {  
          //   display_spoonacular_forms();
  $buffer = search_by_ingredient( $_POST['search-recipe-ingredient'] );     
  return $buffer;

  } else {     
    display_spoonacular_forms();  
  }
  
}

