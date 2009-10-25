<?php
// $Id$
/**
 * @file
 * views-view-list.tpl.php
 * Default simple view template to display a list of rows.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $options['type'] will either be ul or ol.
 * @ingroup views_templates

 *  The $classes are defined in template_preprocess_views_view_list()
 */
?>
<!-- views-view-list.tpl.php -->
<?php if (!empty($title)) { ?>
  <h3><?php print $title; ?></h3>
<?php } ?>

  <<?php print $options['type']; ?>>
  <?php foreach ($rows as $id => $row) {
    print '  <li';
    if ($classes[$id]) {
      print ' class="' . $classes[$id] .'"';
    }
    print '>';

    print $row;

    print '  </li>';
    print "\n";
  }
?>
</<?php print $options['type']; ?>>
<!-- /views-viewsiew-list.tpl.php -->