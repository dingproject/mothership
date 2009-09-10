<!-- views-view-fields.tpl.php -->
<?php foreach ($fields as $id => $field): ?>

  <?php if (!empty($field->separator)): ?>
    <?php print $field->separator; ?>
  <?php endif; ?>

     <<?php print $field->inline_html;?> class="<?php print $field->class; ?>">

       <?php if ($field->label): ?>
         <label>
           <?php print $field->label; ?>:
         </label>
       <?php endif; ?>


    <?php
      // $field->element_type is either SPAN or DIV depending upon whether or not
      // the field is a 'block' element type or 'inline' element type.
      //if theres not a field label defined then we wont print the span/div
      //if its label name is set to header then add a h1-h6 element instead - which can be set in the theme settings
    ?>

    <?php if ($field->label): ?>
      <<?php print $field->element_type; ?>>
    <?php endif; ?>
    
      <?php print $field->content; ?>
    
    <?php if ($field->label): ?>
      </<?php print $field->element_type; ?>>
    <?php endif; ?>


    
    </<?php print $field->inline_html;?>>

<?php endforeach; ?>
<!--/ views-view-fields.tpl.php -->


<?php
// $Id$
/**
 * @file views-view-fields.tpl.php
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->separator: an optional separator that may appear before a field.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
/*
<?php foreach ($fields as $id => $field): ?>
  <?php if (!empty($field->separator)): ?>
    <?php print $field->separator; ?>
  <?php endif; ?>

  <<?php print $field->inline_html;?> class="views-field-<?php print $field->class; ?>">
    <?php if ($field->label): ?>
      <label class="views-label-<?php print $field->class; ?>">
        <?php print $field->label; ?>:
      </label>
    <?php endif; ?>
      <?php
      // $field->element_type is either SPAN or DIV depending upon whether or not
      // the field is a 'block' element type or 'inline' element type.
      ?>
      <<?php print $field->element_type; ?> class="field-content"><?php print $field->content; ?></<?php print $field->element_type; ?>>
  </<?php print $field->inline_html;?>>
<?php endforeach; ?>
*/
?>