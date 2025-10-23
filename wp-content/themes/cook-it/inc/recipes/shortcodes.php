<?php
/**
 * ****************************************************************************
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *   DON'T EDIT THIS FILE
 *
 * *****************************************************************************
 *
 * @package cook-it
 */

/**
 * Ingredients
 */
add_shortcode( 'ingredients', 'shortcode_ingredients' );

function shortcode_ingredients () {
    global $post;
    global $wpshop_advertising;
    global $wpshop_core;

    $out = '';
    $ingredients   = get_post_meta( $post->ID, 'recipe_ingredients', true );
    $recipe_serves = (int)get_post_meta( $post->ID, 'recipe_serves', true );

    $out .= $wpshop_advertising->show_ad( 'before_ingredients' );

	if ( is_feed() ) {

		if ( ! empty( $recipe_serves ) ) {
			$out .= '<p>';
			$out .= __( 'Serves', THEME_TEXTDOMAIN ) . ': ';
			$out .= '<span itemprop="recipeYield">' . $recipe_serves . '</span>';
			$out .= '</p>';
		}

		$out .= '<h2>' . apply_filters( THEME_SLUG . '_ingredients_title', __( 'Ingredients', THEME_TEXTDOMAIN ) ) . '</h2>';

		if ( ! empty( $ingredients ) ) {

			$out .= '<ul>';
			foreach ( $ingredients as $ingredient ) {
				$ingredient_name = $ingredient['name'];

				if ( $ingredient['count'] == 'separator' ) {
					$out .= '<li>' . $ingredient['name'] . '</li>';
				} else {
					$out .= '<li itemprop="recipeIngredient">';
					$out .= $ingredient_name . ' ';
                    if ( ! empty( $ingredient['count'] ) ) $out .= ingredient_count_prepare( $ingredient['count'] ) . ' ';
					$out .= $ingredient['text'];
					$out .= '</li>';
				}
			}
			$out .= '</ul>';

		}

	} else {

		$out .= '<div class="recipe-info">';

		$out .= '<div class="ingredients-header">';
		$out .= '<div class="ingredients-header__title">' . apply_filters( THEME_SLUG . '_ingredients_title', __( 'Ingredients', THEME_TEXTDOMAIN ) ) . '</div>';

		if ( ! empty( $recipe_serves ) ) {
			$out .= '<div class="ingredients-header__serves">';
			$out .= __( 'Serves', THEME_TEXTDOMAIN ) . ': ';
			if ( is_feed() ) {
				$out .= '<span>' . $recipe_serves . '</span>';
			} else {
				$out .= '<span class="ingredients-serves ingredients-serves--minus js-ingredients-serves-minus">–</span>';
				$out .= '<input type="number" min="1" max="100" step="1" class="js-ingredients-serves" value="' . $recipe_serves . '" data-serves="' . $recipe_serves . '">';
				$out .= '<span class="ingredients-serves ingredients-serves--plus js-ingredients-serves-plus">+</span>';
				$out .= '<span itemprop="recipeYield" style="display: none;">' . $recipe_serves . '</span>';
			}
			$out .= '</div>';
		}

		$out .= '</div>';

		if ( ! empty( $ingredients ) ) {

			$out .= '<div class="ingredients js-ingredients">';
			$out .= '<ul class="ingredients-list">';

			foreach ( $ingredients as $ingredient ) {

				$ingredient_name = $ingredient['name'];
				if ( ! empty( $ingredient['term'] ) ) {
//                    $ingredient_term = get_term_by( 'id', $ingredient['term'], 'ingredients' );
//                    $link = get_term_link( (int) $ingredient['term'], 'ingredients' );

					if ( $wpshop_core->get_option( 'ingredients_link' ) ) {
						$ingredient_name = '<a href="' . get_term_link( (int) $ingredient['term'], 'ingredients' ) . '">' . $ingredient['name'] . '</a>';
					} else {
						$ingredient_name = $ingredient['name'];
					}
				}

				if ( $ingredient['count'] == 'separator' ) {
					$out .= '<li class="separator">' . $ingredient['name'] . '</li>';
				} else {
					$out .= '<li itemprop="recipeIngredient">';
					$out .= '<span class="ingredients__name">' . $ingredient_name . '</span> ';
                    if ( ! empty( $ingredient['count'] ) ) {
                        $out .= '<span class="ingredients__count">';
                        $out .= '<span class="js-ingredient-count" data-count="' . ingredient_count_prepare_num( $ingredient['count'] ) . '">' . ingredient_count_prepare( $ingredient['count'] ) . '</span>&nbsp;';
                    }
                    $out .= $ingredient['text'] . '</span>';
					$out .= '</li>';
				}

			}

			$out .= '</ul>';
			$out .= '</div>';

		}

		$recipe_calories      = get_post_meta( $post->ID, 'recipe_calories', true );
		$recipe_proteins      = get_post_meta( $post->ID, 'recipe_proteins', true );
		$recipe_fats          = get_post_meta( $post->ID, 'recipe_fats', true );
		$recipe_carbohydrates = get_post_meta( $post->ID, 'recipe_carbohydrates', true );

        $gram_text = apply_filters( THEME_SLUG . '_ingredients_nutrition_gram', __( 'g', THEME_TEXTDOMAIN ) );

		if ( ! empty( $recipe_calories ) || ! empty( $recipe_proteins ) || ! empty( $recipe_fats ) || ! empty( $recipe_carbohydrates ) ) {
			$out .= '<div class="nutritional" itemprop="nutrition" itemscope itemtype="http://schema.org/NutritionInformation">';
			$out .= '<div class="nutritional__header">' . apply_filters( THEME_SLUG . '_nutritional_title', __( 'Per serving', THEME_TEXTDOMAIN ) ) . '</div>';

		if ( ! empty( $recipe_calories ) ) {
   $out .= '<div class="nutritional-list"><span>Часы работы</span> <span itemprop="calories"><span class="strong">' . $recipe_calories . '</span> ' . __( '', THEME_TEXTDOMAIN ) . '</span></div>';
}
if ( ! empty( $recipe_proteins ) ) {
   $out .= '<div class="nutritional-list"><span>Телефон</span> <span itemprop="proteinContent"><span class="strong">' . $recipe_proteins . '</span> ' . $gram_text . '</span></div>';
}
if ( ! empty( $recipe_fats ) ) {
   $out .= '<div class="nutritional-list"><span>Адрес</span> <span itemprop="fatContent"><span class="strong">' . $recipe_fats . '</span> ' . $gram_text . '</span></div>';
}
if ( ! empty( $recipe_carbohydrates ) ) {
   $out .= '<div class="nutritional-list"><span>Цена</span> <span itemprop="carbohydrateContent"><span class="strong">' . $recipe_carbohydrates . '</span> ' . $gram_text . '</span></div>';
}

			$out .= '</div>';
		}

		$out .= '</div>';

	} // not feed

    $out .= $wpshop_advertising->show_ad( 'after_ingredients' );

    return $out;
}


