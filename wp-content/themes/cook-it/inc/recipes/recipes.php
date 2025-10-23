<?php


/* ==========================================================================
   Recipes
   ========================================================================== */


/**
 * Admin CSS and JS
 */
add_action( 'admin_enqueue_scripts', 'load_admin_style' );
function load_admin_style() {
    wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/inc/recipes/css/admin-style.css', false, '1.0.0' );
}


add_action( 'admin_enqueue_scripts', 'load_admin_js' );
function load_admin_js() {
    wp_enqueue_script( 'admin_js', get_template_directory_uri() . '/inc/recipes/js/admin-scripts.js' );
}



/**
 * Подключаем загрузку файлов
 */
function update_edit_form()
{
    echo ' enctype="multipart/form-data"';
}
add_action( 'post_edit_form_tag', 'update_edit_form' );







class Recipe_Ingredients_Meta_Box {

    private $nonce        = 'ingredients_nonce';
    private $nonce_action = 'ingredients_nonce_action';

    public function __construct() {
        if ( is_admin() ) {
            add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
            add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
        }
    }

    public function init_metabox() {
        add_action( 'add_meta_boxes', array( $this, 'add_metabox'  )        );
        add_action( 'save_post',      array( $this, 'save_metabox' ), 10, 2 );
    }

    public function add_metabox() {
        add_meta_box(
            'ingredients',
            __( 'Ingredients', THEME_TEXTDOMAIN ),
            array( $this, 'render_metabox' ),
            'post',
            'advanced',
            'default'
        );
    }

    public function render_metabox( $post ) {

        // Add nonce for security and authentication.
        wp_nonce_field( $this->nonce_action, $this->nonce );

        // Retrieve an existing value from the database.
        $ingredients = get_post_meta( $post->ID, 'recipe_ingredients', true );

        echo '<div class="admin-ingredients__header">';
        echo '<div class="admin-ingredients__1"></div>';
        echo '<div class="admin-ingredients__2">' . __( 'Ingredient name', THEME_TEXTDOMAIN ) . '</div>';
        echo '<div class="admin-ingredients__term"></div>';
        echo '<div class="admin-ingredients__3">' . __( 'Number of', THEME_TEXTDOMAIN ) . '</div>';
        echo '<div class="admin-ingredients__4">' . __( 'Unit of measurement', THEME_TEXTDOMAIN ) . '</div>';
        echo '</div>';

        echo '<ul class="admin-ingredients js-admin-ingredients">';

        if ( ! empty( $ingredients ) ) {

            foreach ( $ingredients as $ingredient ) {

                $ingredient_active_term = '';
                $ingredient_term_title  = '';

                if ( ! empty( $ingredient['term'] ) ) {
                    $ingredient_active_term =  ' active';
                    $ingredient_term = get_term_by( 'id', $ingredient['term'], 'ingredients' );
                    if ( ! empty( $ingredient_term->name ) ) $ingredient_term_title = $ingredient_term->name;
                    $term = $ingredient['term'];
                } else {
	                $term = '';
                }

                echo '<li>';
                echo '<div class="admin-ingredients__1"></div>';
                if ( $ingredient['count'] == 'separator' ) { $styles = ' style="display:none;"'; } else { $styles = ''; }
                echo '<div class="admin-ingredients__2"><input class="js-ingredients-name" name="ingridients-name[]" type="text" value="' . $ingredient['name'] . '"></div>';
                echo '<div class="admin-ingredients__term"><span class="dashicons dashicons-tag js-ingredients-term-icon'. $ingredient_active_term .'" title="' . $ingredient_term_title . '"></span> <input class="js-ingredients-term" name="ingridients-term[]" type="hidden" value="' . $term . '"></div>';
                echo '<div class="admin-ingredients__3"' . $styles . '>'; if ( isset( $ingredient['count'] ) ) echo '<input name="ingridients-count[]" type="text" value="' . $ingredient['count'] . '" autocomplete="off">'; echo '</div>';
                echo '<div class="admin-ingredients__text"' . $styles . '><input name="ingridients-text[]" type="text" value="' . $ingredient['text'] . '"></div>';
                echo '<div class="admin-ingredients__4"><span class="admin-ingredients-delete js-admin-ingredients-delete">&times;</span></div>';
                echo '</li>';
            }

        } else {
            echo '<li>';
            echo '<div class="admin-ingredients__1"></div>';
            echo '<div class="admin-ingredients__2"><input class="js-ingredients-name" name="ingridients-name[]" type="text" value=""></div>';
            echo '<div class="admin-ingredients__term"><span class="dashicons dashicons-tag"></span> <input class="js-ingredients-term" name="ingridients-term[]" type="hidden" value=""></div>';
            echo '<div class="admin-ingredients__3"><input name="ingridients-count[]" type="text" value="" autocomplete="off"></div>';
            echo '<div class="admin-ingredients__text"><input name="ingridients-text[]" type="text" value=""></div>';
            echo '<div class="admin-ingredients__4"><span class="admin-ingredients-delete js-admin-ingredients-delete">&times;</span></div>';
            echo '</li>';
        }

        echo '</ul>';

        echo '<button class="admin-ingredients-add button js-admin-ingredients-add">'. __( 'Add ingredient', THEME_TEXTDOMAIN ) .'</button>';
        echo '<button class="admin-ingredients-add-sep button js-admin-ingredients-add-sep">'. __( 'Add separator', THEME_TEXTDOMAIN ) .'</button>';

    }

