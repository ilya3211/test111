<?php

namespace Wpshop\WPRemark\Settings;

use Wpshop\SettingApi\OptionStorage\AbstractOptionStorage;

/**
 * Class BlockquoteOptions
 * @package Wpshop\WPRemark\Settings
 *
 * @property int|null    $blockquote_before_content_display
 * @property string|null $blockquote_before_content
 * @property string|null $include_post_ids_before_content
 * @property string|null $exclude_post_ids_before_content
 * @property string|null $include_post_categories_before_content
 * @property string|null $exclude_post_categories_before_content
 * @property int|null    $blockquote_after_content_display
 * @property string|null $blockquote_after_content
 * @property string|null $include_post_ids_after_content
 * @property string|null $exclude_post_ids_after_content
 * @property string|null $include_post_categories_after_content
 * @property string|null $exclude_post_categories_after_content
 */
class BlockquoteOptions extends AbstractOptionStorage {

    const SECTION = 'blockquote_options';

    /**
     * @inheritDoc
     */
    public function getSection() {
        return self::SECTION;
    }
}
