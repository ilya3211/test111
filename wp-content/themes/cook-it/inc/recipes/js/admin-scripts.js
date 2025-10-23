jQuery(function($) {
    
    /* ==========================================================================
       INGREDIENTS
       ========================================================================== */

    jQuery(document).on( 'click', '.js-admin-ingredients-delete', function(){
        if (jQuery('.js-admin-ingredients li').length > 1) {
            jQuery(this).parents('li').slideUp( 50, function(){ jQuery(this).remove(); } );
        } else {
            jQuery(this).parents('li').find('input').val('');
        }
    });

    if (jQuery('.js-admin-ingredients').sortable) {
        jQuery('.js-admin-ingredients').sortable({
            placeholder: "ui-state-highlight",
            opacity: 0.8,
            cursor: 'move',
        });
    }

    jQuery(document).on( 'click', '.js-admin-ingredients-add', function(){
        ingredientNew = jQuery('.js-admin-ingredients li:first').clone();
        ingredientNew.find('input').val('');
        ingredientNew.appendTo('.js-admin-ingredients');
        ingredientNew.find('.admin-ingredients__3').show();
        ingredientNew.find('input:first').focus();
        autocomplete_ingredients();
        return false;
    });

    jQuery(document).on( 'click', '.js-admin-ingredients-add-sep', function(){
        ingredientNew = jQuery('.js-admin-ingredients li:first').clone();
        ingredientNew.find('input').val('');
        ingredientNew.appendTo('.js-admin-ingredients');
        ingredientNew.find('.admin-ingredients__3 input').val('separator');
        ingredientNew.find('.admin-ingredients__2 .description').hide();
        ingredientNew.find('.admin-ingredients__3').hide();
        ingredientNew.find('.admin-ingredients__text').hide();
        ingredientNew.find('input:first').focus();
        return false;
    });
    autocomplete_ingredients();

    function autocomplete_ingredients() {
        if ( jQuery( '.js-ingredients-name' ).length ) {
            jQuery('.js-ingredients-name').autocomplete({
                source: ingredients,
                minLength: 2,
                select: function (event, ui) {
                    var term_id = ui.item.id;
                    var term_name = ui.item.label;
                    var $line = $(this).parent().parent();
                    $line.find('.js-ingredients-term-icon').addClass('active').attr('title', term_name);
                    $line.find('.js-ingredients-term').val(term_id);
                }
            });
        }
    }

    jQuery(document).on('click', '.js-ingredients-term-icon', function() {
        if ( confirm( 'Удалить привязку к ингредиенту?' ) ) {
            $(this).removeClass('active').attr('title', '').parent().find('.js-ingredients-term').val('');
        }
    });

    /* ==========================================================================
       STEPS
       ========================================================================== */

    jQuery(document).on( 'click', '.js-admin-steps-add', function(){
        ingredientNew = jQuery('.js-admin-steps li:first').clone();
        ingredientNew.find('input').val('');
        ingredientNew.find('textarea').val('');
        ingredientNew.find('.admin-steps-photo').remove();
        ingredientNew.appendTo('.js-admin-steps');
        ingredientNew.find('textarea:first').focus();
        ingredientNew.show();
        return false;
    });

    jQuery(document).on( 'click', '.js-admin-steps-delete', function(){
        if (jQuery('.js-admin-steps li').length > 2) {
            jQuery(this).parents('li').slideUp( 50, function(){ jQuery(this).remove(); } );
        } else {
            jQuery(this).parents('li').find('input').val('');
        }
    });

    if (jQuery('.js-admin-steps').sortable) {
        jQuery('.js-admin-steps').sortable({
            placeholder: "ui-state-highlight-step",
            opacity: 0.8,
            cursor: 'move',
        });
    }
  
});


jQuery(function($) {

    var attachment_uploader_timer;

    $(document.body).on('click', '.js-attachment-uploader-upload', function() {
        var $this = $(this);
        var $attachment_uploader = $(this).parent();
        var editor_send_attachment = wp.media.editor.send.attachment;
        wp.media.editor.send.attachment = function(props, attachment) {
            $this.css('background-image', 'url(' + attachment.url + ')');
            $attachment_uploader.find('input').val(attachment.id);
            wp.media.editor.send.attachment = editor_send_attachment;
        };
        wp.media.editor.open( $this );
        return false;
    });

    $(document).on({
        mouseenter: function () {
            var $this = $(this);
            var $attachment_uploader = $(this).parent();
            $attachment_uploader.append('<div class="attachment-uploader__delete js-attachment-uploader-delete">&times;</div>');
            clearTimeout(attachment_uploader_timer);
        },
        mouseleave: function () {
            var $this = $(this);
            var $attachment_uploader = $(this).parent();
            attachment_uploader_timer = setTimeout(function(){
                attachment_uploader_hide( $attachment_uploader );
            }, 300);

        }
    }, '.js-attachment-uploader-upload');

    function attachment_uploader_hide( $attachment_uploader ){
        $attachment_uploader.find('.js-attachment-uploader-delete').fadeOut(200, function(){ $(this).remove(); });
    }

    $(document).on('mouseenter', '.js-attachment-uploader-delete', function(){
        clearTimeout(attachment_uploader_timer);
    });

    $(document).on('click', '.js-attachment-uploader-delete', function(){
        var $this = $(this);
        var $attachment_uploader = $(this).parent();

        $attachment_uploader.find('.js-attachment-uploader-upload').css('background-image', '');
        $attachment_uploader.find('input').val('');
    });

});