    public function save_metabox( $post_id, $post ) {

        // Add nonce for security and authentication.
        $nonce_name   = ( ! empty( $_POST[ $this->nonce ] ) ) ? $_POST[ $this->nonce ] : '' ;
        $nonce_action = $this->nonce_action;

        // Check if a nonce is set.
        if ( ! isset( $nonce_name ) )
            return;

        // Check if a nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
            return;

        // Check if the user has permissions to save data.
        if ( ! current_user_can( 'edit_post', $post_id ) )
            return;

        // Check if it's not an autosave.
        if ( wp_is_post_autosave( $post_id ) )
            return;

        // Check if it's not a revision.
        if ( wp_is_post_revision( $post_id ) )
            return;

        $ingredients_terms = array();

        $ingredients = array();
        foreach ( $_POST['ingridients-name'] as $key => $value ) {

            $ingredients_term = trim( $_POST['ingridients-term'][$key] );

            $value = trim( $value );
            if ( ! empty( $value ) ) {
                $ingredients[] = array(
                    'name'  => $value,
                    'term'  => $ingredients_term,
                    'count' => trim( $_POST['ingridients-count'][$key] ),
                    'text'  => trim( $_POST['ingridients-text'][$key] ),
                );

                if ( ! empty( $ingredients_term ) && is_numeric( $ingredients_term ) ) $ingredients_terms[] = (int) $ingredients_term;
            }
        }

        update_post_meta( $post_id, 'recipe_ingredients', $ingredients );


        wp_delete_object_term_relationships ( $post_id, 'ingredients' );
        if ( ! empty( $ingredients_terms ) ) {
            wp_set_post_terms( $post_id, $ingredients_terms, 'ingredients', true );
        }

    }

}

new Recipe_Ingredients_Meta_Box;






class Recipe_Nutritional_Meta_Box {

    private $nonce        = 'nutritional_nonce';
    private $nonce_action = 'nutritional_nonce_action';

    public function __construct() {
        if ( is_admin() ) {
            add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
            add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
        }
    }

    public function init_metabox() {
        add_action( 'add_meta_boxes', array( $this, 'add_metabox'  )        );
        add_action( 'save_post',      array( $this, 'save_metabox' ), 10, 2 );
    }

    public function add_metabox() {
        add_meta_box(
            'nutritional',
            __( 'Nutritional value', THEME_TEXTDOMAIN ),
            array( $this, 'render_metabox' ),
            'post',
            'advanced',
            'default'
        );
    }

