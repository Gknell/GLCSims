<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Custom_Sims
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif; ?>
	</header><!-- .entry-header -->
	
	
	<?php if ( has_post_thumbnail()){ ?>
		<figure class="featured-image full-bleed">
		<?php the_post_thumbnail('customsims-full-bleed'); ?>
		</figure>
	<?php } ?>
	
	<section class="post-content">

		<div class="post-content__wrap">
			<div class="entry-meta">
				<?php
				customsims_posted_on();
				customsims_posted_by();
				customsims_entry_tags();
				?>
			</div><!-- .entry-meta -->
			<div class="post-content__body">			
				<div class="entry-content">
					<?php
					the_content( sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'customsims' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					) );

					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'customsims' ),
						'after'  => '</div>',
					) );
					?>
				</div><!-- .entry-content -->
				<footer class="entry-footer">
					<?php 
						the_post_navigation();
					?>
				</footer><!-- .entry-footer -->
			</div> <!-- end .post-content__body -->
		</div>
	<?php
	// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
	?>
</section>
</article><!-- #post-<?php the_ID(); ?> -->