/**
 * Steps
 */
add_shortcode( 'steps', 'shortcode_steps' );

function shortcode_steps () {
    global $post;
    global $wpshop_core;
    global $wpshop_advertising;

    $structure_single_hide = $wpshop_core->get_option( 'structure_single_hide' );
    if ( ! empty( $structure_single_hide ) ) {
        $structure_single_hide = explode( ',', $structure_single_hide );
    } else {
        $structure_single_hide = array();
    }

    $out = '';
    $steps                = get_post_meta( $post->ID, 'recipe_steps', true );
    $is_show_cooking_time = ( ! in_array( 'cooking_time', $structure_single_hide ) );
    $recipe_video_link    = get_post_meta( $post->ID, 'recipe_video_link', true );

    $cook_time = cook_time_prepare();

    $recipe_prep_time = (int) get_post_meta( $post->ID, 'recipe_prep_time', true );
    $recipe_cook_time = (int) get_post_meta( $post->ID, 'recipe_cook_time', true );

    $recipe_total_time = $recipe_prep_time + $recipe_cook_time;

    if ( ! empty( $steps ) ) {

	    if ( is_feed() ) {

		    if ( ! empty( $cook_time ) && $is_show_cooking_time ) {
			    $out .= '<p>' . cook_time_prepare() . '</p>';
		    }

		    if ( ! empty( $recipe_video_link ) ) {
			    $out .= '<p>';
			    $out .= '<a href="' . $recipe_video_link . '">' . __( 'Video recipe', THEME_TEXTDOMAIN ) . '</a>';
			    $out .= '</p>';
		    }

		    $out .= '<h2>';
		    $out .= apply_filters( THEME_SLUG . '_steps_title', __( 'Method', THEME_TEXTDOMAIN ) );
		    $out .= '</h2>';

		    $out .= apply_filters( THEME_SLUG . '_before_steps', '' );

		    $out .= '<ul>';

		    foreach ( $steps as $step ) :
			    $out             .= '<li>';
			    $image_thumbnail = wp_get_attachment_image_src( $step['photo'], apply_filters( THEME_SLUG . '_steps_thumbnail', 'thumb-wide' ) );
			    $image_full      = wp_get_attachment_image_src( $step['photo'], 'full' );
			    $image_alt       = get_post_meta( $step['photo'], '_wp_attachment_image_alt', true );

			    if ( ! empty( $image_thumbnail[0] ) ) {
				    $out .= '<p><a href="' . $image_full[0] . '"><img src="' . $image_thumbnail[0] . '" alt="' . $image_alt . '"></a></p>';
			    }
			    $out .= $step['text'];
			    $out .= '</li>';
		    endforeach;

		    $out .= '</ul>';

	    } else {

		    $out .= '<div class="steps-header">';
		    $out .= '<div class="steps-header__title">';
		    $out .= apply_filters( THEME_SLUG . '_steps_title', __( 'Method', THEME_TEXTDOMAIN ) );
		    $out .= '</div>';
		    $out .= '<div class="steps-header__meta">';
		    if ( ! empty( $cook_time ) && $is_show_cooking_time ) {
			    $out .= '<span class="meta-cooking-time"><span itemprop="totalTime" content="PT' . $recipe_total_time . 'M">' . cook_time_prepare() . '</span></span>';
		    }
		    if ( ! empty( $recipe_video_link ) ) {
			    $out .= '<span class="meta-play js-recipe-video-open">' . apply_filters( THEME_SLUG . '_video_title', __( 'Video recipe', THEME_TEXTDOMAIN ) ) . '</span>';
		    }
		    $out .= '<span class="meta-print js-print">' . __( 'Print', THEME_TEXTDOMAIN ) . '</span>';
		    $out .= '</div>';
		    $out .= '</div>';

		    if ( ! empty( $recipe_video_link ) ) {
		        $yt_pattern = '#^https?://(?:www\.)?(?:youtube\.com/watch|youtu\.be/)#';
		        $is_youtube = ( preg_match( $yt_pattern, $recipe_video_link ) );

		        $out .= '<div class="recipe-video js-recipe-video">';

		        if ( ! $is_youtube ) {
		            $out .= wp_video_shortcode( array( 'src' => $recipe_video_link, 'width' => 676, 'height' => 380 ) );
		        } else {
		            $recipe_video_link = str_replace( 'watch?v=', 'embed/', $recipe_video_link );
		            $recipe_video_link = str_replace( 'youtu.be', 'www.youtube.com/embed', $recipe_video_link );

                    if ( ! wp_is_mobile() ) {
                        $out .= '<iframe width="676" height="380" src="' . $recipe_video_link . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                    } else {
                        $out .= '<iframe src="' . $recipe_video_link . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                    }
		        }

		        $out .= '</div>';
		    }

		    $out .= apply_filters( THEME_SLUG . '_before_steps', '' );

		    $out .= '<ul class="recipe-steps">';

		    $text = '';
		    $n = 0;

		    foreach ( $steps as $step ) :

                $n++;

			    $out .= '<li itemprop="recipeInstructions">';
			    $image_thumbnail = wp_get_attachment_image_src( $step['photo'], apply_filters( THEME_SLUG . '_steps_thumbnail', 'thumb-wide' ) );
			    $image_full      = wp_get_attachment_image_src( $step['photo'], 'full' );
			    $image_alt       = get_post_meta( $step['photo'], '_wp_attachment_image_alt', true );

                if ( apply_filters( THEME_SLUG . '_steps_thumbnail_microdata', true ) ) {
                    $image_micro = 'itemprop="image"';
                } else {
                    $image_micro = '';
                }

                if ( ! empty( $image_thumbnail[0] ) ) {
				    $out .= '<div class="recipe-steps__photo"><a href="' . $image_full[0] . '" data-title="' . esc_attr( strip_tags( $step['text'] ) ) . '" data-photo-group="steps"><img src="' . $image_thumbnail[0] . '" ' . $image_micro . ' alt="' . $image_alt . '"></a></div>';
			    }

			    $out .= '<div class="recipe-steps__text">' . $step['text'] . '</div>';
			    $out .= '</li>';

                $out .= apply_filters( THEME_SLUG . '_after_recipe_steps', $text, $n );

		    endforeach;

		    $out .= '</ul>';

	    } // not feed
    }

    $out .= $wpshop_advertising->show_ad( 'after_steps' );

    return $out;
}
