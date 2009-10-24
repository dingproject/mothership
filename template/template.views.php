<?php 
/* =====================================
 template views
* ------------------------------------- */
function mothership_preprocess_views_view_list(&$vars){
  mothership_preprocess_views_view_unformatted($vars);  
}

  function mothership_preprocess_views_view_unformatted(&$vars) {
    $view     = $vars['view'];
    $rows     = $vars['rows'];

    $vars['classes'] = array();
    // Set up striping values.
     foreach ($rows as $id => $row) {
    //  $vars['classes'][$id] = 'views-row-' . ($id + 1);
      if(theme_get_setting(mothership_cleanup_views_row_ident)){
      	$vars['classes'][$id] = 'views-row';
			}	

      if(theme_get_setting(mothership_cleanup_views_zebra)){
        //$vars['classes'][$id] .= ' views-row-' . ($id % 2 ? 'even' : 'odd');
        $vars['classes'][$id] .=  ($id % 2 ? ' even' : ' odd');
      }  
      if ($id == 0 AND theme_get_setting(mothership_cleanup_views_first_last)) {
        $vars['classes'][$id] .= ' first';
      }
    }
    if(theme_get_setting(mothership_cleanup_views_first_last)){
      $vars['classes'][$id] .= ' last';      
    }

  }


?>