<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class XS_Intro_Video_Widget extends Widget_Base {

    public function get_name() {
        return 'xs-intro-video';
    }

    public function get_title() {
        return esc_html__( 'charitious Intro Video', 'charitious' );
    }

    public function get_icon() {
        return 'eicon-youtube';
    }

    public function get_categories() {
        return [ 'charitious-elements' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_tab',
            [
                'label' =>esc_html__('charitious Intro Video', 'charitious'),
            ]
        );

        




        $this->add_control(
         'video_link',
         [
            'label' =>esc_html__( 'Link', 'charitious' ),
            'type' => Controls_Manager::TEXT,
            'placeholder' =>esc_html__('http://your-link.com','charitious' ),

        ]
    );

        $this->add_control(
         'image',
         [
            'label' =>esc_html__( 'Thumbnail Image', 'charitious' ),
            'type' => Controls_Manager::MEDIA,
            'default' => [
               'url' => Utils::get_placeholder_image_src(),
           ],
       ]
   );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image',
                'label' =>esc_html__( 'Image Size', 'charitious' ),
                'default' => 'full',
            ]
        );
        
        $this->add_responsive_control(
            'btn_align',
            [
                'label' =>esc_html__( 'Alignment', 'charitious' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left'    => [
                        'title' =>esc_html__( 'Left', 'charitious' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' =>esc_html__( 'Center', 'charitious' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' =>esc_html__( 'Right', 'charitious' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'prefix_class' => 'elementor%s-align-',
                'default' => '',
            ]
        );

        //New code added
        $repeater = new Repeater();

        $repeater->add_control(
            'number',

            [
                'label'         => esc_html__( 'Nmuber', 'charitious' ),
                'type'          => Controls_Manager::TEXT,
                'label_block' => true,
            ]

        );

        $repeater->add_control(
            'title',

            [
                'name'  =>  'title',
                'label' =>esc_html__( 'Title', 'charitious' ),
                'type' => Controls_Manager::TEXT,
            ]

        );

        $this->add_control(
            'funfact_list',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [  
                        'title' => __( 'Item #1', 'charitious' ),
                        'number' => __( '100', 'charitious' ),
                    ],
                    
                ],
                'title_field' => '{{{ title }}}',
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(

        	'style_tab',
        	[
        		'label'	=>	__( 'Style', 'charitious' ),
        		'tab' 	=> Controls_Manager::TAB_STYLE,
        	]
        );

        $this->add_control(
        	'border',
        	[
        		'label'	=>	__('Show Border','charitious'),
        		'type'	=> Controls_Manager::SWITCHER,
        		'default' => 'no',
                'label_on' =>esc_html__( 'Yes', 'charitious' ),
                'label_off' =>esc_html__( 'No', 'charitious' ),

            ]

        );

        $this->add_control(
          'border_width',
          [
              'label' =>esc_html__( 'Border Width', 'charitious' ),
              'type' => Controls_Manager::SLIDER,
              'default' => [
                  'size' => '1',
              ],
              'range' => [
                  'min' => 1,
                  'max' => 100,
                  'step' => 1,
              ],
              'size_units' => [ 'px'],
              'condition'	=>	[
                 'border'	=> 'yes',
             ],
             'selectors'	=>	[
                 '{{WRAPPER}} a.xs-video-popup' => 'border: {{SIZE}}px solid;',
             ],
             'condition' =>  [
                'border' => 'yes',
            ],
        ]
    );

        $this->add_control(
        	'border_color',
        	[
        		'label'	=>	__('Border Color','charitious'),
        		'type'	=> Controls_Manager::COLOR,
        		'selectors'	=>	[
        			'{{WRAPPER}} a.xs-video-popup' => 'border-color: {{VALUE}};',
        		],
        		'condition'	=>	[
        			'border'	=> 'yes',
        		],
        	]
        );

        $this->add_control(
            'btn_bg_color',
            [
                'label' => esc_html__('Button BG Color','charitious'),
                'type'  => Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} a.xs-video-popup' => 'background-color: {{VALUE}} !important;'
                ],
                
            ]
        );

        $this->add_control(
            'btn_icon_color',
            [
                'label' => esc_html__('Icon Color','charitious'),
                'type'  => Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} a.xs-video-popup i' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render( ) {
        $settings = $this->get_settings();

        $video_link = $settings['video_link'];
        $funfact_list = $settings['funfact_list'];
        $image = $settings['image'];
        ?>
        <div class="intruduction-video">
          <div class="xs-video-popup-wraper">
             <?php if ( !empty($image['url']) ){
				echo wp_get_attachment_image($image['id'], 'full', false, array(
					'alt' => esc_attr__('img','charitious')
				));
			  } ?>
            <div class="xs-video-popup-content">
                <a href="<?php echo esc_url( $video_link ); ?>" class="xs-video-popup video-popup-btn">
                   <i class="icon-play"></i>
               </a>
           </div>
       </div>
       <ul class="funfact-list">
        <?php foreach($funfact_list as $list):?>
         <li><span class="number-percentage-count number-percentage" data-value="<?php echo esc_attr($list['number']);?>" data-animation-duration="3500">0</span><span>+</span><p><?php echo esc_html($list['title']);?></p></li>
     <?php endforeach;?>
 </ul>
</div>

<?php

}

protected function content_template() { }
}