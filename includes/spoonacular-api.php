<?php
/**
 * @link       https://ltwebdev.com
 * @since      1.0.0
 *
 * @package    lt_api_searches
 * @subpackage lt_api_searches/includes
 * */

// load search functions
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/lt-api-spoon-functions.php';

// spoonacular API Searches ----------------------------------------
// user to add this shortcode on thier site to implement search page
add_shortcode( 'ltspoondata', 'spoonacular_api_shortcode' );

// handle the form submission selection here:
// function then passes API Query results to buffer and returns it.
function spoonacular_api_shortcode() { 
  
  if (isset( $_POST['search-food'] )) { 
       //      display_spoonacular_forms(); <- not needed
  $buffer = search_by_food( $_POST['search-food'] );
  return $buffer;

  }else if(isset( $_POST['search-summary-id'] )) {  
          //   display_spoonacular_forms(); <- not needed
   $buffer = search_by_summary_id( $_POST['search-summary-id'] );
  return $buffer;
  
  }else if(isset( $_POST['search-recipe-id'] )) {  
           //  display_spoonacular_forms();<- not needed
  $buffer = search_by_recipe_id( $_POST['search-recipe-id'] );  
  return $buffer;

  }else if(isset( $_POST['search-recipe-ingredient'] )) {  
          //   display_spoonacular_forms();<- not needed
  $buffer = search_by_ingredient( $_POST['search-recipe-ingredient'] );     
  return $buffer;

  } else {     
    display_spoonacular_forms();  
  }
  
}

