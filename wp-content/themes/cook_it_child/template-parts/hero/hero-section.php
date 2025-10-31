<?php
/**
 * Hero Section Template
 *
 * @package cook_it_child
 */
?>

<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <span class="badge">онлайн в любое время</span>
                <span class="badge">от 1500₽ за сессию</span>

                <h1 class="hero-title">К СЕБЕ – Найдите психолога за несколько минут</h1>
                <p class="hero-subtitle">Агрегатор К СЕБЕ. Подбор лучших психологов России</p>

                <div class="search-box">
                    <div class="select-wrapper">
                        <select>
                            <option value="">Что вас беспокоит?</option>
                            <option value="relationships">Трудности в отношениях</option>
                            <option value="anxiety">Тревожность</option>
                            <option value="depression">Депрессия</option>
                            <option value="children">Сложности с детьми</option>
                            <option value="family">Конфликты в семье</option>
                            <option value="other">Другие проблемы</option>
                        </select>
                    </div>

                    <button class="search-button">Начать поиск</button>

                    <p class="privacy-notice">
                        Заходя на сайт, вы даёте согласие на использование файлов cookie и иных данных в соответствии с <a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Политикой</a>
                    </p>
                    <button class="accept-button">Принять</button>
                </div>
            </div>

            <div class="hero-illustration">
                <svg viewBox="0 0 500 500" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Hand 1 -->
                    <path d="M150 100 Q180 120, 200 150 L220 180 Q210 200, 180 190 L160 170 Q140 140, 150 100" stroke="#1a1a1a" stroke-width="2" fill="#FFE5CC"></path>
                    <path d="M200 150 L210 165 Q215 175, 220 180" stroke="#1a1a1a" stroke-width="2" fill="none"></path>
                    <path d="M180 190 L185 200 Q190 205, 195 210" stroke="#1a1a1a" stroke-width="2" fill="none"></path>

                    <!-- Hand 2 -->
                    <path d="M350 120 Q330 140, 320 170 L310 200 Q325 215, 350 200 L365 175 Q380 145, 350 120" stroke="#1a1a1a" stroke-width="2" fill="#FFE5CC"></path>
                    <path d="M320 170 L315 185 Q312 195, 310 200" stroke="#1a1a1a" stroke-width="2" fill="none"></path>

                    <!-- Flower 1 -->
                    <circle cx="420" cy="200" r="25" fill="#FF9966" opacity="0.8"></circle>
                    <circle cx="405" cy="215" r="25" fill="#FF9966" opacity="0.8"></circle>
                    <circle cx="435" cy="215" r="25" fill="#FF9966" opacity="0.8"></circle>
                    <circle cx="420" cy="230" r="25" fill="#FF9966" opacity="0.8"></circle>
                    <circle cx="420" cy="215" r="15" fill="#FFA347"></circle>

                    <!-- Flower 2 -->
                    <circle cx="450" cy="170" r="20" fill="#FF9966" opacity="0.6"></circle>
                    <circle cx="438" cy="182" r="20" fill="#FF9966" opacity="0.6"></circle>
                    <circle cx="462" cy="182" r="20" fill="#FF9966" opacity="0.6"></circle>
                    <circle cx="450" cy="194" r="20" fill="#FF9966" opacity="0.6"></circle>
                    <circle cx="450" cy="182" r="12" fill="#FFA347"></circle>

                    <!-- Leaves -->
                    <ellipse cx="380" cy="280" rx="35" ry="15" fill="#A8D5A8" opacity="0.7" transform="rotate(-45 380 280)"></ellipse>
                    <ellipse cx="410" cy="300" rx="40" ry="18" fill="#A8D5A8" opacity="0.7" transform="rotate(-30 410 300)"></ellipse>
                    <ellipse cx="440" cy="320" rx="30" ry="12" fill="#A8D5A8" opacity="0.7" transform="rotate(-60 440 320)"></ellipse>

                    <!-- Connecting elements -->
                    <path d="M200 250 Q250 240, 300 260" stroke="#E8E8E8" stroke-width="3" fill="none" stroke-dasharray="5,5"></path>
                    <path d="M220 180 Q280 200, 310 200" stroke="#E8E8E8" stroke-width="2" fill="none"></path>
                </svg>
            </div>
        </div>
    </div>
</section>
