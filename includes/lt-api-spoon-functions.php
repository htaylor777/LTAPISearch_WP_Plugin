<?php
/**
 * @link       https://ltwebdev.com
 * @since      1.0.0
 *
 * @package    lt_api_searches
 * @subpackage lt_api_searches/includes
 * 
 * Search functions to return from user form submissions:
 * @search_by_food
 * @search_by_summary_id
 * @search_by_recipe_id
 * @search_by_ingredient
 *  - requires user to obtain a spoonacular_apikey_setting
 *- user can control how many recipes to pull down
*/

function search_by_food($food) {  
    echo "<h2> search by food: " . $food . "</h2>";
$apiKey      = get_option('spoonacular_apikey_setting');
$recipeCount = get_option('spoonacular_recipecount_setting');

$api_url = 'https://api.spoonacular.com/recipes/autocomplete?query='
. $food. '&number='.$recipeCount.'&apiKey=' .$apiKey;

$response = wp_remote_get($api_url);
$responseBody = wp_remote_retrieve_body( $response );
$result = json_decode( $responseBody );

//var_dump($result);
//print_r($result);
$buffer = '';
$count1 = 0;
if ( is_array( $result ) && ! is_wp_error( $result ) ) {
    // Work with the $result data
    foreach ($result as $data) {
      $buffer = $buffer . "<h2 class='title center'>&nbsp;". $data->title ."</h2>";
    //  $buffer = $buffer . '<h4>ID:<input text class="found" id="found'.$count1++.'" value ="'.$data->id .'" onclick="copyFunction(this.id); return false;"></h4>';    
      $buffer = $buffer . '
  <form action="" method="POST">
  <input type="hidden" name="search-recipe-id" value="'. $data->id .'">
  <input class="search-id2 small center" type="submit"  
  value="Try This"></form>';
      $buffer = $buffer . "<hr /><br />";
  }
  return $buffer;
}else {
    // Work with the error
    echo "Food array not found: search_by_food($food)";
 }
}



function search_by_summary_id($id) {  
 
    echo '<p>Search ID:&nbsp;<input class="found small" text id="found" value ="'.$id .'" 
    onclick="copyFunction(this.id); return false;"></p>'; 
    
$apiKey     = get_option('spoonacular_apikey_setting');

$api_urlid = 'https://api.spoonacular.com/recipes/' .$id. '/summary?apiKey='
. $apiKey;

$responseid = wp_remote_get($api_urlid);
$responseBodyid = wp_remote_retrieve_body( $responseid );
$result = json_decode( $responseid['body'],true);
///var_dump($result);
//print_r($result);
  $buffer = '';
if ( is_array( $result ) && ! is_wp_error( $result ) ) {
    // Work with the $result data 
    // - skip the id @skipped array
    // - decorate the Title @title array
    $skipped = array('id');
    $title   = array('title');

    foreach ($result as $key=>$value) {
      if(in_array($key, $skipped)){
        continue;
      }
      if (in_array($key, $title)) {
      $buffer = $buffer . "<h2 class='title center'>".$value."</h2>";
      }else{  
      $buffer = $buffer . "<h3>".$value."</h3>";  
      $buffer = $buffer . "<hr /><br /> <br />";
    }
    }
  
    return $buffer;
  }else {
    // Work with the error
    echo "Food array not found: search_by_summary_id($id)";
 }
}


function search_by_recipe_id($id) {   
echo '<p><form>Recipe ID:&nbsp;<input class="found small" text id="found" value ="'.$id .'" 
onclick="copyFunction(this.id); return false;"><br><input class="buttons" type="button" value="More Recipes" onclick="history.back()"> </p>
</form>
'; 

$apiKey = get_option('spoonacular_apikey_setting');

$api_url = 'https://api.spoonacular.com/recipes/informationBulk?ids=' 
.$id. '&apiKey='.$apiKey;


// API response from query:-----------------------------------------------
$response = wp_remote_get($api_url);
$responseBody = wp_remote_retrieve_body( $response );
$result = json_decode( $responseBody );

//var_dump($result);
//print_r($result);
$buffer = '';
if ( is_array( $result ) && ! is_wp_error( $result ) ) {
    // Work with the $result data
    foreach ($result as $data) {   
      $buffer = $buffer . "<h2 class='title center'>".$data->title ."</h2>";
      $buffer = $buffer . '<img class="image" src="'.$data->image .'">';
      $buffer = $buffer . "ReadInMinutes: ".$data->readyInMinutes;
      $buffer = $buffer . "<br />";
      $buffer = $buffer . "Servings: ".$data->servings;
      $buffer = $buffer . "<br />";
      $buffer = $buffer . '<h2><a href="'.$data->sourceUrl.'" rel="noopener noreferrer" target="_blank">Get This Full Recipe</a></h2>';
      $buffer = $buffer . "<p>Summary: ".$data->summary ."</p>";  
      $buffer = $buffer . "<hr /><br /> <br />";
  }
  return $buffer;
}else {
    // Work with the error
    echo "Food array not found: search_by_recipe_id($id)";
 }
}


function search_by_ingredient($ingredients) {  
 $apiKey      = get_option('spoonacular_apikey_setting'); 
 $recipeCount = get_option('spoonacular_recipecount_setting');
 $api_url = 'https://api.spoonacular.com/recipes/findByIngredients?ingredients='.
 $ingredients.'&number='.$recipeCount.'&apiKey='.$apiKey; 
 
 $response = wp_remote_get($api_url);
 $responseBody = wp_remote_retrieve_body( $response );
 $result = json_decode( $responseBody );
 
// var_dump($result);
//print_r($result);

       $buffer = ''; 
       $count = 1;
       
 if ( is_array( $result ) && ! is_wp_error( $result ) ) {
     // Work with the $result data
     foreach ($result as $data) {
      
      $buffer = $buffer . "<p>Recipe:".$count++."<h2 class='title center'>&nbsp;". $data->title ."</h2>"; 
      $buffer = $buffer . '
    <form action="" method="POST">
    <input type="hidden" name="search-recipe-id" value="'. $data->id .'">
    <input class="found small center" type="submit" value="Try This"></form>';
      $buffer = $buffer . "<hr /><br />";
    }
 return $buffer;
 }else {
     // Work with the error
     echo "Food array not found: search_by_ingredient($ingredients)";
   }
} 



function display_spoonacular_forms() { 
  ?>
  
  <form action="" method="POST">
  <label class="lbl" for="search-spoon"> Search by Food or Culture</label>
  <input class="search-spoon large" type="text" name="search-food" required="true" placeholder="chicken">
  </form>

  <form action="" method="POST">
  <label class="lbl" for="search-ingredient">What's in your Fridge?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
  <input class="search-ingredient large" type="text" name="search-recipe-ingredient" required="true" placeholder="apples,+chicken,+butter">
  </form>

  <form action="" method="POST">
  <label class="lbl" for="search-id"> Summary Search by ID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
  <input id="search-id" class="search-id large" type="text" name="search-summary-id" required="true" placeholder="4632">
  </form>

  <form action="" method="POST">
  <label class="lbl" for="search-id2">Get the Recipe by ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
  <input id="search-id2" class="search-id2 large" type="text" name="search-recipe-id" required="true" placeholder="4632">
  </form>

   <form action="<?php get_home_url('recipe-search-2'); ?>">
  <input class="buttons" type="submit" value="Reset For New Query"/> </p>
</form>
  
  
<?php
} 

// END API search

