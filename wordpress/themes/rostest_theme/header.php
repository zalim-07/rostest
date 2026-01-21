<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <div id="page" class="site">
        <header id="masthead" class="site-header">
            <div class="container">
                <div class="site-header-content">
                    <div class="site-branding">
                        <h1 class="site-title">
                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                <?php bloginfo('name'); ?>
                            </a>
                        </h1>
                        <p class="site-description"><?php bloginfo('description'); ?></p>
                    </div>

                    <nav id="site-navigation" class="main-navigation">
                        <?php if (has_nav_menu('rostest-menu-1')) : ?>
                            <?php
                            wp_nav_menu(
                                array(
                                    'theme_location' => 'rostest-menu-1',
                                    'menu_id'        => 'rostest-primary-menu',
                                    'fallback_cb'    => false,
                                )
                            );
                            ?>
                        <?php else : ?>
                            <ul id="rostest-primary-menu" class="menu">
                                <li class="menu-item"><a href="http://localhost:8080/">Главная</a></li>
                                <li class="menu-item"><a href="/doctors">Доктора</a></li>
                            </ul>
                        <?php endif; ?>
                    </nav>
                </div>
            </div>
        </header>

        <div id="content" class="site-content">