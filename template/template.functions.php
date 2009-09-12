<?php 
/* =====================================
  General functions
* ------------------------------------- */

function mothership_id_safe($string) { 
  // Replace with dashes anything that isn't A-Z, numbers, dashes, or underscores.
  $string = strtolower(preg_replace('/[^a-zA-Z0-9_-]+/', '-', $string));
  $string = strtolower(str_replace('_', '-', $string));   //die _ die!
   
  // If the first character is not a-z, add 'n' in front.
  if (!ctype_lower($string{0})) { // Don't use ctype_alpha since its locale aware.
    $string = 'id' . $string;
  }
  return $string;
}