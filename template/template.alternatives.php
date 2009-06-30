<?php 
/* 
removes the  <div> around  the list and add the item-list class into the ul/ol 
*/

function mothership_item_list($items = array(), $title = NULL, $type = 'ul', $attributes = NULL) {
  $attributes['class'] .= " item-list";
//  $output = '<div class="item-list">';
  if (isset($title)) {
    $output .= '<h3>'. $title .'</h3>';
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

      $output .= '<li'. drupal_attributes($attributes) .'>'. $data ."</li>\n";
    }
    $output .= "</$type>";
  }
//  $output .= '</div>';
  return $output;
}


