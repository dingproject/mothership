<?php
//	dsm($node->links);
	// foreach ($node->links as $key => $value) {
	// 	print $node->links[$key]['title'];
	// }

/*
	dsm(get_defined_vars())
	dsm($variables['template_files']);
  dsm($node);
  dsm($node->content);
  print $FIELD_NAME_rendered;
*/

/*
$links splitted up
<?php print $statistics_counter; ?>
<?php print $link_read_more; ?>
<?php print $link_comment; ?>
<?php print $link_comment_add ?>
<?php print $link_attachments; ?>
*/

/*
ad a class="" if we have anything in the $classes var
this is so we can have a cleaner output - no reason to have an empty <div class="" id=""> 
*/
if($classes){
   $classes = ' class="'. $classes . '"';
}

if($id_node){
  $id_node = ' id="'. $id_node . '"';  
}
?>

<?php
	foreach ($node->links as $link_id => $link) {
	  // we only want to move this bad boy out of $links if it is an actually link
	  // theme('links') can accept 'links' without href  ->  http://api.drupal.org/api/function/theme_links/6
	  if (isset($link['href'])) {
	    $vars["{$link_id}_link"] = l($link['title'], $link['href'], $link);
	  }
	}
?>

<?php if ($page == 0){ ?>
<div<?php print $id_node . $classes; ?>>
	

	<?php if($node->title){	?>	
    <h2><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
	<?php } ?>

	<?php if ($node->picture) { ;?>
    <?php print theme('imagecache', 'preset_namespace', $node->picture, $alt, $title, $attributes); ?>
	<?php } ?>
	
	<?php print theme('username', $node); ?>

	<?php print format_date($node->created, 'custom', "j F Y") ?> 

	<?php print $content;?>	

  <?php if ($links){ ?>
    <?php print $links; ?>
  <?php }; ?>
	  
</div>
	
<?php }else{ 
//Content
?>
<div<?php print $id_node . $classes; ?>>

	<h2><?php print $title;?></h2>		
  <?php if ($submitted){ ?>
  	<?php if ($picture) { ;?>
  		<?php print $picture; ?>  
	  <?php } ?>

	  <?php print theme('username', $node); ?>

		<?php print format_date($node->created, 'custom', "j F Y") ?> 
  <?php } ?>

	<?php if (count($taxonomy)){ ?>
   	<?php print $terms ?> 
	<?php } ?>

	<?php print $content ?>

	<?php print $node_region_two;?>	

	<?php print $node_region_one;?>
		
	<?php if ($links){ ?>
    <?php  print $links; ?>
	<?php } ?>
</div>
<?php } ?>