    public function render_metabox( $post ) {

        // Add nonce for security and authentication.
        wp_nonce_field( $this->nonce_action, $this->nonce );

        // Retrieve an existing value from the database.
        $recipe_calories      = get_post_meta( $post->ID, 'recipe_calories', true );
        $recipe_proteins      = get_post_meta( $post->ID, 'recipe_proteins', true );
        $recipe_fats          = get_post_meta( $post->ID, 'recipe_fats', true );
        $recipe_carbohydrates = get_post_meta( $post->ID, 'recipe_carbohydrates', true );

echo '<table class="form-table">';

echo ' <tr>';
echo '    <th><label for="recipe_calories">' . __( 'Calories', THEME_TEXTDOMAIN ) . '</label></th>';
echo '    <td>';
echo '       <input type="text" id="recipe_calories" name="recipe_calories" value="' . esc_attr__( $recipe_calories ) . '"> ' . __( 'kcal', THEME_TEXTDOMAIN ) . '';
echo '    </td>';
echo ' </tr>';

echo ' <tr>';
echo '    <th><label for="recipe_proteins">' . __( 'Protein', THEME_TEXTDOMAIN ) . '</label></th>';
echo '    <td>';
echo '       <input type="text" id="recipe_proteins" name="recipe_proteins" value="' . esc_attr__( $recipe_proteins ) . '"> ' . __( 'g', THEME_TEXTDOMAIN ) . '';
echo '    </td>';
echo ' </tr>';

echo ' <tr>';
echo '    <th><label for="recipe_fats">' . __( 'Fats', THEME_TEXTDOMAIN ) . '</label></th>';
echo '    <td>';
echo '       <input type="text" id="recipe_fats" name="recipe_fats" value="' . esc_attr__( $recipe_fats ) . '"> ' . __( 'g', THEME_TEXTDOMAIN ) . '';
echo '    </td>';
echo ' </tr>';

echo ' <tr>';
echo '    <th><label for="recipe_carbohydrates">' . __( 'Carbohydrates', THEME_TEXTDOMAIN ) . '</label></th>';
echo '    <td>';
echo '       <input type="text" id="recipe_carbohydrates" name="recipe_carbohydrates" value="' . esc_attr__( $recipe_carbohydrates ) . '"> ' . __( 'g', THEME_TEXTDOMAIN ) . '';
echo '    </td>';
echo ' </tr>';

echo '</table>';

    }

    public function save_metabox( $post_id, $post ) {

        // Add nonce for security and authentication.
        $nonce_name   = ( ! empty( $_POST[ $this->nonce ] ) ) ? $_POST[ $this->nonce ] : '' ;
        $nonce_action = $this->nonce_action;

        // Check if a nonce is set.
        if ( ! isset( $nonce_name ) )
            return;

        // Check if a nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
            return;

        // Check if the user has permissions to save data.
        if ( ! current_user_can( 'edit_post', $post_id ) )
            return;

        // Check if it's not an autosave.
        if ( wp_is_post_autosave( $post_id ) )
            return;

        // Check if it's not a revision.
        if ( wp_is_post_revision( $post_id ) )
            return;

        $recipe_calories      = isset( $_POST['recipe_calories'] ) ? sanitize_text_field( $_POST['recipe_calories'] ) : '';
        $recipe_proteins      = isset( $_POST['recipe_proteins'] ) ? sanitize_text_field( $_POST['recipe_proteins'] ) : '';
        $recipe_fats          = isset( $_POST['recipe_fats'] ) ? sanitize_text_field( $_POST['recipe_fats'] ) : '';
        $recipe_carbohydrates = isset( $_POST['recipe_carbohydrates'] ) ? sanitize_text_field( $_POST['recipe_carbohydrates'] ) : '';

        $recipe_calories      = trim( str_replace( ',', '.', $recipe_calories ) );
        $recipe_proteins      = trim( str_replace( ',', '.', $recipe_proteins ) );
        $recipe_fats          = trim( str_replace( ',', '.', $recipe_fats ) );
        $recipe_carbohydrates = trim( str_replace( ',', '.', $recipe_carbohydrates ) );

        update_post_meta( $post_id, 'recipe_calories', $recipe_calories );
        update_post_meta( $post_id, 'recipe_proteins', $recipe_proteins );
        update_post_meta( $post_id, 'recipe_fats', $recipe_fats );
        update_post_meta( $post_id, 'recipe_carbohydrates', $recipe_carbohydrates );

    }

}

new Recipe_Nutritional_Meta_Box;






class Recipe_Steps_Meta_Box {

    private $nonce        = 'steps_nonce';
    private $nonce_action = 'steps_nonce_action';

    public function __construct() {
        if ( is_admin() ) {
            add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
            add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
        }
    }

    public function init_metabox() {
        add_action( 'add_meta_boxes', array( $this, 'add_metabox'  )        );
        add_action( 'save_post',      array( $this, 'save_metabox' ), 10, 2 );
    }

