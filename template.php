<?php
/* =====================================
  mothership
  template.php
* ------------------------------------- */

// Auto-rebuild the theme registry during theme development.
if (theme_get_setting('mothership_rebuild_registry')) {
  drupal_rebuild_theme_registry();
}

/* =====================================
  include template overwrites
* ------------------------------------- */
    include_once './' . drupal_get_path('theme', 'mothership') . '/template/template.functions.php';
    include_once './' . drupal_get_path('theme', 'mothership') . '/template/template.form.php';
    include_once './' . drupal_get_path('theme', 'mothership') . '/template/template.cck.php';
    include_once './' . drupal_get_path('theme', 'mothership') . '/template/template.table.php';
    include_once './' . drupal_get_path('theme', 'mothership') . '/template/template.alternatives.php';
    include_once './' . drupal_get_path('theme', 'mothership') . '/template/template.menu.php';
/* =====================================
  preprocess
* ------------------------------------- */

function mothership_preprocess_page(&$vars, $hook) {
  // Add HTML tag name for title tag. so it can shift from a h1 to a div if its the frontpage
  $vars['site_name_element'] = $vars['is_front'] ? 'h1' : 'div';

  //<body> classes
  $body_classes = array($vars['body_classes']);

  //do we wanna kill all the goodies that comes with drupal?
  if(theme_get_setting('mothership_cleanup_body_remove')){
    $body_classes = " ";
  }

  if (!$vars['is_front']) {
    // Add unique path classes for each page 
    if(theme_get_setting('mothership_cleanup_body_path')){
      $path = drupal_get_path_alias($_GET['q']);
      list($section, ) = explode('/', $path, 2);
      $body_classes[] = mothership_id_safe('page-' . $path);
      $body_classes[] = mothership_id_safe('section-' . $section); 
    } 

    //add actions
    if(theme_get_setting('mothership_cleanup_body_actions')){
      if (arg(0) == 'node') {
        if (arg(1) == 'add') {
          $body_classes[] = 'action-node-add'; 
        }
        elseif (is_numeric(arg(1)) && (arg(2) == 'edit' || arg(2) == 'delete')) {
          $body_classes[] = 'function-node-' . arg(2); // Add 'action-node-edit' or 'action-node-delete'
        }
      }
    }

  }

  $vars['body_classes'] = implode(' ', $body_classes); // Concatenate with spaces
  
}

function mothership_preprocess_node(&$vars, $hook) {

  // create css classes for the node
  $classes =array();
  //sticky
  if(theme_get_setting('mothership_cleanup_node_sticky')){
    if ($vars['sticky']) {
      $classes[] = 'sticky';
    }
  }
  //published
  if(theme_get_setting('mothership_cleanup_node_published')){  
    if (!$vars['status']) {
      $classes[] = 'node-unpublished';
      $vars['unpublished'] = TRUE;
    }
    else {
      $vars['unpublished'] = FALSE;
    }
  }
  //promoted
  if(theme_get_setting('mothership_cleanup_node_promoted')){
    if ($vars['promote']) {
      $classes[] = 'promoted';
    }
  }

  //node or teaser Class for node type: "node-page", "node-story", "node-teaser-page","node-teaser-story",
  if ($vars['teaser']) {
    if(theme_get_setting('mothership_cleanup_node_node')){
     $classes[] = 'node-teaser';       
    }
    if(theme_get_setting('mothership_cleanup_node_content_type')){
      $classes[] = 'node-teaser-'.$vars['type'];    
    }    
  }else{
    if(theme_get_setting('mothership_cleanup_node_node')){
      $classes[] = 'node';
    }  
    if(theme_get_setting('mothership_cleanup_node_content_type')){
      $classes[] = 'node-' . $vars['type'];
    }
  } 
  
  $vars['classes'] = implode(' ', $classes);

  // css id for the node
  if(theme_get_setting('mothership_cleanup_node_id')){
    $id_node = array();
    $id_node[] = 'node';      
    $id_node[] =  $vars['nid'] ;  
		if($vars['nid']){
	    $vars['id_node'] = implode(' ', $id_node);
	    $vars['id_node'] =  mothership_id_safe($vars['id_node']);
		}

  }

  //Add 2 regions to the node?
  if(theme_get_setting('mothership_cleanup_node_regions') AND $vars['page'] == TRUE){
    if ($vars['page'] == TRUE) {
      $vars['node_region_one'] = theme('blocks', 'node_region_one');
      $vars['node_region_two'] = theme('blocks', 'node_region_two');
    }
  }

  return $vars['template_files'];
}

