<?php
/**
 * Plugin Name: Elementor Product Video Widget
 * Description: Um widget do Elementor que exibe o vídeo do YouTube para produtos WooCommerce.
 * Version: 1.0
 * Author: Alan Frigo
 */

// Registra a metabox para o URL do YouTube
add_action('add_meta_boxes', 'product_video_metabox');

function product_video_metabox() {
    add_meta_box('product_video_metabox', 'URL do Vídeo do YouTube', 'render_product_video_metabox', 'product', 'normal', 'high');
}

function render_product_video_metabox($post) {
    $product_video = get_post_meta($post->ID, 'product_video', true);
    ?>
    <label for="product_video">Insira o URL do Vídeo do YouTube:</label>
    <input type="text" id="product_video" name="product_video" value="<?php echo esc_attr($product_video); ?>" style="width: 100%;" />
    <?php
}

add_action('save_post', 'save_product_video');

function save_product_video($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['product_video'])) {
        $product_video = sanitize_text_field($_POST['product_video']);
        update_post_meta($post_id, 'product_video', $product_video);
    }
}

// Adiciona uma ação que registra o widget
add_action('elementor/widgets/widgets_registered', 'register_product_video_widget');

function register_product_video_widget($widgets_manager) {
    require_once plugin_dir_path(__FILE__) . 'product-video-widget.php';
    $widgets_manager->register_widget_type(new \Elementor_Product_Video_Widget());
}