    public function add_metabox() {
        add_meta_box(
            'steps',
            __( 'Steps', THEME_TEXTDOMAIN ),
            array( $this, 'render_metabox' ),
            'post',
            'advanced',
            'default'
        );
    }

    public function render_metabox( $post ) {

        // Add nonce for security and authentication.
        wp_nonce_field( $this->nonce_action, $this->nonce );

        // Retrieve an existing value from the database.
        $steps = get_post_meta( $post->ID, 'recipe_steps', true );
        if ( ! empty( $steps ) ) {

            echo '<ol class="admin-steps js-admin-steps">';

            echo '<li class="instruction" style="display: none;">';
            echo '<div class="clearfix clear">';
            echo '<div class="admin-ingredients__1"></div>';
            attachment_uploader_field( 'step_photo[]' );
            echo '<input type="hidden" name="step_photo_uploaded" value="">';
            echo '<div class="admin-step-text"><textarea name="step_text[]" rows="4"></textarea></div>';
            echo '<span class="admin-steps-delete js-admin-steps-delete">'. __( 'Remove step', THEME_TEXTDOMAIN ) .'</span>';
            echo '</div>';
            echo '</li>';

            foreach ( $steps as $step ) {
                echo '<li class="instruction">';
                echo '<div class="clearfix clear">';
                echo '<div class="admin-ingredients__1"></div>';
                if ( isset( $step['photo'] ) && ! empty( $step['photo'] ) ) {
                    attachment_uploader_field( 'step_photo[]', $step['photo'] );
                } else {
                    attachment_uploader_field( 'step_photo[]' );
                }
                echo '<div class="admin-step-text"><textarea name="step_text[]" rows="4">' . $step['text'] . '</textarea></div>';
                //echo '<div><select><option>Совет</option></select><input type="text"></div>';
                echo '<span class="admin-steps-delete js-admin-steps-delete">'. __( 'Remove step', THEME_TEXTDOMAIN ) .'</span>';
                echo '</div>';
                echo '</li>';
            }
            echo '</ol>';

            echo '<button class="button admin-steps-add js-admin-steps-add">'. __( 'Add step', THEME_TEXTDOMAIN ) .'</button>';

        } else {
            echo '<ol class="admin-steps js-admin-steps">';
            echo '<li class="instruction">';
            echo '<div class="clearfix clear">';
            echo '<div class="admin-ingredients__1"></div>';
            attachment_uploader_field( 'step_photo[]' );
            echo '<input type="hidden" name="step_photo_uploaded" value="">';
            echo '<div class="admin-step-text"><textarea name="step_text[]" rows="4"></textarea></div>';
            echo '<span class="admin-steps-delete js-admin-steps-delete">'. __( 'Remove step', THEME_TEXTDOMAIN ) .'</span>';
            echo '</div>';
            echo '</li>';
            echo '</ol>';

            echo '<button class="button admin-steps-add js-admin-steps-add">'. __( 'Add step', THEME_TEXTDOMAIN ) .'</button>';
        }

    }

    public function save_metabox( $post_id, $post ) {

        // Add nonce for security and authentication.
        $nonce_name   = ( ! empty( $_POST[ $this->nonce ] ) ) ? $_POST[ $this->nonce ] : '' ;
        $nonce_action = $this->nonce_action;

        // Check if a nonce is set.
        if ( ! isset( $nonce_name ) )
            return;

        // Check if a nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
            return;

        // Check if the user has permissions to save data.
        if ( ! current_user_can( 'edit_post', $post_id ) )
            return;

        // Check if it's not an autosave.
        if ( wp_is_post_autosave( $post_id ) )
            return;

        // Check if it's not a revision.
        if ( wp_is_post_revision( $post_id ) )
            return;


        $steps = array();
        foreach ( $_POST['step_text'] as $key => $value ) {


            // if photo not exist write NULL in meta
            $upload['url'] = '';
            $upload['url'] = $_POST['step_photo'][$key];


            /**
             * If text or photo of current step not exist - skip this step
             */
            if ( ! empty( $upload['url'] ) OR ! empty( $value ) ) {

                $steps[] = array(
                    'text'  => $value,
                    'photo' => $upload['url'],
                );

            }
        }

        update_post_meta( $post_id, 'recipe_steps', $steps );

    }

}

