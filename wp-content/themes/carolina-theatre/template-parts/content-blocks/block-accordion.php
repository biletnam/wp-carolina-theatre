<?php global $accordionCount; ?>
<?php if (have_rows('panel')) { ?>
<div class="accordion">
<?php while(have_rows('panel')) { the_row(); ?>
	<div class="accordion__panel">
		<?php $accordionCount++; ?>
		<input id="panel-<?php echo $accordionCount;?>" type="checkbox" name="panels">
		<label for="panel-<?php echo $accordionCount;?>"><?php echo get_sub_field('title'); ?></label>
		<div class="accordion__content">
		<?php if (have_rows('content')) { ?>
		<?php  while(have_rows('content')) { the_row(); ?>
			<?php  get_template_part( 'template-parts/content-blocks/content-blocks' ); ?>
		<?php } // endwhile ?>
		<?php } // endif ?>
		</div>
	</div>
<?php } // endwhile ?>
<?php wp_reset_postdata(); ?>
</div>
<?php } // endif ?>
