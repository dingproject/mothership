<?php
/*
 * These two variables are provided for context.
 * - $comment: Full comment object.
 * - $node: Node object the comments are attached to.
 *
 * @see template_preprocess_comment()
 * @see theme_comment()
 */
?>

<?php
/*
ad a class="" if we have anything in the $classes var
this is so we can have a cleaner output - no reason to have an empty <div class="" id=""> 
*/
if($classes){
   $classes = ' class="' . $classes . '"';
}

?>

<div<?php print $classes; ?>>
  <h3><?php print $title ?></h3>

  <?php print $picture ?>    
  <?php print $submitted ?>
  <?php if ($comment->new): ?>
    <?php print $new ?>
  <?php endif; ?>

  <?php print $content ?>

  <?php if ($signature): ?>
    <?php print $signature ?>
  <?php endif; ?>


  <?php print $links ?>    
</div>
