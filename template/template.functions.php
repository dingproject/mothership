<?php 
/* =====================================
  General functions
* ------------------------------------- */

function mothership_id_safe($string) { 
  // Replace with dashes anything that isn't A-Z, numbers, dashes, or underscores.
  $string = strtolower(preg_replace('/[^a-zA-Z0-9_-]+/', '-', $string));
  // If the first character is not a-z, add 'n' in front.
  if (!ctype_lower($string{0})) { // Don't use ctype_alpha since its locale aware.
    $string = 'id' . $string;
  }
  return $string;
}


/*
//MENU add icon stuff to links
function l_icon($text, $path, $attributes = array(), $query = NULL, $fragment = NULL, $absolute = FALSE, $html = FALSE, $css_class = FALSE) {
  if ($path == $_GET['q']) {
    if (isset($attributes['class'])) {
      $attributes['class'] .= ' active';
    }
    else {
      $attributes['class'] = 'active';
    }
  }
  return '<a href="'. check_url(url($path, $query, $fragment, $absolute)) .'"'. drupal_attributes($attributes) .'><span class="link-icon ' .mothership_id_safe($css_class).' '.mothership_id_safe($text).'">'. ($html ? $text : check_plain($text)) .'</span></a>';
}
*/

function l_icon($text, $path, $options = array()) {
  global $language;

  // Merge in defaults.
  $options += array(
      'attributes' => array(),
      'html' => FALSE,
    );

  // Append active class.
  if (($path == $_GET['q'] || ($path == '<front>' && drupal_is_front_page())) &&
      (empty($options['language']) || $options['language']->language == $language->language)) {
    if (isset($options['attributes']['class'])) {
      $options['attributes']['class'] .= ' active';
    }
    else {
      $options['attributes']['class'] = 'active';
    }
  }

  // Remove all HTML and PHP tags from a tooltip. For best performance, we act only
  // if a quick strpos() pre-check gave a suspicion (because strip_tags() is expensive).
  if (isset($options['attributes']['title']) && strpos($options['attributes']['title'], '<') !== FALSE) {
    $options['attributes']['title'] = strip_tags($options['attributes']['title']);
  }
return '<a href="'. check_url(url($path, $options)) .'"'. drupal_attributes($options['attributes']) .'>'. ($options['html'] ? $text : check_plain($text)) .'</a>';
/*
  $link = '<a href="'. check_url(url($path, $options)) .'"'. drupal_attributes($options['attributes']) .'>';
  $link .= '($options['html'] ? $text : check_plain($text)) .'</a>';
  $link .= '</a>';
  return $link;
*/
}
