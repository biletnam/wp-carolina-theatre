<?php 
// Get current page URL 
$socialShareURL = get_permalink();

// Get current page title
$sst_string = '';
$sst_string .= get_the_title();
$sst_string .= ' at The Carolina Theatre of Durham';
$sst_string = str_replace('&#038;', 'and', $sst_string);
$sst_string = str_replace( ' ', '%20', $sst_string); 
$socialShareTitle = $sst_string;

// Get Post Thumbnail for pinterest
// $image = get_sub_field('item_image');
// $socialShareThumbnail = $image['url'];

// Construct sharing URL without using any script
$twitterURL = 'https://twitter.com/intent/tweet?text='.$socialShareTitle.'&url='.$socialShareURL;
$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$socialShareURL;
$googleURL = 'https://plus.google.com/share?url='.$socialShareURL.'&text='.$socialShareTitle;
$redditURL = 'https://reddit.com/submit?url='.$socialShareURL.'&title='.$socialShareTitle;
// $bufferURL = 'https://bufferapp.com/add?url='.$socialShareURL.'&text='.$socialShareTitle;
// $whatsappURL = 'whatsapp://send?text='.$socialShareTitle . ' ' . $socialShareURL;
// $linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$socialShareURL.'&title='.$socialShareTitle;
// $pinterestURL = 'http://pinterest.com/pin/create/button/?url='.$socialShareURL.'&media='.$socialShareThumbnail.'&description='.$socialShareTitle;

// Add sharing button at the end of page/page content
$content = '';
$content .= '<div class="socialShare__social">';
$content .= '<a class="socialShare__link socialShare--facebook" title="Share on Facebook" href="'.$facebookURL.'" target="_blank"><i class="fab fa-facebook-f"></i></a>';
$content .= '<a class="socialShare__link socialShare--twitter" title="Share on Twitter" href="'. $twitterURL .'" target="_blank"><i class="fab fa-twitter"></i></a>';
$content .= '<a class="socialShare__link socialShare--googleplus" title="Share on Google+" href="'.$googleURL.'" target="_blank"><i class="fab fa-google-plus"></i></a>';
$content .= '<a class="socialShare__link socialShare--reddit" title="Share on Reddit" href="'.$redditURL.'" target="_blank"><i class="fab fa-reddit"></i></a>';
// $content .= '<a class="socialShare__link socialShare--linkedin" href="'.$linkedInURL.'" target="_blank"><i class="fab fa-linkedin"></i></a>';
// $content .= '<a class="socialShare__link socialShare--pinterest" href="'.$pinterestURL.'" data-pin-custom="true" target="_blank"><i class="fab fa-pinterest"></i> Pin It</a>';
$content .= '</div>';

echo $content;
?>