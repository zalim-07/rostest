<?php
get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('doctor-single'); ?>>
                
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="doctor-thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <?php if (has_excerpt()) : ?>
                    <div class="doctor-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                <?php endif; ?>

                <div class="doctor-content">
                    <?php the_content(); ?>
                </div>

                <div class="doctor-meta">
                    <h2>Информация</h2>
                    
                    <?php 
                    $experience = get_field('doctor_experience');
                    $price = get_field('doctor_price_from');
                    $rating = get_field('doctor_rating');
                    ?>

                    <?php if ($experience) : ?>
                        <div class="doctor-meta-item">
                            Стаж врача, лет: <strong><?php echo esc_html($experience); ?></strong>
                        </div>
                    <?php endif; ?>

                    <?php if ($price) : ?>
                        <div class="doctor-meta-item">
                            Цена от, Руб: <strong><?php echo esc_html(number_format($price, 0, '', ' ')); ?></strong>
                        </div>
                    <?php endif; ?>

                    <?php if ($rating) : ?>
                        <div class="doctor-meta-item">
                            Рейтинг: <strong><?php echo esc_html($rating); ?></strong>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="doctor-taxonomies">
                    <?php 
                    $specializations = get_the_terms(get_the_ID(), 'specialization');
                    if ($specializations && !is_wp_error($specializations)) : ?>
                        <div class="doctor-specializations">
                            Специализация: <strong><?php echo esc_html($spec->name); ?></strong>
                            <?php 
                            $spec_list = array();
                            foreach ($specializations as $spec) {
                                $spec_list[] = '<a href="' . get_term_link($spec) . '">' . esc_html($spec->name) . '</a>';
                            }
                            echo implode(', ', $spec_list);
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php 
                    $cities = get_the_terms(get_the_ID(), 'city');
                    if ($cities && !is_wp_error($cities)) : ?>
                        <div class="doctor-cities">
                            Город: <strong><?php echo esc_html($city->name); ?></strong>
                            <?php 
                            $city_list = array();
                            foreach ($cities as $city) {
                                $city_list[] = '<a href="' . get_term_link($city) . '">' . esc_html($city->name) . '</a>';
                            }
                            echo implode(', ', $city_list);
                            ?>
                        </div>
                    <?php endif; ?>
                </div>

            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
