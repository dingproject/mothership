<?php 
/* 
removes the  <div> around  the list and add the item-list class into the ul/ol 
if it has a $title added then hte surrounding div will be 
*/

function mothership_item_list($items = array(), $title = NULL, $type = 'ul', $attributes = NULL) {
	//fix if the type is div-span
	if($type == "div-span"){
		$type = "div";
		$item_type = "div-span";
	}else{
		$item_type = $type;
	}

  $attributes['class'] .= " item-list";
	//test if we have an title then add the div.item-list around the list
  if (isset($title)) {
  	$output = '<div class="item-list">';
    if($item_type == "span"){
			$output .= '<span class="title">'. $title .'</span>';	
		}else{
			$output .= '<h3>'. $title .'</h3>';	
		}
		
  }


  if (!empty($items)) {
    $output .= "<$type". drupal_attributes($attributes) .'>';
    $num_items = count($items);
    foreach ($items as $i => $item) {
      $attributes = array();
      $children = array();
      if (is_array($item)) {
        foreach ($item as $key => $value) {
          if ($key == 'data') {
            $data = $value;
          }
          elseif ($key == 'children') {
            $children = $value;
          }
          else {
            $attributes[$key] = $value;
          }
        }
      }
      else {
        $data = $item;
      }
      if (count($children) > 0) {
        $data .= theme_item_list($children, NULL, $type, $attributes); // Render nested list
      }
      
      $mothership_cleanup_itemlist = theme_get_setting('mothership_cleanup_itemlist');       
      
      //removed first / last fromt the item list?
      if(theme_get_setting('mothership_item_list_first_last')){
        if ($i == 0) {
          $attributes['class'] = empty($attributes['class']) ? 'first' : ($attributes['class'] .' first');
        }
        if ($i == $num_items - 1) {
          $attributes['class'] = empty($attributes['class']) ? 'last' : ($attributes['class'] .' last');
        }
      }

			//is it a li or a span or a div ?
			if($item_type == "ul" OR $item_type == "ol"){
				$output .= '<li'. drupal_attributes($attributes) .'>'. $data ."</li>\n";	
			}elseif($item_type == "span" OR $item_type == "div-span" ){
				$output .= '<span'. drupal_attributes($attributes) .'>'. $data ."</span>\n";	
			}elseif($item_type == "div"){
				$output .= '<div'. drupal_attributes($attributes) .'>'. $data ."</div>\n";	
			}else{
				$output .= '<li'. drupal_attributes($attributes) .'>'. $data ."</li>\n";	
			}

    }
    $output .= "</$type>";
  }
  if (isset($title)) {
  	$output .= '</div>';
	}
  return $output;
}


