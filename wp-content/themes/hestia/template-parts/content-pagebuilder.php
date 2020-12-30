<?php
/**
 * The default template for displaying content on page builders templates.
 *
 * Used for page builder full width and page builder blank.
 *
 * @package Hestia
 * @since Hestia 1.1.24
 * @author Themeisle
 */ 
global $post;
    $post_slug = $post->post_name;

?>

<style>
.hestia-title:first-letter{ 
    text-transform: capitalize 
} 

</style>
		<div id="primary" class=" page-header header-small" data-parallax="active">
					<div class="container"><div class="row"><div class="col-md-10 col-md-offset-1 text-center">
						<h1 class="hestia-title"><?php echo $post->post_name ?></h1>
					</div>
				</div>
				</div>
			<div class="header-filter header-filter-gradient">
			</div>
		</div>
<article id="post-<?php the_ID(); ?>" class="section pagebuilder-section">
	<?php the_content(); ?>
</article>
