<?php
/* =====================================
  mothership
  template.php
* ------------------------------------- */

  
/* =====================================
  include template overwrites
* ------------------------------------- */
    include_once './' . drupal_get_path('theme', 'mothership') . '/template/template.functions.php';
    include_once './' . drupal_get_path('theme', 'mothership') . '/template/template.form.php';
    include_once './' . drupal_get_path('theme', 'mothership') . '/template/template.cck.php';
    include_once './' . drupal_get_path('theme', 'mothership') . '/template/template.table.php';
    include_once './' . drupal_get_path('theme', 'mothership') . '/template/template.alternatives.php';
/* =====================================
  preprocess
* ------------------------------------- */

function mothership_preprocess_page(&$vars, $hook) {
  // Define the content width
  // Add HTML tag name for title tag.
  $vars['site_name_element'] = $vars['is_front'] ? 'h1' : 'div';

  //<body> classes
  $body_classes = array($vars['body_classes']);

  //do we wanna kill all the goodies that comes with drupal?
  if(theme_get_setting('mothership_class_body_remove')){
    $body_classes ="";

  }

  if (!$vars['is_front']) {
 
    // Add unique path classes for each page 
    if(theme_get_setting('mothership_class_body_path')){
      $path = drupal_get_path_alias($_GET['q']);
      list($section, ) = explode('/', $path, 2);
      $body_classes[] = mothership_id_safe('page-' . $path);
      $body_classes[] = mothership_id_safe('section-' . $section); 
    } 

    //add actions
    if(theme_get_setting('mothership_class_body_actions')){
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

  // Special classes for nodes
  $classes =array();
  //sticky
  if(theme_get_setting('mothership_class_node_sticky')){
    if ($vars['sticky']) {
      $classes[] = 'sticky';
    }
  }
  //published
  if(theme_get_setting('mothership_class_node_published')){  
    if (!$vars['status']) {
      $classes[] = 'node-unpublished';
      $vars['unpublished'] = TRUE;
    }
    else {
      $vars['unpublished'] = FALSE;
    }
  }
  //promoted
  if(theme_get_setting('mothership_class_node_promoted')){
    if ($vars['promote']) {
      $classes[] = 'promoted';
    }
  }


  //node or teaser
  // Class for node type: "node-page", "node-story", "node-teaser-page","node-teaser-story",
  if ($vars['teaser']) {
    if(theme_get_setting('mothership_class_node_node')){
     $classes[] = 'node-teaser';       
    }
    if(theme_get_setting('mothership_class_node_content_type')){
      $classes[] = 'node-teaser-'.$vars['type'];    
    }    
  }else{
    if(theme_get_setting('mothership_class_node_node')){
      $classes[] = 'node';
    }  
    if(theme_get_setting('mothership_class_node_content_type')){
      $classes[] = 'node-' . $vars['type'];
    }
  } 

  
  $vars['classes'] = implode(' ', $classes);

  //Add regions to nodes?
  if(theme_get_setting('mothership_class_node_sticky') AND $vars['page'] == TRUE){
    if ($vars['page'] == TRUE) {
      $vars['node_region_one'] = theme('blocks', 'node_region_one');
      $vars['node_region_two'] = theme('blocks', 'node_region_two');
    }
    
    //dsm($vars['template_files']);

  }
}

function mothership_preprocess_block(&$vars, $hook) {
  $block = $vars['block'];
  // classes for blocks.
  $classes = array('block');
  if(theme_get_setting('mothership_class_block_block')){
    $classes[] = 'block';
  }
  if(theme_get_setting('mothership_class_block_module')){    
    $classes[] = 'block-' . $block->module;
  }
  if(theme_get_setting('mothership_class_block_zebra')){
    $classes[] = $vars['zebra'];
  }

  $classes[] = 'region-' . $vars['block_zebra'];

  $classes[] = 'region-count-' . $vars['block_id'];

  $classes[] = 'count-' . $vars['id'];
/*
  $classes[] = 'block-' . $block->module;
  $classes[] = 'region-' . $vars['block_zebra'];
  $classes[] = $vars['zebra'];
  $classes[] = 'region-count-' . $vars['block_id'];
  $classes[] = 'count-' . $vars['id'];



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
  
  //dsm($vars['template_files']);
}


function mothership_preprocess_comment(&$vars, $hook) {
  // Add an "unpublished" flag.
  $vars['unpublished'] = ($vars['comment']->status == COMMENT_NOT_PUBLISHED);

  // If comment subjects are disabled, don't display them.
  if (variable_get('comment_subject_field_' . $vars['node']->type, 1) == 0) {
    $vars['title'] = '';
  }

  // Special classes for comments.
  $classes = array('comment');
  if ($vars['comment']->new) {
    $classes[] = 'comment-new';
  }
  
  $classes[] = $vars['status'];
  
  $classes[] = $vars['zebra'];
 
 if ($vars['id'] == 1) {
    $classes[] = 'first';
  }
 
  if ($vars['id'] == $vars['node']->comment_count) {
    $classes[] = 'last';
  }
  
  if ($vars['comment']->uid == 0) {
    // Comment is by an anonymous user.
    $classes[] = 'comment-by-anon';
  }
  else {
    if ($vars['comment']->uid == $vars['node']->uid) {
      // Comment is by the node author.
      $classes[] = 'comment-by-author';
    }
    if ($vars['comment']->uid == $GLOBALS['user']->uid) {
      // Comment was posted by current user.
      $classes[] = 'comment-mine';
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
    // foreach ($rows as $id => $row) {
    //  $vars['classes'][$id] = 'views-row-' . ($id + 1);
    //    $vars['classes'][$id] .= ' views-row-' . ($id % 2 ? 'even' : 'odd');
    //  if ($id == 0) {
    //    $vars['classes'][$id] .= ' first';
    //  }
   // }
   // $vars['classes'][$id] .= ' last';
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

