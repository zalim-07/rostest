<?php
get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <header class="page-header">
            <h1 class="page-title">Наши доктора</h1>
        </header>

        <div class="doctors-filters">
            <form method="get" action="<?php echo esc_url(get_post_type_archive_link('doctors')); ?>">
                
                <div class="filter-item">
                    <label for="specialization">Специализация:</label>
                    <select name="specialization" id="specialization">
                        <option value="">Все специализации</option>
                        <?php
                        $specializations = get_terms(array(
                            'taxonomy' => 'specialization',
                            'hide_empty' => true,
                        ));
                        if ($specializations && !is_wp_error($specializations)) :
                            foreach ($specializations as $spec) :
                                $selected = (isset($_GET['specialization']) && $_GET['specialization'] == $spec->slug) ? 'selected' : '';
                                ?>
                                <option value="<?php echo esc_attr($spec->slug); ?>" <?php echo $selected; ?>>
                                    <?php echo esc_html($spec->name); ?>
                                </option>
                            <?php endforeach;
                        endif;
                        ?>
                    </select>
                </div>

                <div class="filter-item">
                    <label for="city">Город:</label>
                    <select name="city" id="city">
                        <option value="">Все города</option>
                        <?php
                        $cities = get_terms(array(
                            'taxonomy' => 'city',
                            'hide_empty' => true,
                        ));
                        if ($cities && !is_wp_error($cities)) :
                            foreach ($cities as $city) :
                                $selected = (isset($_GET['city']) && $_GET['city'] == $city->slug) ? 'selected' : '';
                                ?>
                                <option value="<?php echo esc_attr($city->slug); ?>" <?php echo $selected; ?>>
                                    <?php echo esc_html($city->name); ?>
                                </option>
                            <?php endforeach;
                        endif;
                        ?>
                    </select>
                </div>

                <div class="filter-item">
                    <label for="sort">Сортировка:</label>
                    <select name="sort" id="sort">
                        <option value="">По умолчанию</option>
                        <option value="rating_desc" <?php selected(isset($_GET['sort']) ? $_GET['sort'] : '', 'rating_desc'); ?>>
                            По рейтингу (убывание)
                        </option>
                        <option value="price_asc" <?php selected(isset($_GET['sort']) ? $_GET['sort'] : '', 'price_asc'); ?>>
                            По цене (возрастание)
                        </option>
                        <option value="experience_desc" <?php selected(isset($_GET['sort']) ? $_GET['sort'] : '', 'experience_desc'); ?>>
                            По стажу (убывание)
                        </option>
                    </select>
                </div>

                <div class="filter-item">
                    <button type="submit" class="filter-submit">Применить</button>
                    <a href="<?php echo esc_url(get_post_type_archive_link('doctors')); ?>" class="filter-reset">Сбросить</a>
                </div>
            </form>
        </div>

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

<?php get_footer(); ?>
