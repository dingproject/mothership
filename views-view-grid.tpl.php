<?php
// $Id$
/**
 * @file
 * views-view-grid.tpl.php
 * View template to display rows in a grid.
 *
 * - $rows contains a nested array of rows. Each row contains an array of
 *   columns.
 *
 * @ingroup views_templates
 */
?>
<!-- views-view-grid.tpl.php -->
<?php if (!empty($title)) : ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<table class="views-view-grid">
  <tbody>
    <?php foreach ($rows as $row_number => $columns): ?>
      <?php
        $row_class = 'row-' . ($row_number + 1);
        if ($row_number == 0) {
          $row_class .= ' row-first';
        }
        elseif (count($rows) == ($row_number + 1)) {
          $row_class .= ' row-last';
        }
      ?>
      <tr class="<?php print $row_class; ?>">
        <?php foreach ($columns as $column_number => $item): ?>
          <td class="<?php print 'col-'. ($column_number + 1); ?>">
            <?php print $item; ?>
          </td>
        <?php endforeach; ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>




<?php if (!empty($title)) : ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>

<?php $grid_cols = count(current($rows)); ?>

<div class="views-view-grid views-view-grid-<?php print $grid_cols; ?>-cols clear-block">
  <?php foreach ($rows as $row_number => $columns): ?>
    <?php
      $row_class = 'row-' . ($row_number + 1);
      if ($row_number == 0) {
        $row_class .= ' row-first';
      }
      elseif (count($rows) == ($row_number + 1)) {
        $row_class .= ' row-last';
      }
    ?>
    <?php foreach ($columns as $column_number => $item): ?>
      <?php
        $col_class = ' col-' . ($column_number + 1);
        $col_class .= $column_number == 0 ? ' col-first' : '';
        $col_class .= $column_number + 1 == count($columns) ? ' col-last' : '';
      ?>
      <div class="views-row <?php print $row_class . $col_class; ?>">
        <?php print $item; ?>
      </div>
    <?php endforeach; ?>

  <?php endforeach; ?>
</div>
<!-- / views-view-grid.tpl.php -->