new Recipe_Steps_Meta_Box;







class Recipe_Information_Meta_Box {

    private $nonce        = 'information_nonce';
    private $nonce_action = 'information_nonce_action';

    public function __construct() {
        if ( is_admin() ) {
            add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
            add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
        }
    }

    public function init_metabox() {
        add_action( 'add_meta_boxes', array( $this, 'add_metabox'  )        );
        add_action( 'save_post',      array( $this, 'save_metabox' ), 10, 2 );
    }

    public function add_metabox() {
        add_meta_box(
            'information',
            __( 'Additional information', THEME_TEXTDOMAIN ),
            array( $this, 'render_metabox' ),
            'post',
            'advanced',
            'default'
        );
    }

    public function render_metabox( $post ) {

        // Add nonce for security and authentication.
        wp_nonce_field( $this->nonce_action, $this->nonce );

        // Retrieve an existing value from the database.
        $recipe_prep_time  = get_post_meta( $post->ID, 'recipe_prep_time', true );
        $recipe_cook_time  = get_post_meta( $post->ID, 'recipe_cook_time', true );
        $recipe_serves     = get_post_meta( $post->ID, 'recipe_serves', true );
        $recipe_video_link = get_post_meta( $post->ID, 'recipe_video_link', true );
        $recipe_after_text = get_post_meta( $post->ID, 'recipe_after_text', true );

        echo '<table class="form-table">';

echo '	<tr>';
echo '		<th><label for="recipe_prep_time">' . __( 'Preparation time', THEME_TEXTDOMAIN ) . '</label></th>';
echo '		<td>';
echo '			<input type="text" id="recipe_prep_time" name="recipe_prep_time" value="' . esc_attr__( 'Подготовка блюда' ) . '"> ' . __( 'min.', THEME_TEXTDOMAIN );
echo '          <p class="description">' . __( 'Specify the preparation time before cooking', THEME_TEXTDOMAIN ) . '</p>';
echo '		</td>';
echo '	</tr>';

echo '	<tr>';
echo '		<th><label for="recipe_cook_time">' . __( 'Cooking time', THEME_TEXTDOMAIN ) . '</label></th>';
echo '		<td>';
echo '			<input type="text" id="recipe_cook_time" name="recipe_cook_time" value="' . esc_attr__( 'Приготовление блюда' ) . '"> рублей';
echo '          <p class="description">' . __( 'Specify the cooking time', THEME_TEXTDOMAIN ) . '</p>';
echo '		</td>';
echo '	</tr>';


        echo '	<tr>';
        echo '		<th><label for="recipe_serves">' . __( 'Serves', THEME_TEXTDOMAIN ) . '</label></th>';
        echo '		<td>';
        echo '			<input type="number" step="1" min="0" id="recipe_serves" name="recipe_serves" value="' . esc_attr__( $recipe_serves ) . '">';
        echo '		</td>';
        echo '	</tr>';

        echo '	<tr>';
        echo '		<th><label for="recipe_video_link">' . __( 'Video link', THEME_TEXTDOMAIN ) . '</label></th>';
        echo '		<td>';
        echo '			<input type="text" id="recipe_video_link" name="recipe_video_link" value="' . esc_attr__( $recipe_video_link ) . '" class="widefat">';
        echo '		</td>';
        echo '	</tr>';

        echo '	<tr>';
        echo '		<th><label for="recipe_serves">' . __( 'After steps text', THEME_TEXTDOMAIN ) . '</label></th>';
        echo '		<td>';
        wp_editor( htmlspecialchars_decode( $recipe_after_text ), 'recipe_after_text', $settings = array( 'textarea_name'=>'recipe_after_text' ) );
        echo '		</td>';
        echo '	</tr>';

        echo '</table>';

    }

