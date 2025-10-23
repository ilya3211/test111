<?php

namespace Wpshop\WPRemark;

use Wpshop\WPRemark\Settings\BlockquoteOptions;

class Blockquotes {

    /**
     * @var BlockquoteOptions
     */
    protected $blockquote_options;

    /**
     * Blockquotes constructor.
     *
     * @param BlockquoteOptions $blockquote_options
     */
    public function __construct( BlockquoteOptions $blockquote_options ) {
        $this->blockquote_options = $blockquote_options;
    }

    /**
     * @return void
     */
    public function init() {
        add_filter( 'the_content', [ $this, '_add_blockquotes_to_content' ], 11 );

        do_action( __METHOD__, $this );
    }

    /**
     * @param string $content
     *
     * @return string
     */
    public function _add_blockquotes_to_content( $content ) {

        if ( ! empty( $GLOBALS['wp_current_filter'] ) && in_array( 'get_the_excerpt', $GLOBALS['wp_current_filter'] ) ) {
            return $content;
        }

        $post_types = apply_filters( 'wpremark_post_types', [ 'post' ] );

        if ( $this->blockquote_options->blockquote_before_content &&
             ( $post = get_queried_object() ) &&
             $post instanceof \WP_Post &&
             in_array( $post->post_type, $post_types )
        ) {

            if ( $this->blockquote_options->include_post_ids_before_content ) {
                $include = wp_parse_id_list( $this->blockquote_options->include_post_ids_before_content );
                if ( ! in_array( $post->ID, $include ) ) {
                    return $content;
                }
            }

            if ( $this->blockquote_options->exclude_post_ids_before_content ) {
                $exclude = wp_parse_id_list( $this->blockquote_options->exclude_post_ids_before_content );
                if ( in_array( $post->ID, $exclude ) ) {
                    return $content;
                }
            }

            if ( $this->blockquote_options->include_post_categories_before_content || $this->blockquote_options->exclude_post_categories_before_content ) {
                $include_cats = wp_parse_id_list( $this->blockquote_options->include_post_categories_before_content );
                $exclude_cats = wp_parse_id_list( $this->blockquote_options->exclude_post_categories_before_content );

                if ( ! empty( $include_cats ) || ! empty( $exclude_cats ) ) {
                    $categories = wp_get_post_categories( $post->ID, [ 'fields' => 'all' ] );
                    if ( is_wp_error( $categories ) ) {
                        // @todo log wp error
                        return $content;
                    } else {
                        $categories = array_map( function ( \WP_Term $item ) {
//                            return $item->name;
                            return $item->term_id;
                        }, $categories );

                        if ( ! array_intersect( $include_cats, $categories ) ) {
                            return $content;
                        }

                        if ( array_intersect( $exclude_cats, $categories ) ) {
                            return $content;
                        }
                    }
                }
            }

            if ( $this->blockquote_options->blockquote_before_content_display ) {
                $blockquote_before_content = do_shortcode( $this->blockquote_options->blockquote_before_content );
                $content = $blockquote_before_content . $content;
            }
        }

        if ( $this->blockquote_options->blockquote_after_content &&
            ( $post = get_queried_object() ) &&
            $post instanceof \WP_Post &&
            in_array( $post->post_type, $post_types )
        ) {

            if ( $this->blockquote_options->include_post_ids_after_content ) {
                $include = wp_parse_id_list( $this->blockquote_options->include_post_ids_after_content );
                if ( in_array( $post->ID, $include ) ) {
                    return $content;
                }
            }

            if ( $this->blockquote_options->exclude_post_ids_after_content ) {
                $exclude = wp_parse_id_list( $this->blockquote_options->exclude_post_ids_after_content );
                if ( in_array( $post->ID, $exclude ) ) {
                    return $content;
                }
            }

            if ( $this->blockquote_options->include_post_categories_after_content || $this->blockquote_options->exclude_post_categories_after_content ) {
                $include_cats = wp_parse_id_list( $this->blockquote_options->include_post_categories_after_content );
                $exclude_cats = wp_parse_id_list( $this->blockquote_options->exclude_post_categories_after_content );

                if ( ! empty( $include_cats ) || ! empty( $exclude_cats ) ) {
                    $categories = wp_get_post_categories( $post->ID, [ 'fields' => 'all' ] );
                    if ( is_wp_error( $categories ) ) {
                        // @todo log wp error
                        return $content;
                    } else {
                        $categories = array_map( function ( \WP_Term $item ) {
//                            return $item->name;
                            return $item->term_id;
                        }, $categories );

                        if ( ! array_intersect( $include_cats, $categories ) ) {
                            return $content;
                        }

                        if ( array_intersect( $exclude_cats, $categories ) ) {
                            return $content;
                        }
                    }
                }
            }

            if ( $this->blockquote_options->blockquote_after_content_display ) {
                $blockquote_after_content = do_shortcode( $this->blockquote_options->blockquote_after_content );
                $content = $content . $blockquote_after_content;
            }
        }

        return $content;
    }
}
