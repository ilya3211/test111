<?php
/**
 * Custom Header Template for К себе
 *
 * @package cook_it_child
 */

global $wpshop_core;
?>

<?php do_action( THEME_SLUG . '_before_header' ) ?>

<header id="masthead" class="site-header" itemscope itemtype="http://schema.org/WPHeader">
    <div class="container">
        <div class="header-content">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
                <svg width="35" height="35" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="20" cy="20" r="18" fill="#FFE5CC"/>
                    <path d="M20 10C20 10 15 15 15 20C15 25 17.5 27.5 20 27.5C22.5 27.5 25 25 25 20C25 15 20 10 20 10Z" fill="#FF9966"/>
                </svg>
                К себе
            </a>
            <nav>
                <ul class="nav-menu">
                    <li><a href="#">Выбрать психолога</a></li>
                    <li><a href="#">Специалистам</a></li>
                    <li><a href="#">Блог</a></li>
                    <li><a href="#">О нас</a></li>
                    <li><a href="#">Отзывы</a></li>
                    <li><a href="#">Избранное ♡</a></li>
                </ul>
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <ul class="nav-menu mobile">
                    <li><a href="#">Выбрать психолога</a></li>
                    <li><a href="#">Специалистам</a></li>
                    <li><a href="#">Блог</a></li>
                    <li><a href="#">О нас</a></li>
                    <li><a href="#">Отзывы</a></li>
                    <li><a href="#">Избранное ♡</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<?php do_action( THEME_SLUG . '_after_header' ) ?>
