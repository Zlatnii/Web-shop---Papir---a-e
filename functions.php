<?php
function stax_grupa_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'stax_grupa_theme_setup');

function stax_grupa_enqueue_assets() {
    wp_enqueue_style('stax-style', get_stylesheet_uri(), array(), '1.0');
    wp_enqueue_script('stax-app', get_template_directory_uri() . '/assets/js/app.js', array(), '1.0', true);
    wp_localize_script('stax-app', 'staxData', array(
        'themeUrl' => get_template_directory_uri()
    ));
}
add_action('wp_enqueue_scripts', 'stax_grupa_enqueue_assets');

add_filter('gettext', 'stax_translate_view_cart', 20, 3);

function stax_translate_view_cart($translated_text, $text, $domain) {
    if ($domain === 'woocommerce' && $text === 'View cart') {
        $translated_text = 'Košarica';
    }
    return $translated_text;
}

?>