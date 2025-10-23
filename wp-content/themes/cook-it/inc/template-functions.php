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

if ( function_exists( 'get_term_meta' ) ) :

    /**
     * Get all taxonomies
     * Set action priority to 99 because get_taxonomies don't show all regisstred
     */
    function add_taxonomy_actions() {
        $get_taxonomies = get_taxonomies( array( 'public' => true ) );
        if ( is_array( $get_taxonomies ) ) {
            foreach ( $get_taxonomies as $get_taxonomy ) {
                add_action( $get_taxonomy . '_add_form_fields', 'add_taxonomy_header_field', 10, 2 );
                add_action( 'created_' . $get_taxonomy, 'save_taxonomy_header_field', 10, 2 );

                add_action( $get_taxonomy . '_edit_form_fields', 'edit_taxonomy_header_field', 10, 2 );
                add_action( 'edited_' . $get_taxonomy, 'update_taxonomy_header_field', 10, 2 );
            }
        }
    }
    add_action( 'init', 'add_taxonomy_actions', 99 );




    /**
     * Add and save taxonomy field in creating form
     */
    //add_action( 'category_add_form_fields', 'add_taxonomy_header_field', 10, 2 );
    function add_taxonomy_header_field( $taxonomy ) {
        ?>
        <div class="form-field term-group">
            <label for="taxonomy_header">Заголовок</label>
            <input name="taxonomy_header" id="taxonomy_header" type="text" value="" size="40">
            <p class="description">Заголовок H1 в архивах таксономий</p>
        </div>
        <?php
    }


    //add_action( 'created_category', 'save_taxonomy_header_field', 10, 2 );
    function save_taxonomy_header_field( $term_id, $tt_id ){
        if( isset( $_POST['taxonomy_header'] ) ){
            $taxonomy_header = trim( $_POST['taxonomy_header'] );
            add_term_meta( $term_id, 'taxonomy_header', $taxonomy_header, true );
        }
    }


    /**
     * Add and save taxonomy field in edit form
     */
    //add_action( 'category_edit_form_fields', 'edit_taxonomy_header_field', 10, 2 );
    function edit_taxonomy_header_field( $term, $taxonomy ){
        // get current
        $feature_group = get_term_meta( $term->term_id, 'taxonomy_header', true );

        ?><tr class="form-field term-group-wrap">
        <th scope="row"><label for="taxonomy_header">Заголовок</label></th>
        <td>
            <input name="taxonomy_header" id="taxonomy_header" type="text" value="<?php echo $feature_group ?>" size="40">
            <p class="description">Заголовок H1 в архивах таксономий</p>
        </td>
        </tr><?php
    }

    //add_action( 'edited_category', 'update_taxonomy_header_field', 10, 2 );
    function update_taxonomy_header_field( $term_id, $tt_id ){

        if( isset( $_POST['taxonomy_header'] ) ){
            $taxonomy_header = trim( $_POST['taxonomy_header'] );
            update_term_meta( $term_id, 'taxonomy_header', $taxonomy_header );
        }
    }



    /**
     * Change the_archive_title
     */
    add_filter( 'get_the_archive_title', 'taxonomy_header_archive_title' );
    function taxonomy_header_archive_title( $title ) {
        if ( is_tax() || is_category() || is_tag() ) {
            $taxonomy_header = get_term_meta( get_queried_object()->term_id, 'taxonomy_header', true );
            if ( ! empty( $taxonomy_header ) ) {
                $title = $taxonomy_header;
            }
        }
        return $title;
    }



endif;



/**
 * Set social profiles array
 */
function wpshop_social_profiles() {
    $social_profiles = apply_filters( THEME_SLUG . '_social_share_links', [
        'facebook', 'vkontakte', 'twitter', 'odnoklassniki', 'telegram', 'youtube',
        'instagram', 'tiktok', 'linkedin', 'whatsapp', 'viber', 'pinterest',
        'yandexzen', 'github', 'discord', 'rutube', 'yappy', 'pikabu', 'yandex'
    ] );

    return $social_profiles;
}