    public function save_metabox( $post_id, $post ) {

        // Add nonce for security and authentication.
        $nonce_name   = ( ! empty( $_POST[ $this->nonce ] ) ) ? $_POST[ $this->nonce ] : '' ;
        $nonce_action = $this->nonce_action;

        // Check if a nonce is set.
        if ( ! isset( $nonce_name ) )
            return;

        // Check if a nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
            return;

        // Check if the user has permissions to save data.
        if ( ! current_user_can( 'edit_post', $post_id ) )
            return;

        // Check if it's not an autosave.
        if ( wp_is_post_autosave( $post_id ) )
            return;

        // Check if it's not a revision.
        if ( wp_is_post_revision( $post_id ) )
            return;

        $recipe_prep_time  = isset( $_POST['recipe_prep_time'] ) ? (int) sanitize_text_field( $_POST['recipe_prep_time'] ) : '';
        $recipe_cook_time  = isset( $_POST['recipe_cook_time'] ) ? (int) sanitize_text_field( $_POST['recipe_cook_time'] ) : '';
        $recipe_serves     = isset( $_POST['recipe_serves'] ) ? (int) sanitize_text_field( $_POST['recipe_serves'] ) : '';
        $recipe_video_link = isset( $_POST['recipe_video_link'] ) ? sanitize_text_field( $_POST['recipe_video_link'] ) : '';
        $recipe_after_text = isset( $_POST['recipe_after_text'] ) ? htmlspecialchars( $_POST['recipe_after_text'] ) : '';

        update_post_meta( $post_id, 'recipe_prep_time', $recipe_prep_time );
        update_post_meta( $post_id, 'recipe_cook_time', $recipe_cook_time );
        update_post_meta( $post_id, 'recipe_serves', $recipe_serves );
        update_post_meta( $post_id, 'recipe_video_link', $recipe_video_link );
        update_post_meta( $post_id, 'recipe_after_text', $recipe_after_text );

    }

}

new Recipe_Information_Meta_Box;



function ingredient_count_prepare_num( $count ) {
	$count = str_replace(',', '.', $count);

	if ( $count == '1/2' || $count == '½' ) return 0.5;
	if ( $count == '1/3' || $count == '⅓' ) return 0.33;
	if ( $count == '1/4' || $count == '¼' ) return 0.25;
	if ( $count == '1/5' || $count == '⅕') return 0.2;
	if ( $count == '1/6' || $count == '⅙' ) return 0.16;
	if ( $count == '1/7' || $count == '⅐' ) return 0.14;
	if ( $count == '1/8' || $count == '⅛' ) return 0.125;
	if ( $count == '1/9' || $count == '⅑' ) return 0.11;
	if ( $count == '1/10' || $count == '⅒' ) return 0.1;

	if ( $count == '2/3' || $count == '⅔' ) return 0.66;
	if ( $count == '3/4' || $count == '¾' ) return 0.75;
	if ( $count == '2/5' || $count == '⅖' ) return 0.4;
	if ( $count == '3/5' || $count == '⅗' ) return 0.6;
	if ( $count == '4/5' || $count == '⅘' ) return 0.8;
	if ( $count == '5/6' || $count == '⅚' ) return 0.83;
	if ( $count == '3/8' || $count == '⅜' ) return 0.375;
	if ( $count == '5/8' || $count == '⅝' ) return 0.625;
	if ( $count == '7/8' || $count == '⅞' ) return 0.875;

	// some variants
	if ( $count == '2/4' ) return 0.5;
	if ( $count == '2/6' ) return 0.33;
	if ( $count == '3/6' ) return 0.5;
	if ( $count == '4/6' ) return 0.66;

	return $count;
}

function ingredient_count_prepare( $count ) {

    $count = ingredient_count_prepare_num( $count );

    if ( $count == 0 ) return '';

    if ( $count < 0.14 ) $count = '⅛';
    if ( $count >= 0.14 && $count < 0.18 ) $count = '⅙';
    if ( $count >= 0.18 && $count < 0.21 ) $count = '⅕';
    if ( $count >= 0.21 && $count < 0.3 ) $count = '¼';
    if ( $count >= 0.3 && $count < 0.4 ) $count = '⅓';
    if ( $count >= 0.4 && $count < 0.6 ) $count = '½';
    if ( $count >= 0.6 && $count < 0.7 ) $count = '⅔';
    if ( $count >= 0.7 && $count < 0.8 ) $count = '¾';
    if ( $count >= 0.8 && $count < 0.9 ) $count = '⅘';
    if ( $count >= 0.9 && $count < 1 ) $count = '1';

    return $count;
}


/**
 * @param int|WP_Post $post    Optional. Post ID or post object. Defaults to current post.
 *
 * @return string
 */
