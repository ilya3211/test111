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

function wpshop_recipe_form( $atts ){

    if ( ! empty( $_POST['email'] ) ) {
        $emailSent = false;
    }
    elseif ( isset( $_POST['submitted'] ) ) {

        $name         = trim( $_POST['contact-name'] );
        $email        = trim( $_POST['contact-email'] );
        $subject      = trim( $_POST['contact-subject'] );
        $portions     = trim( $_POST['contact-portions'] );
        $time_cooking = trim( $_POST['contact-time-cooking'] );
        $ingredients  = trim( $_POST['contact-ingredients'] );
        $message      = trim( $_POST['contact-message'] );

        $attachments = array();
        $count = count( $_FILES['contact-images']['name'] );

        for ( $i = 0; $i < $count; $i++ ) {
            $attachment = WP_CONTENT_DIR.'/uploads/'.basename( $_FILES['contact-images']['name'][$i] );
            move_uploaded_file( $_FILES['contact-images']['tmp_name'][$i], $attachment );
            $attachments[$i] = $attachment;
        }

        $emailTo = get_option( 'tz_email' );
        if ( ! isset( $emailTo ) || ( $emailTo == '' ) ) {
            $emailTo = get_option( 'admin_email' );
        }

        $body = "Имя: \n$name \n\nE-mail: \n$email \n\nНазвание рецепта: \n$subject \n\nКол-во порций: \n$portions \n\nВремя приготовления: \n$time_cooking \n\nИнгредиенты: \n$ingredients \n\nСпособ приготовления: \n$message";
        $body .= "\n\n" . __( 'Message from ', THEME_TEXTDOMAIN ) . get_site_url();
        $mail_from = apply_filters( 'wpshop_contact_form_email_from', $email );
        $headers = 'From: ' . $name . ' <' . $mail_from . '>' . "\r\n" . 'Reply-To: ' . $email;
        wp_mail( $emailTo, $subject, $body, $headers, $attachments );
        $emailSent = true;

    }

    ob_start();
    ?>

    <div class="contact-form">
        <?php if ( isset( $emailSent ) && $emailSent == true ) { ?>
            <div class="contact-form__success"><?php _e( 'Message sent successfully!', THEME_TEXTDOMAIN ) ?></div>
        <?php } else { ?>
            <?php if ( isset( $hasError ) || isset( $captchaError ) ) { ?>

            <?php } ?>

            <form action="<?php the_permalink(); ?>" method="post" enctype="multipart/form-data">

                <input type="email" name="email" style="display:none;">

                <div class="contact-form__field contact-form--type-text">
                    <input type="text" placeholder="<?php _e( 'Your name', THEME_TEXTDOMAIN ) ?>" name="contact-name" id="contact-name" required="required" class="field-contact-name field-required">
                </div>

                <div class="contact-form__field contact-form--type-email">
                    <input type="email" placeholder="<?php _e( 'Your e-mail', THEME_TEXTDOMAIN ) ?>" name="contact-email" id="contact-email" required="required" class="field-contact-email field-required">
                </div>

                <div class="contact-form__field contact-form--type-text">
                    <input type="text" placeholder="<?php _e( 'Recipe name', THEME_TEXTDOMAIN ) ?>" name="contact-subject" id="contact-subject" required="required" class="field-contact-subject">
                </div>

                <div class="contact-form__field contact-form--type-text">
                    <input type="text" placeholder="<?php _e( 'Number of servings', THEME_TEXTDOMAIN ) ?>" name="contact-portions" id="contact-portions" required="required" class="field-contact-portions field-required">
                </div>

                <div class="contact-form__field contact-form--type-text">
                    <input type="text" placeholder="<?php _e( 'Time for cooking', THEME_TEXTDOMAIN ) ?>" name="contact-time-cooking" id="contact-time-cooking" required="required" class="field-contact-time-cooking field-required">
                </div>

                <div class="contact-form__field contact-form--type-text">
                    <textarea placeholder="<?php _e( 'Ingredients', THEME_TEXTDOMAIN ) ?>" name="contact-ingredients" id="contact-ingredients" required="required" class="field-contact-message field-required"></textarea>
                </div>

                <div class="contact-form__field contact-form--type-text">
                    <textarea placeholder="<?php _e( 'Cooking method', THEME_TEXTDOMAIN ) ?>" name="contact-message" id="contact-message" required="required" class="field-contact-message field-required"></textarea>
                </div>

                <div class="contact-form__field contact-form--type-text">
                    <input type="file" name="contact-images[]" id="contact-images" multiple accept="image/*">
                </div>

                <?php do_action( 'wpshop_recipe_form_before_button' ); ?>
                <button type="submit" name="submit" class="btn btn-primary"><?php _e( 'Send', THEME_TEXTDOMAIN ) ?></button>
                <input type="hidden" name="submitted" id="submitted" value="true" />

            </form>
        <?php } ?>
    </div>

    <?php
    $buffer = ob_get_contents();
    ob_end_clean();

    return $buffer;

}

add_shortcode( 'recipeform', 'wpshop_recipe_form' );