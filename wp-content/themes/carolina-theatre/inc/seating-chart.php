<?php 
// [seating-chart] shortcode
function seating_chart() {
  ob_start();
  ?>

  <div class="seatingChart">
  <?php 
  get_template_part('src/img/ctd-seating-chart'); 
  ?>
  </div>

  <?php 
  if(have_rows('seating_sections', 'options')){
  	while(have_rows('seating_sections', 'options')){ the_row();
  	$section_id = get_sub_field('seating_section_id'); // text field
  	$section_photo = get_sub_field('seating_section_photo'); // returns Image array
  	$section_description = get_sub_field('seating_section_description'); // Wysiwyg
  ?>
  <div class="gallery-content seatingChart__overlay <?php echo 'seats-' . $section_id; ?>">
    <div class="image">
    	<img src="<?php echo $section_photo['url']; ?>" alt="<?php echo $section_photo['alt']; ?>">
    </div>
    <div class="description">
    	<?php echo $section_description; ?>
    </div>
  </div>
  <?php 
   } // end while
	} // end if
  return ob_get_clean();  
} 
add_shortcode('seating-chart', 'seating_chart');
?>