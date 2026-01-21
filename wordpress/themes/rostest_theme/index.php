<?php
get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="doctors-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('doctor-card'); ?>>

                        <?php if (has_post_thumbnail()) : ?>
                            <div class="doctor-card-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="doctor-card-content">
                            <h2 class="doctor-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>

                            <?php
                            $specializations = get_the_terms(get_the_ID(), 'specialization');
                            if ($specializations && !is_wp_error($specializations)) :
                                $spec_array = array_slice($specializations, 0, 2);
                            ?>
                                <div class="doctor-card-specialization">
                                    <?php
                                    foreach ($spec_array as $spec) {
                                        echo '<span class="spec-badge">' . esc_html($spec->name) . '</span>';
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>

                            <div class="doctor-card-meta">
                                <?php
                                $experience = get_field('doctor_experience');
                                $price = get_field('doctor_price_from');
                                $rating = get_field('doctor_rating');
                                ?>

                                <?php if ($experience) : ?>
                                    <div class="doctor-card-meta-item">
                                        <strong>Стаж:</strong> <?php echo esc_html($experience); ?> лет
                                    </div>
                                <?php endif; ?>

                                <?php if ($price) : ?>
                                    <div class="doctor-card-meta-item">
                                        <strong>Цена от:</strong> <?php echo esc_html(number_format($price, 0, '', ' ')); ?> ₽
                                    </div>
                                <?php endif; ?>

                                <?php if ($rating) : ?>
                                    <div class="doctor-card-meta-item">
                                        <strong>Рейтинг:</strong> <?php echo esc_html($rating); ?> / 5
                                    </div>
                                <?php endif; ?>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="doctor-card-link">Подробнее</a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php
            $pagination_args = array(
                'mid_size' => 2,
                'prev_text' => '&laquo; Предыдущая',
                'next_text' => 'Следующая &raquo;',
            );

            if (!empty($_GET['specialization']) || !empty($_GET['city']) || !empty($_GET['sort'])) {
                $pagination_args['add_args'] = array(
                    'specialization' => isset($_GET['specialization']) ? $_GET['specialization'] : '',
                    'city' => isset($_GET['city']) ? $_GET['city'] : '',
                    'sort' => isset($_GET['sort']) ? $_GET['sort'] : '',
                );
            }

            the_posts_pagination($pagination_args);
            ?>

        <?php else : ?>
            <p>Докторов не найдено.</p>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
