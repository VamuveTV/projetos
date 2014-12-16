<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package theretailer
 * @since theretailer 1.0
 */

get_header(); ?>

<div class="container_12">

    <div class="grid_12">
    	
        <div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

                <div class="entry-content page_404">
                
                    <div class="img_404"></div>
                    
                    	<h3><?php _e( 'Esta página não existe. <br />Voltar para', 'theretailer' ); ?> <a href="<?php echo home_url(); ?>"><?php _e( 'home', 'theretailer' ); ?></a>.</h3>
                    
                    </div>
        
        	</div>
		</div>			
    
    </div>
    
</div>

<!--Mobile trigger footer widgets-->
<?php global $theretailer_theme_options; ?>

<?php if ( 	(!$theretailer_theme_options['dark_footer_all_site']) ||
			($theretailer_theme_options['dark_footer_all_site'] == 0) ) : ?>
				<div class="trigger-footer-widget-area">
					<i class="getbowtied-icon-more-retailer"></i>
				</div>
<?php endif; ?>

<div class="gbtr_widgets_footer_wrapper">

<?php get_template_part("dark_footer"); ?>

<?php get_footer(); ?>