/**
 * Add additional fields to user profile
 */
add_filter( 'user_contactmethods', 'wpshop_user_social_profiles', 0 );

function wpshop_user_social_profiles( $method ) {
    $user_social_profiles = [
        'facebook'      => __( 'Facebook profile link', THEME_TEXTDOMAIN ),
        'vkontakte'     => __( 'Vkontakte profile link', THEME_TEXTDOMAIN ),
        'twitter'       => __( 'Twitter profile link', THEME_TEXTDOMAIN ),
        'odnoklassniki' => __( 'Odnoklassniki profile link', THEME_TEXTDOMAIN ),
        'telegram'      => __( 'Telegram profile link', THEME_TEXTDOMAIN ),
        'youtube'       => __( 'Youtube profile link', THEME_TEXTDOMAIN ),
        'instagram'     => __( 'Instagram profile link', THEME_TEXTDOMAIN ),
        'tiktok'        => __( 'Tik Tok profile link', THEME_TEXTDOMAIN ),
        'linkedin'      => __( 'Linkedin profile link', THEME_TEXTDOMAIN ),
        'whatsapp'      => __( 'Whatsapp profile link', THEME_TEXTDOMAIN ),
        'viber'         => __( 'Viber profile link', THEME_TEXTDOMAIN ),
        'pinterest'     => __( 'Pinterest profile link', THEME_TEXTDOMAIN ),
        'yandexzen'     => __( 'Yandex Zen profile link', THEME_TEXTDOMAIN ),
        'github'        => __( 'GitHub profile link', THEME_TEXTDOMAIN ),
        'discord'       => __( 'Discord profile link', THEME_TEXTDOMAIN ),
        'rutube'        => __( 'RuTube profile link', THEME_TEXTDOMAIN ),
        'yappy'         => __( 'Yappy profile link', THEME_TEXTDOMAIN ),
        'pikabu'        => __( 'Pikabu profile link', THEME_TEXTDOMAIN ),
        'yandex'        => __( 'Yandex profile link', THEME_TEXTDOMAIN ),
    ];

    $method = array_merge( $method, $user_social_profiles );

    return $method;
}



/**
 * Add shortcode for subscribe form
 */
function wpshop_subscribe_form() {
    ob_start();
    get_template_part( 'template-parts/subscribe', 'box' );
    return ob_get_clean();
}
add_shortcode( 'subscribeform', 'wpshop_subscribe_form' );



/**
 * Remove all symbols except numbers and minus
 *
 * @param $string
 *
 * @return mixed
 */
if ( ! function_exists( 'wpshop_sanitize_ids_string' ) ) {
    function wpshop_sanitize_ids_string( $string ) {

        $string = preg_replace( '/[^0-9-,]/', '', $string ); // оставляем цифры, минус, запятую
        $string = preg_replace( '/,{2,}/', ',', $string ); // удаляем две запятые и больше
        $string = preg_replace( '/-{2,}/', '-', $string ); // удаляем два и больше минуса

        return $string;
    }
}



/**
 * Fix home constructor pagination
 * if home constructor enable -- disable pagination
 */
add_action( 'pre_get_posts', 'pre_get_posts_home_constructor' );
function pre_get_posts_home_constructor( $query ) {

    if ( ! is_admin() && $query->is_main_query() && $query->is_home && $query->is_paged ) {

        global $wpshop_core;
        $home_constructor = $wpshop_core->get_option( 'home_constructor' );
        if ( ! empty( $home_constructor ) && ! $wpshop_core->get_option( 'display_constructor_static_page' ) ) {
            $home_constructor = json_decode( $home_constructor, true );
        }

        if ( ! empty( $home_constructor ) && is_array( $home_constructor ) ) {
            $query->is_404 = true;
        }

    }
}