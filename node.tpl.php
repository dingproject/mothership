<?php
/*
	dsm($variables['template_files']);
  dsm($node);
  dsm($node->content);
  print_r(get_defined_vars());
  print $FIELD_NAME_rendered;
*/
/*
ad a class="" if we have anything in the $classes var
this is so we can have a cleaner output - no reason to have an empty <div class="" id=""> 
*/
if($classes){
   $classes = ' class="' . $classes . '"';
}

if($id_node){
  $id_node = ' id="' . $id_node . '"';  
}
?>

<?php print $id_node . $classes; ?>
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

	<?php  print $content;?>	

	<a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print t('read more') ?></a>

  <?php if ($links){ ?>
    <?php print $links; ?>
  <?php }; ?>
	  
</div>
	
<?php }else{ 
//Content
?>
<div<?php print $id . $classes; ?>>
	<h1><?php print $title;?></h1>		
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