function cook_time_prepare( $post = null ) {
    $post = get_post( $post );

    if ( ! $post ) {
        return '';
    }

    $recipe_prep_time = get_post_meta( $post->ID, 'recipe_prep_time', true );
    $recipe_cook_time = get_post_meta( $post->ID, 'recipe_cook_time', true );

    // Возвращаем значения $recipe_prep_time и $recipe_cook_time как числа.
    return $recipe_prep_time . ' ' . 'руб' ;
}


/**
 * @param \WP_Post|null $wp_post
 *
 * @return bool
 */
function is_recipe( $wp_post = null ) {
	if ( empty( $wp_post ) ) {
		global $post;
		$wp_post = $post;
	}

	$ingredients = get_post_meta( $wp_post->ID, 'recipe_ingredients', true );
	$steps       = get_post_meta( $wp_post->ID, 'recipe_steps', true );

	if ( ! empty( $ingredients ) || ! empty( $steps ) ) {
		return true;
	}

	return false;
}






/**
 * Image uploader
 *
 * @param string $name
 * @param int $attachment_id
 * @param int $width
 * @param int $height
 */
if ( ! function_exists( 'attachment_uploader_field' ) ) {
    function attachment_uploader_field( $name, $attachment_id = 0, $width = 120, $height = 100 ) {

        $placeholder_styles = 'width:' . $width . 'px;height:' . $height . 'px;';

        if ( $attachment_id ) {
            $image_attributes = wp_get_attachment_image_src( $attachment_id, array( $width, $height ) );
            $placeholder_styles = 'background-image: url(\''. $image_attributes[0] .'\');';
        }

        ?>

        <div class="attachment-uploader js-attachment-uploader">
            <div class="attachment-uploader__placeholder js-attachment-uploader-upload" style="<?php echo $placeholder_styles ?>"></div>
            <input type="hidden" name="<?php echo $name ?>" id="<?php echo $name ?>" value="<?php echo $attachment_id ?>">
        </div>

        <?php
    }
}



function get_video_code_by_link( $link = '' ) {

    if ( empty( $link ) ) return '';

    $is_vimeo = $is_youtube = false;
    $yt_pattern = '#^https?://(?:www\.)?(?:youtube\.com/watch|youtu\.be/)#';
    $vimeo_pattern = '#^https?://(.+\.)?vimeo\.com/.*#';

    $is_vimeo = ( preg_match( $vimeo_pattern, $link ) );
    $is_youtube = (  preg_match( $yt_pattern, $link ) );

    if ( ! $is_youtube && ! $is_vimeo ) {
        return sprintf( '<a class="wp-embedded-video" href="%s">%s</a>', esc_url( $link ), esc_html( $link ) );
    }

}



/**
 * Add ingredient fields
 */
global $wpshop_metabox_taxonomy;
$wpshop_metabox_taxonomy->add( array(
    'taxonomy' => array( 'ingredients' ),
    'fields'   => array(
        array(
            'name'        => 'protein',
            'label'       => __( 'Protein', THEME_TEXTDOMAIN ),
        ),
        array(
            'name'        => 'fat',
            'label'       => __( 'Fats', THEME_TEXTDOMAIN ),
        ),
        array(
            'name'        => 'carbs',
            'label'       => __( 'Carbs', THEME_TEXTDOMAIN ),
        ),
        array(
            'name'        => 'kcal',
            'label'       => __( 'Calories', THEME_TEXTDOMAIN ),
        ),
    )
) );



add_action( 'admin_print_footer_scripts-post.php', 'admin_add_ingredients_list' );
add_action( 'admin_print_footer_scripts-post-new.php', 'admin_add_ingredients_list' );
function admin_add_ingredients_list() {

    $ingredients = array();

    $args = array(
        'taxonomy' => 'ingredients',
        'hide_empty' => false,
    );
    $terms = get_terms( $args );

    if ( $terms && ! is_wp_error( $terms ) ) {
        foreach ( $terms as $term ) {
            $ingredients[] = array(
                    'id' => $term->term_id,
                    'label' => $term->name,
            );
        }
    }

    ?>
    <script>
        var ingredients = <?php echo json_encode( array_values( $ingredients ) ); ?>;
    </script>
    <?php
}
