<?php

namespace Wpshop\PostCard;

class PostCard {

	public $customizer_option_name = '';
	public $section_options = [];
	public $order = [];

	public function __construct() {

	}


	public function is_show_element( $element = '' ) {
		global $wpshop_core;

		//$post_card_hide = $wpshop_core->get_option( $this->customizer_option_name );
		//$post_card_hide = ( ! empty( $post_card_hide ) ) ? explode( ',', $post_card_hide ) : [];

		// customizer
		$is_show = ( in_array( $element, $this->order ) );

		// section options
		if ( ! empty( $this->section_options[ 'show_' . $element ] ) && in_array( $this->section_options[ 'show_' . $element ], [
				'show',
				'hide'
			] ) ) {
			$is_show = ( $this->section_options[ 'show_' . $element ] == 'show' ) ? true : false;
		}

		return $is_show;
	}

	/**
	 * @param array $section_options
	 */
	public function set_section_options( $section_options ) {
		$this->section_options = $section_options;
	}

	/**
	 * @param string $customizer_option_name
	 */
	public function set_customizer_option_name( $customizer_option_name ) {
		$this->customizer_option_name = $customizer_option_name;
	}

	public function set_order( $order ) {
		$this->order = $order;
	}

}