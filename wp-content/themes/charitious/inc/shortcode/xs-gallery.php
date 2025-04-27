<?PHP

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Xs_Gallery_Widget extends Widget_Base {

    public function get_name() {
        return 'xs-gallery';
    }

    public function get_title() {
        return esc_html__( 'Charitious Gallery', 'charitious' );
    }

    public function get_icon() {
        return 'eicon-tabs';
    }

    public function get_categories() {
        return [ 'charitious-elements' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_tab',
            [
                'label' =>esc_html__('Charitious Gallery', 'charitious'),
            ]
        );


        $repeater =  new Repeater();

        $repeater->add_control(
            'gallery_image',
            [
                'label'         => __( 'Images', 'charitious' ),
                'type'          => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],

                'label_block' => true,
            ]
        );

        $this->add_control(
            'gallery',
            [
                'label' => __( 'Item List', 'charitious' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->end_controls_section();
    }


    protected function render( ) {
        $settings = $this->get_settings();
        $portfolio_gallery = $settings['gallery'];
        ?>

        <div class="xs-single-item-slider owl-carousel">
            <?php
            foreach($portfolio_gallery as $logo_partners):
                $image = $logo_partners['gallery_image'];
                if(isset($image['url']) && !empty($image['url'])) : ?>
                <div class="xs-single-slider-item">
                   <?php echo wp_get_attachment_image($image['id'], 'full', false, array(
                       'alt' => esc_attr__('gallery item','charitious')
                   )); ?>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php
    }

    protected function content_template() { }
}