<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Elementor_Product_Video_Widget extends Widget_Base {

    public function get_name() {
        return 'product_video';
    }

    public function get_title() {
        return 'Vídeo do Produto';
    }

    public function get_icon() {
        return 'eicon-youtube';
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => 'Configurações do Vídeo',
            ]
        );

        $this->add_control(
            'notice_message',
            [
                'label' => 'Mensagem de Aviso',
                'type' => Controls_Manager::RAW_HTML,
                'raw' => 'O vídeo deste produto será puxado do seu próprio cadastro.',
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
            ]
        );
    }

    protected function render() {
        $settings = $this->get_settings();
        $product_id = get_the_ID(); // Obtém o ID do produto atual

        $video_url = get_post_meta($product_id, 'product_video', true); // Corrigido para 'product_video'

        if ($video_url) {
            // Extrai o ID do vídeo do YouTube do URL
            preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $video_url, $matches);
            $video_id = $matches[1] ?? null;

            if ($video_id) {
                $autoplay = $settings['autoplay'] === 'yes' ? '?autoplay=1' : '';
                $mute = $settings['mute'] === 'yes' ? '&mute=1' : '';
                $controls = $settings['controls'] === 'yes' ? '&controls=1' : '';
                $show_branding = $settings['show_branding'] === 'yes' ? '&showinfo=1' : '';
                $width = $settings['width'];
                $height = $settings['height_percent']['size'] . '%';

                echo '<div class="elementor-product-video" style="max-width:' . $width . '%;max-height:' . $height . ';"><div style="position:relative;">';			
				echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $video_id . '" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
                echo '</div></div>';
            }
        }
    }
}
