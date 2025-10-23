<?php

namespace Wpshop\WPRemark;

use Wpshop\WPRemark\Settings\PluginOptions;
use Wpshop\WPRemark\Settings\BlockquoteOptions;
use Wpshop\SettingApi\OptionField\Checkbox;
use Wpshop\SettingApi\OptionField\Editor;
use Wpshop\SettingApi\OptionField\RawHtml;
use Wpshop\SettingApi\OptionField\Select;
use Wpshop\SettingApi\OptionField\Text;
use Wpshop\SettingApi\OptionField\Textarea;
use Wpshop\SettingApi\Section\Section;
use Wpshop\SettingApi\SettingsProviderInterface;
use Wpshop\SettingApi\SettingsPage\TabSettingsPage;

class SettingsProvider implements SettingsProviderInterface {

    use TemplateRendererTrait;

    /**
     * @var Plugin
     */
    protected $plugin;

    /**
     * @var PluginOptions
     */
    protected $baseOptions;

    /**
     * @var BlockquoteOptions
     */
    protected $blockquote_options;

    /**
     * SettingsProvider constructor.
     *
     * @param Plugin               $plugin
     * @param PluginOptions        $baseOptions
     * @param BlockquoteOptions    $blockquote_options
     */
    public function __construct(
        Plugin $plugin,
        PluginOptions $baseOptions,
        BlockquoteOptions $blockquote_options
    ) {
        $this->plugin                 = $plugin;
        $this->baseOptions            = $baseOptions;
        $this->blockquote_options     = $blockquote_options;
    }

    /**
     * @inheritDoc
     */
    public function getSettingsSubmenu() {

        $baseOptions = $this->baseOptions;

        $submenu = new TabSettingsPage(
            __( 'Settings', Plugin::TEXT_DOMAIN ),
            __( 'Settings', Plugin::TEXT_DOMAIN ),
            'manage_options',
            'wpremark-settings'
        );

        $submenu->setParentSlug( AdminMenu::MAIN_SLUG );

        $submenu->addSection( $section = new Section(
            $baseOptions->getSection(),
            __( 'Main', Plugin::TEXT_DOMAIN ),
            PluginOptions::class
        ) );

        $section->addField( $field = new Text( 'license' ) );
        $field
            ->setLabel( __( 'License', Plugin::TEXT_DOMAIN ) )
            ->setPlaceholder( $baseOptions->license ? '*****' : __( 'Enter license key', Plugin::TEXT_DOMAIN ) )
            ->setValue( $baseOptions->show_license_key ? null : '' )
            ->setSanitizeCallback( function ( $value ) use ( $baseOptions ) {
                if ( ! $value && ! $baseOptions->show_license_key ) {
                    $value = $baseOptions->license;
                }
                $value = trim( $value );
                if ( current_user_can( 'administrator' ) && $value ) {
                    $this->plugin->activate( $value );
                }

                return null;
            } )
        ;

//        if ( apply_filters( 'wpremark_settings:show_license_key', true ) ) {
//            $section->addField( $field = new Checkbox( 'show_license_key' ) );
//            $field
//                ->setLabel( __( 'Show License', Plugin::TEXT_DOMAIN ) )
//                ->setDescription( __( 'Show license key in input', Plugin::TEXT_DOMAIN ) )
//                ->setEnabled( current_user_can( 'administrator' ) )
//            ;
//        }

        if ( ! $this->plugin->verify() ) {
            return $submenu;
        }

        /**
         * Blockquotes
         */
        $blockquote_options = $this->blockquote_options;
        $submenu->addSection( $section = new Section(
            $blockquote_options->getSection(),
            __( 'Extended', Plugin::TEXT_DOMAIN ),
            $blockquote_options
        ) );

        $section->addField( $field = new Checkbox( 'blockquote_before_content_display' ) );
        $field
            ->setLabel( __( 'Before content', Plugin::TEXT_DOMAIN ) )
            ->setDescription( __( 'If you want to display the same attention block in front of the content in all posts, configure it in the field below and check the box', Plugin::TEXT_DOMAIN ) )
        ;

        $section->addField( $field = new Editor( 'blockquote_before_content' ) );
        $field
            ->setEditorOptions( [ 'teeny' => false ] )
        ;

        $section->addField( $field = new Text( 'include_post_ids_before_content' ) );
        $field
            ->setLabel( __( 'Show only in posts', Plugin::TEXT_DOMAIN ) )
            ->setDescription( __( 'Add ID of posts, separated by commas', Plugin::TEXT_DOMAIN ) )
        ;

        $section->addField( $field = new Text( 'exclude_post_ids_before_content' ) );
        $field
            ->setLabel( __( 'Do not show in posts', Plugin::TEXT_DOMAIN ) )
            ->setDescription( __( 'Add ID of posts, separated by commas', Plugin::TEXT_DOMAIN ) )
        ;

        $section->addField( $field = new Text( 'include_post_categories_before_content' ) );
        $field
            ->setLabel( __( 'Show only in categories', Plugin::TEXT_DOMAIN ) )
            ->setDescription( __( 'Add ID of categories, separated by commas', Plugin::TEXT_DOMAIN ) )
        ;

        $section->addField( $field = new Text( 'exclude_post_categories_before_content' ) );
        $field
            ->setLabel( __( 'Do not show in categories', Plugin::TEXT_DOMAIN ) )
            ->setDescription( __( 'Add ID of categories, separated by commas', Plugin::TEXT_DOMAIN ) )
        ;

        $section->addField( $field = new Checkbox( 'blockquote_after_content_display' ) );
        $field
            ->setLabel( __( 'After content', Plugin::TEXT_DOMAIN ) )
            ->setDescription( __( 'If you want to display the same attention block after the content in all posts, configure it in the field below and check the box', Plugin::TEXT_DOMAIN ) )
        ;

        $section->addField( $field = new Editor( 'blockquote_after_content' ) );
        $field
            ->setEditorOptions( [ 'teeny' => false ] )
        ;

        $section->addField( $field = new Text( 'include_post_ids_after_content' ) );
        $field
            ->setLabel( __( 'Show only in posts', Plugin::TEXT_DOMAIN ) )
            ->setDescription( __( 'Add ID of posts, separated by commas', Plugin::TEXT_DOMAIN ) )
        ;

        $section->addField( $field = new Text( 'exclude_post_ids_after_content' ) );
        $field
            ->setLabel( __( 'Do not show in posts', Plugin::TEXT_DOMAIN ) )
            ->setDescription( __( 'Add ID of posts, separated by commas', Plugin::TEXT_DOMAIN ) )
        ;

        $section->addField( $field = new Text( 'include_post_categories_after_content' ) );
        $field
            ->setLabel( __( 'Show only in categories', Plugin::TEXT_DOMAIN ) )
            ->setDescription( __( 'Add ID of categories, separated by commas', Plugin::TEXT_DOMAIN ) )
        ;

        $section->addField( $field = new Text( 'exclude_post_categories_after_content' ) );
        $field
            ->setLabel( __( 'Do not show in categories', Plugin::TEXT_DOMAIN ) )
            ->setDescription( __( 'Add ID of categories, separated by commas', Plugin::TEXT_DOMAIN ) )
        ;

        return $submenu;
    }
}
