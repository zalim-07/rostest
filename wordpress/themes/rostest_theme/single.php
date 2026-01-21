<?php
get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <?php
        while ( have_posts() ) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-meta">
                        <span class="posted-on"><?php echo get_the_date(); ?></span>
                        <span class="byline"> by <?php the_author(); ?></span>
                    </div>
                </header>

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="post-thumbnail">
                        <?php the_post_thumbnail( 'large' ); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

                <footer class="entry-footer">
                    <?php
                    the_tags( '<span class="tags-links">Tags: ', ', ', '</span>' );
                    ?>
                </footer>
            </article>

            <?php
            the_post_navigation(
                array(
                    'prev_text' => '<span class="nav-subtitle">Предыдущая:</span> <span class="nav-title">%title</span>',
                    'next_text' => '<span class="nav-subtitle">Следующая:</span> <span class="nav-title">%title</span>',
                )
            );

            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;

        endwhile;
        ?>
    </div>
</main>

<?php
get_footer();
