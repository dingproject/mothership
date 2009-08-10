<?php 
/* =====================================
  Forms 
* ------------------------------------- */

// function mothership_form($element) {
//   $action = $element['#action'] ? 'action="'. check_url($element['#action']) .'" ' : '';
//   return '<form '. $action .' accept-charset="UTF-8" method="'. $element['#method'] .'" id="'. $element['#id'] .'"'. drupal_attributes($element['#attributes']) .">\n". $element['#children'] ."\n</form>\n";
// }

function mothership_form_element($element, $value) {
/*
removed the prefix form-FOO
i like to grap my elements ala form .FOO instead of .form-item
*/
  // This is also used in the installer, pre-database setup.
  $t = get_t();
  $output = '<div class="form-item"';
  // TODO cant this be dublicated on a page?
  //and then its not unique
   if (!empty($element['#id'])) {
    $output .= ' id="'. $element['#id'] .'-wrapper"';
   }
  $output .= ">\n";
   $required = !empty($element['#required']) ? '<span class="form-required" title="'. $t('This field is required.') .'">*</span>' : '';

  if (!empty($element['#title'])) {
    $title = $element['#title'];
    if (!empty($element['#id'])) {
      $output .= ' <label for="'. $element['#id'] .'">'. $t('!title: !required', array('!title' => filter_xss_admin($title), '!required' => $required)) ."</label>\n";
    }
    else {
      $output .= ' <label>'. $t('!title: !required', array('!title' => filter_xss_admin($title), '!required' => $required)) ."</label>\n";
    }
  }
  //TODO test to see if this is clean text - then we might need a <span> 
  //if we need to catch the content with 
  $output .= "$value\n";

  if (!empty($element['#description'])) {
    $output .= '<div class="form-description">'. $element['#description'] ."</div>\n";
  }

  $output .= "</div>\n";

  return $output;
}

/*and size is not set to 20 so we might have a changce to style the little fucker*/
function mothership_file($element) {
  _form_set_class($element, array('file'));
  return theme('form_element', $element, '<input type="file" name="'. $element['#name'] .'"'. ($element['#attributes'] ? ' '. drupal_attributes($element['#attributes']) : '') .' id="'. $element['#id'] .'"  />');
/*size="20"*/
}

function mothership_checkbox($element) {
  _form_set_class($element, array('checkbox'));
  $checkbox = '<input ';
  $checkbox .= 'type="checkbox" ';
  $checkbox .= 'name="'. $element['#name'] .'" ';
  $checkbox .= 'id="'. $element['#id'] .'" ' ;
  $checkbox .= 'value="'. $element['#return_value'] .'" ';
  $checkbox .= $element['#value'] ? ' checked="checked" ' : ' ';
  $checkbox .= drupal_attributes($element['#attributes']) .' />';

  if (!is_null($element['#title'])) {
    $checkbox = '<label class="form-option" for="'. $element['#id'] .'">'. $checkbox .' '. $element['#title'] .'</label>';
  }

  unset($element['#title']);
  return theme('form_element', $element, $checkbox);
}

function mothership_fieldset($element) {
  
  $element['#attributes']['class'] .= ''.$element['#array_parents']['0'];

  if (!empty($element['#collapsible'])) {
    drupal_add_js('misc/collapse.js');

    if (!isset($element['#attributes']['class'])) {
      $element['#attributes']['class'] = '';
    }

    $element['#attributes']['class'] .= ' collapsible';
    if (!empty($element['#collapsed'])) {
      $element['#attributes']['class'] .= ' collapsed';
    }
  }

  return '<fieldset'. drupal_attributes($element['#attributes']) .'>'. ($element['#title'] ? '<legend>'. $element['#title'] .'</legend>' : '') . (isset($element['#description']) && $element['#description'] ? '<div class="description">'. $element['#description'] .'</div>' : '') . (!empty($element['#children']) ? $element['#children'] : '') . (isset($element['#value']) ? $element['#value'] : '') ."</fieldset>\n";
}

function mothership_button($element) {
  // Override theme_button ads spans around it so we can tweak the shit out it
  //http://teddy.fr/blog/beautify-your-drupal-forms
  // Make sure not to overwrite classes.
  if (isset($element['#attributes']['class'])) {
    $element['#attributes']['class'] = 'form-'. $element['#button_type'] .' '. $element['#attributes']['class'];
  }
  else {
    $element['#attributes']['class'] = 'form-'. $element['#button_type'];
  }

  // We here wrap the output with a div + span tag
  return '<div class="form-button"><span><input type="submit" '. (empty($element['#name']) ? '' : 'name="'. $element['#name'] .'" ')  .'id="'. $element['#id'].'" value="'. check_plain($element['#value']) .'" '. drupal_attributes($element['#attributes']) ." /></span></div>\n";
}

function mothership_image_button($element) {
  // Make sure not to overwrite classes.
  if (isset($element['#attributes']['class'])) {
    $element['#attributes']['class'] = 'form-'. $element['#button_type'] .' '. $element['#attributes']['class'];
  }
  else {
    $element['#attributes']['class'] = 'form-'. $element['#button_type'];
  }

  return '<div class="form-image-button"><input type="image" name="'. $element['#name'] .'" '.
    (!empty($element['#value']) ? ('value="'. check_plain($element['#value']) .'" ') : '') .
    'id="'. $element['#id'] .'" '.
    drupal_attributes($element['#attributes']) .
    ' src="'. base_path() . $element['#src'] .'" '.
    (!empty($element['#title']) ? 'alt="'. check_plain($element['#title']) .'" title="'. check_plain($element['#title']) .'" ' : '' ) .
    "/></div>\n";
}
