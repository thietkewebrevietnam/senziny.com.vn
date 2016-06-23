<?php get_header('404'); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main container" role="main">

        <section class="not-found text-center">
            <h1 class="page-title">404</h1>

            <div class="page-content">
                <p class="intro"><?php esc_html_e( 'oops! This page could not be found!', 'zidane' ); ?></p>

                <?php get_search_form(); ?>
            </div><!-- .page-content -->
        </section><!-- .error-404 -->

    </main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