function mothership_preprocess_block(&$vars, $hook) {
  //  classes for blocks.
  $block = $vars['block'];
  $classes = array();

  if(theme_get_setting('mothership_cleanup_block_block')){
    $classes[] = 'block';
  }

  if(theme_get_setting('mothership_cleanup_block_module')){    
    $classes[] = 'block-' . mothership_id_safe($block->module);
  }

  if(theme_get_setting('mothership_cleanup_block_region_zebra')){
    $classes[] = 'region-' . $vars['block_zebra'];
  }

  if(theme_get_setting('mothership_cleanup_block_region_count')){
    $classes[] = 'region-count-' . mothership_id_safe($vars['block_id']);
  }

  if(theme_get_setting('mothership_cleanup_block_zebra')){
    $classes[] = $vars['zebra'];
  }

  if(theme_get_setting('mothership_cleanup_block_count')){
    $classes[] = 'count-' . mothership_id_safe($vars['id']);
  }

  if(theme_get_setting('mothership_cleanup_block_front')){
    if($vars['is_front']){
      $classes[] = 'block-front';      
    }
  }

  if(theme_get_setting('mothership_cleanup_block_loggedin')){
    if($vars['logged_in']){
      $classes[] = 'block-logged-in';      
    }
  }

  /*
  edit links zen style ?
  $vars['edit_links_array'] = array();
  $vars['edit_links'] = '';
  if (user_access('administer blocks')) {
    include_once './' . drupal_get_path('theme', 'mothership') . '/template/template.block-editing.php';
    zen_mothership_preprocess_block_editing($vars, $hook);
    $classes[] = 'with-block-editing';
  }
  */
  // Render block classes.
  $vars['classes'] = implode(' ', $classes);
//  $vars['classes'] =  mothership_id_safe($vars['classes']);
  // id for block
  if(theme_get_setting('mothership_cleanup_block_id')){
    $id_block = array();
    $id_block[] = 'block';      
    $id_block[] =  $block->module ;  

    if($block->delta){
      $id_block[] = $block->delta;
    }

    $vars['id_block'] = implode(' ', $id_block);
    $vars['id_block'] =  mothership_id_safe($vars['id_block']);
  }

}

function mothership_preprocess_comment(&$vars, $hook) {
  //dsm($vars);
  // Add an "unpublished" flag.
  $vars['unpublished'] = ($vars['comment']->status == COMMENT_NOT_PUBLISHED);

  // If comment subjects are disabled, don't display them.
  if (variable_get('comment_subject_field_' . $vars['node']->type, 1) == 0) {
    $vars['title'] = '';
  }

  // Special classes for comments.
  $classes = array();
  
  if(theme_get_setting('mothership_cleanup_comment_comment')){   
    $classes[] = 'comment';  
  }

  if ($vars['comment']->new AND theme_get_setting('mothership_cleanup_comment_new')) {
    $classes[] = 'comment-new';
  }
  
  if(theme_get_setting('mothership_cleanup_comment_status')){   
    $classes[] = $vars['status'];
  }

  if(theme_get_setting('mothership_cleanup_comment_zebra')){   
    $classes[] = $vars['zebra'];
  }  
  //first last
  if(theme_get_setting('mothership_cleanup_comment_first')){ 
    if ($vars['id'] == 1) {
      $classes[] = 'first';
    }
  } 
  
  if (($vars['id'] == $vars['node']->comment_count) AND theme_get_setting('mothership_cleanup_comment_last')) {
    $classes[] = 'last';
  }

  if(theme_get_setting('mothership_cleanup_comment_user')){  
    if ($vars['comment']->uid == 0) {
      // Comment is by an anonymous user.
      $classes[] = 'by-anonymous';
    }
    else {
      if ($vars['comment']->uid == $vars['node']->uid) {
        // Comment is by the node author.
        $classes[] = 'by-author';
      }
      if ($vars['comment']->uid == $GLOBALS['user']->uid) {
        // Comment was posted by current user.
        $classes[] = 'by-me';
      }
    }
  }

  if(theme_get_setting('mothership_cleanup_comment_front')){
    if($vars['is_front']){
      $classes[] = 'front';      
    }
  }

  if(theme_get_setting('mothership_cleanup_comment_loggedin')){
    if($vars['logged_in']){
      $classes[] = 'logged-in';      
    }
  }

  $vars['classes'] = implode(' ', $classes);
}


/* =====================================
  views
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

  function mothership_content_view_multiple_field($items, $field, $values) {
    $output = '';
    foreach ($items as $item) {
      if (!empty($item) || $item == '0') {
        $output .= '<div>'. $item .'</div>';
      }
    }
    return $output;
  }

