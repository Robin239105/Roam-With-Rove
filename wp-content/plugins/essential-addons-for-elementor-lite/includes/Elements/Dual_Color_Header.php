<?php

namespace Essential_Addons_Elementor\Elements;

use Elementor\Group_Control_Background;
use Elementor\Repeater;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use \Elementor\Widget_Base;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;

use \Essential_Addons_Elementor\Classes\Helper;
class Dual_Color_Header extends Widget_Base
{
	public function get_name()
	{
		return 'eael-dual-color-header';
	}

	public function get_title()
	{
		return esc_html__('Dual Color Heading', 'essential-addons-for-elementor-lite');
	}

	public function get_icon()
	{
		return 'eaicon-dual-color-heading';
	}

	public function get_categories()
	{
		return ['essential-addons-elementor'];
	}

	public function get_keywords()
	{
		return [
			'ea header',
			'ea dual header',
			'ea dual color header',
			'heading',
			'headline',
			'title',
			'animated heading',
			'ea',
			'essential addons',
		];
	}

	protected function is_dynamic_content():bool {
        return false;
    }

	public function has_widget_inner_wrapper(): bool {
        return ! Helper::eael_e_optimized_markup();
    }

	public function get_custom_help_url()
	{
		return 'https://essential-addons.com/elementor/docs/dual-color-headline/';
	}

	protected function register_controls()
	{
		/**
		 * Dual Color Heading Content Settings
		 */
		$this->start_controls_section(
			'eael_section_dch_content_settings',
			[
				'label' => esc_html__('Content', 'essential-addons-for-elementor-lite'),
			]
		);

		$this->add_control(
			'eael_dch_type',
			[
				'label' => esc_html__('Style', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::SELECT,
				'default' => 'dch-default',
				'label_block' => false,
				'options' => [
					'dch-default' => esc_html__('Default', 'essential-addons-for-elementor-lite'),
					'dch-icon-on-top' => esc_html__('Icon on top', 'essential-addons-for-elementor-lite'),
					'dch-icon-subtext-on-top' => esc_html__('Icon &amp; sub-text on top', 'essential-addons-for-elementor-lite'),
					'dch-subtext-on-top' => esc_html__('Sub-text on top', 'essential-addons-for-elementor-lite'),
				],
			]
		);

		$this->add_control(
			'eael_show_dch_separator',
			[
				'label' => __('Separator', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'essential-addons-for-elementor-lite'),
				'label_off' => __('Hide', 'essential-addons-for-elementor-lite'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'eael_show_dch_icon_content',
			[
				'label' => __('Icon', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => __('Show', 'essential-addons-for-elementor-lite'),
				'label_off' => __('Hide', 'essential-addons-for-elementor-lite'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'eael_dch_icon_new',
			[
				'label' => '',
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'eael_dch_icon',
				'default' => [
					'value' => 'fas fa-snowflake',
					'library' => 'fa-solid',
				],
				'condition' => [
					'eael_show_dch_icon_content' => 'yes',
				],
			]
		);

		$this->add_control(
			'eael_dch_title_content_heading',
			[
				'label' => esc_html__('Title', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'eael_dch_enable_multiple_titles',
			[
				'label'        => esc_html__('Enable Multiple Headings', 'essential-addons-for-elementor-lite'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'eael_dch_first_title',
			[
				'label' => esc_html__('First Part', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__('Dual Heading', 'essential-addons-for-elementor-lite'),
				'dynamic' => ['action' => true],
				'ai' => [
					'active' => false,
				],
				'condition' => [
					'eael_dch_enable_multiple_titles!' => 'yes',
				],
			]
		);

		$this->add_control(
			'eael_dch_last_title',
			[
				'label' => esc_html__('Last Part', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__('Example', 'essential-addons-for-elementor-lite'),
				'dynamic' => ['action' => true],
				'ai' => [
					'active' => false,
				],
				'condition' => [
					'eael_dch_enable_multiple_titles!' => 'yes',
				],
			]
		);

		$multiple_titles = new Repeater();

		$multiple_titles->add_control(
			'eael_dch_title',
			[
				'label'       => esc_html__('Title', 'essential-addons-for-elementor-lite'),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__('Title', 'essential-addons-for-elementor-lite'),
				'dynamic'     => [ 'action' =>true ],
				'ai'          => [ 'active' => false ],
			]
		);
		
		$multiple_titles->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'eael_dch_title_typography',
				'selector' => '{{WRAPPER}} .eael-dual-header .eael-dch-title .eael-dch-title-text{{CURRENT_ITEM}}',
			]
		);

		$multiple_titles->add_control(
			'eael_dch_title_color',
			[
				'label' => esc_html__('Color', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eael-dual-header .eael-dch-title .eael-dch-title-text{{CURRENT_ITEM}}' => 'color: {{VALUE}};',
				],
				'condition' => [
					'eael_dch_title_use_gradient_color!' => 'yes',
				],
			]
		);

		$multiple_titles->add_control(
			'eael_dch_title_use_gradient_color',
			[
				'label' => esc_html__('Use Gradient Color', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
			]
		);

		$multiple_titles->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'eael_dch_title_gradient_color',
				'types'          => [ 'gradient' ],
				'selector'       => '{{WRAPPER}} .eael-dual-header .eael-dch-title .eael-dch-title-text{{CURRENT_ITEM}}',
				'fields_options' => [
					'background' => [
            			'default' => 'gradient',
					],
					'color' => [
						'default' => '#571fff',
					],
					'color_b' => [
						'default' => '#9f12ff',
					],
				],
				'condition' => [
					'eael_dch_title_use_gradient_color' => 'yes',
				],
			]
		);

		$this->add_control(
			'eael_dch_multiple_titles',
			[
				'label'   => '',
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $multiple_titles->get_controls(),
				'default' => [
					[
						'eael_dch_title' => esc_html__('Multiple', 'essential-addons-for-elementor-lite'),
					],
					[
						'eael_dch_title' => esc_html__('Heading', 'essential-addons-for-elementor-lite'),
						'eael_dch_title_color' => '#4d4d4d'
					],
					[
						'eael_dch_title' => esc_html__('Example', 'essential-addons-for-elementor-lite'),
						'eael_dch_title_use_gradient_color' => 'yes'
					],
				],
				'title_field' => '{{{eael_dch_title}}}',
				'button_text' => esc_html__('Add Title', 'essential-addons-for-elementor-lite'),
				'condition' => [
					'eael_dch_enable_multiple_titles' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'       => __('HTML Tag', 'essential-addons-for-elementor-lite'),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => true,
				'default'     => 'h2',
				'options' => [
					'h1' => [
						'title' => __( 'H1', 'essential-addons-for-elementor-lite' ),
						'text' => 'H1',
					],
					'h2' => [
						'title' => __( 'H2', 'essential-addons-for-elementor-lite' ),
						'text' => 'H2',
					],
					'h3' => [
						'title' => __( 'H3', 'essential-addons-for-elementor-lite' ),
						'text' => 'H3',
					],
					'h4' => [
						'title' => __( 'H4', 'essential-addons-for-elementor-lite' ),
						'text' => 'H4',
					],
					'h5' => [
						'title' => __( 'H5', 'essential-addons-for-elementor-lite' ),
						'text' => 'H5',
					],
					'h6' => [
						'title' => __( 'H6', 'essential-addons-for-elementor-lite' ),
						'text' => 'H6',
					],
					'span' => [
						'title' => __( 'Span', 'essential-addons-for-elementor-lite' ),
						'text' => 'SPAN',
					],
					'p' => [
						'title' => __( 'P', 'essential-addons-for-elementor-lite' ),
						'text' => 'P',
					],
					'div' => [
						'title' => __( 'Div', 'essential-addons-for-elementor-lite' ),
						'text' => 'DIV',
					],
				],
				'toggle' => false,
			]
		);

		$this->add_control(
			'eael_dch_subtext',
			[
				'label'       => esc_html__('Sub Text', 'essential-addons-for-elementor-lite'),
				'type'        => Controls_Manager::WYSIWYG,
				'label_block' => true,
				'default'     => esc_html__('Insert a meaningful line to evaluate the headline.', 'essential-addons-for-elementor-lite'),
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'eael_dch_content_alignment',
			[
				'label' => esc_html__('Alignment', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__('Left', 'essential-addons-for-elementor-lite'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'essential-addons-for-elementor-lite'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__('Right', 'essential-addons-for-elementor-lite'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'prefix_class' => 'eael-dual-header-content%s-align-',
			]
		);

		$this->end_controls_section();

		if (!apply_filters('eael/pro_enabled', false)) {
			$this->start_controls_section(
				'eael_section_pro',
				[
					'label' => __('Go Premium for More Features', 'essential-addons-for-elementor-lite'),
				]
			);

			$this->add_control(
				'eael_control_get_pro',
				[
					'label' => __('Unlock more possibilities', 'essential-addons-for-elementor-lite'),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'1' => [
							'title' => '',
							'icon' => 'fa fa-unlock-alt',
						],
					],
					'default' => '1',
					'description' => '<span class="pro-feature"> Get the  <a href="https://wpdeveloper.com/upgrade/ea-pro" target="_blank">Pro version</a> for more stunning elements and customization options.</span>',
				]
			);

			$this->end_controls_section();
		}

		/**
		 * -------------------------------------------
		 * Tab Content ( Seperator )
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'eael_section_dch_separator_settings',
			[
				'label' => __('Separator', 'essential-addons-for-elementor-lite'),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'eael_show_dch_separator' => 'yes',
				],
			]
		);

		$this->add_control(
			'eael_dch_separator_position',
			[
				'label' => __('Position', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'after_title',
				'options' => [
					'before_title' => [
						'title' => __('Before Title', 'essential-addons-for-elementor-lite'),
						'icon' => 'eicon-h-align-left',
					],
					'after_title' => [
						'title' => __('After Title', 'essential-addons-for-elementor-lite'),
						'icon' => 'eicon-h-align-right',
					],
				],
				'toggle' => false
			]
		);
		$this->add_control(
			'eael_dch_separator_type',
			[
				'label' => __('Type', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'line',
				'options' => [
					'line' => [
						'title' => __('Line', 'essential-addons-for-elementor-lite'),
						'icon' => 'eicon-e-divider',
					],
					'icon' => [
						'title' => __('Icon', 'essential-addons-for-elementor-lite'),
						'icon' => 'eicon-icon',
					],
				],
				'toggle' => false
			]
		);
		$this->add_control(
			'eael_dch_separator_icon',
			[
				'label' => '',
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
				'condition' => [
					'eael_dch_separator_type' => 'icon',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------------------------
		 * Tab Style ( Dual Heading Style )
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'eael_section_dch_style_settings',
			[
				'label' => esc_html__('Dual Heading', 'essential-addons-for-elementor-lite'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'eael_dch_bg_color',
			[
				'label' => esc_html__('Background Color', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .eael-dual-header' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'eael_dch_container_padding',
			[
				'label' => esc_html__('Padding', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .eael-dual-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'eael_dch_container_margin',
			[
				'label' => esc_html__('Margin', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .eael-dual-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'eael_dch_border',
				'label' => esc_html__('Border', 'essential-addons-for-elementor-lite'),
				'selector' => '{{WRAPPER}} .eael-dual-header',
			]
		);

		$this->add_control(
			'eael_dch_border_radius',
			[
				'label' => esc_html__('Border Radius', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eael-dual-header' => 'border-radius: {{SIZE}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'eael_dch_shadow',
				'selector' => '{{WRAPPER}} .eael-dual-header',
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------------------------
		 * Tab Style (Icon Style)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'eael_section_dch_icon_style_settings',
			[
				'label' => esc_html__('Icon', 'essential-addons-for-elementor-lite'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'eael_show_dch_icon_content' => 'yes',
				],
			]
		);

		$this->add_control(
			'eael_dch_icon_size',
			[
				'label' => __('Size', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 36,
				],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 500,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eael-dual-header i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .eael-dual-header img' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .eael-dual-header .eael-dch-svg-icon' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .eael-dual-header .eael-dch-svg-icon svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'eael_dch_icon_color',
			[
				'label' => esc_html__('Color', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::COLOR,
				'default' => '#4d4d4d',
				'selectors' => [
					'{{WRAPPER}} .eael-dual-header i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .eael-dual-header svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------------------------
		 * Tab Style (Title Style)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'eael_section_dch_title_style_settings',
			[
				'label' => esc_html__('Color &amp; Typography', 'essential-addons-for-elementor-lite'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'eael_dch_title_heading',
			[
				'label' => esc_html__('Title', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'eael_dch_title_common_color',
			[
				'label'     => esc_html__('Color', 'essential-addons-for-elementor-lite'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#9401D9',
				'selectors' => [
					'{{WRAPPER}} .eael-dual-header .eael-dch-title' => 'color: {{VALUE}};',
				],
				'condition' => [
					'eael_dch_enable_multiple_titles' => 'yes'
				],
			]
		);

		$this->add_control(
			'eael_dch_base_title_color',
			[
				'label' => esc_html__('Main Color', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::COLOR,
				'default' => '#4d4d4d',
				'selectors' => [
					'{{WRAPPER}} .eael-dual-header .title' => 'color: {{VALUE}};',
				],
				'condition' => [
					'eael_dch_enable_multiple_titles!' => 'yes'
				],
			]
		);

		$this->add_control(
			'eael_dch_dual_color_selector',
			[
				'label' => esc_html__('Dual Color', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'solid-color' => [
						'title' => __('Color', 'essential-addons-for-elementor-lite'),
						'icon' => 'eicon-paint-brush',
					],
					'gradient-color' => [
						'title' => __('Gradient', 'essential-addons-for-elementor-lite'),
						'icon' => 'eicon-barcode',
					],
				],
				'condition' => [
					'eael_dch_enable_multiple_titles!' => 'yes'
				],
				'toggle' => true,
				'default' => 'solid-color',
			]
		);

		$this->add_control(
			'eael_dch_dual_title_color',
			[
				'label' => esc_html__('Solid Color', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::COLOR,
				'default' => '#9401D9',
				'selectors' => [
					'{{WRAPPER}} .eael-dual-header .title span.lead' => 'color: {{VALUE}};',
				],
				'condition' => [
					'eael_dch_dual_color_selector' => 'solid-color',
					'eael_dch_enable_multiple_titles!' => 'yes'
				],
			]
		);

        $this->add_control(
			'eael_dch_dual_title_color_gradient_first',
			[
				'label' => esc_html__('First Color', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::COLOR,
				'default' => '#062ACA',
				'condition' => [
					'eael_dch_dual_color_selector' => 'gradient-color',
					'eael_dch_enable_multiple_titles!' => 'yes'
				],
			]
		);

        $this->add_control(
			'eael_dch_dual_title_color_gradient_second',
			[
				'label' => esc_html__('Second Color', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::COLOR,
				'default' => '#9401D9',
				'condition' => [
					'eael_dch_dual_color_selector' => 'gradient-color',
					'eael_dch_enable_multiple_titles!' => 'yes'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'eael_dch_first_title_typography',
				'selector' => '{{WRAPPER}} .eael-dual-header .title, {{WRAPPER}} .eael-dual-header .title span',
			]
		);

		$this->add_control(
			'eael_dch_sub_title_heading',
			[
				'label' => esc_html__('Sub-title', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'eael_dch_subtext_color',
			[
				'label' => esc_html__('Color', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::COLOR,
				'default' => '#4d4d4d',
				'selectors' => [
					'{{WRAPPER}} .eael-dual-header .subtext' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'eael_dch_subtext_typography',
				'selector' => '{{WRAPPER}} .eael-dual-header .subtext',
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------------------------
		 * Tab Style (Separator)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'eael_section_dch_separator_style_settings',
			[
				'label' => esc_html__('Separator', 'essential-addons-for-elementor-lite'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'eael_show_dch_separator' => 'yes',
				],
			]
		);

		$this->add_control(
			'eael_section_dch_separator_icon_size',
			[
				'label' => __('Icon Size', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 36,
				],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 500,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eael-dual-header .eael-dch-separator-wrap i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .eael-dual-header .eael-dch-separator-wrap img' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .eael-dual-header .eael-dch-separator-wrap svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'eael_dch_separator_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'eael_section_dch_separator_icon_color',
			[
				'label' => esc_html__('Icon Color', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::COLOR,
				'default' => '#4d4d4d',
				'selectors' => [
					'{{WRAPPER}} .eael-dual-header .eael-dch-separator-wrap i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .eael-dual-header .eael-dch-separator-wrap svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'eael_dch_separator_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'eael_section_dch_separator_alignment',
			[
				'label' => __('Alignment', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __('Flex Start', 'essential-addons-for-elementor-lite'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __('Center', 'essential-addons-for-elementor-lite'),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => __('Flex End', 'essential-addons-for-elementor-lite'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .eael-dch-separator-wrap' => 'justify-content: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'eael_section_dch_separator_distance',
			[
				'label' => __('Distance Between Lines', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eael-dch-separator-wrap .separator-one' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .eael-dch-separator-wrap .separator-two' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'eael_dch_separator_type' => 'line',
				],
			]
		);
		$this->add_control(
			'eael_section_dch_separator_margin',
			[
				'label' => __('Margin', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .eael-dch-separator-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => __('Color', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY
				],
				'selectors' => [
					'{{WRAPPER}} .eael-dch-separator-wrap i' => 'color: {{VALUE}}',
				],
				'condition' => [
					'eael_dch_separator_type' => 'icon',
				],
			]
		);

		// line left & right Tabs
		$this->start_controls_tabs(
			'eael_dch_separator_tabs',
			[
				'condition' => [
					'eael_dch_separator_type' => 'line',
				],
			]
		);

		$this->start_controls_tab(
			'eael_dch_separator_left_tab',
			[
				'label' => __('Left Line', 'essential-addons-for-elementor-lite'),
			]
		);

		// line left style
		$this->add_control(
			'eael_dch_separator_left_width',
			[
				'label' => __('Width', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .eael-dch-separator-wrap .separator-one' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'eael_dch_separator_left_height',
			[
				'label' => __('Height', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .eael-dch-separator-wrap .separator-one' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'eael_dch_separator_left_radius',
			[
				'label' => __('Radius', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .eael-dch-separator-wrap .separator-one' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'eael_dch_separator_left_bg',
				'label' => __('Background', 'essential-addons-for-elementor-lite'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .eael-dch-separator-wrap .separator-one',
			]
		);
		$this->end_controls_tab();
		// line right style
		$this->start_controls_tab(
			'eael_dch_separator_right_tab',
			[
				'label' => __('Right Line', 'essential-addons-for-elementor-lite'),
			]
		);
		$this->add_control(
			'eael_dch_separator_right_width',
			[
				'label' => __('Width', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .eael-dch-separator-wrap .separator-two' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'eael_dch_separator_right_height',
			[
				'label' => __('Height', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .eael-dch-separator-wrap .separator-two' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'eael_dch_separator_right_radius',
			[
				'label' => __('Radius', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .eael-dch-separator-wrap .separator-two' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'eael_dch_separator_right_bg',
				'label' => __('Background', 'essential-addons-for-elementor-lite'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .eael-dch-separator-wrap .separator-two',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
        $gradient_style = '';
		$has_gradient = $settings['eael_dch_dual_title_color_gradient_first']  && $settings['eael_dch_dual_title_color_gradient_second'];
        if ( $has_gradient ) {
            $gradient_1 = Helper::eael_fetch_color_or_global_color($settings, 'eael_dch_dual_title_color_gradient_first');
            $gradient_2 = Helper::eael_fetch_color_or_global_color($settings, 'eael_dch_dual_title_color_gradient_second');
            $gradient_style = 'background: linear-gradient('. esc_attr( $gradient_1 ) . ', '. esc_attr( $gradient_2 ) .');';
        };
		$icon_migrated = isset($settings['__fa4_migrated']['eael_dch_icon_new']);
		$icon_is_new = empty($settings['eael_dch_icon']);
		// separator
		$separator_markup = '<div class="eael-dch-separator-wrap">';
		if ($settings['eael_dch_separator_type'] == 'icon') {
            ob_start();
			Icons_Manager::render_icon( $settings['eael_dch_separator_icon'], [ 'aria-hidden' => 'true' ] );
			$separator_markup .= ob_get_clean();
		} else {
			$separator_markup .= '<span class="separator-one"></span>
			<span class="separator-two"></span>';
		}
		$separator_markup .= '</div>'; 
		
		$title_tag = Helper::eael_validate_html_tag( $settings['title_tag'] );
		$title_html = '<' . $title_tag . ' class="title eael-dch-title">';

		if( ! empty( $settings['eael_dch_enable_multiple_titles'] ) && 'yes' == $settings['eael_dch_enable_multiple_titles'] ) {
			foreach( $settings['eael_dch_multiple_titles'] as $title ) {
				$classes = 'eael-dch-title-text elementor-repeater-item-' . esc_attr( $title['_id'] );
				if( 'yes' == $title['eael_dch_title_use_gradient_color'] ) {
					$classes .= ' eael-dch-title-gradient';
				}		
				$title_html .= '<span class="' . $classes . '">' . $title['eael_dch_title'] . '</span> ';
			}
		} else {
			$title_html .= '<span';
			if( $has_gradient ){
				$title_html .= ' style="' . $gradient_style . '" ';
			}
			$title_html .= ' class="eael-dch-title-text eael-dch-title-lead lead ' . $settings['eael_dch_dual_color_selector'] . '">' . $settings['eael_dch_first_title'] . '</span>';
			$title_html .= ' <span class="eael-dch-title-text">' . $settings['eael_dch_last_title'] . '</span>';
		}
		
		$title_html .= '</' . $title_tag . '>';

		if ('dch-default' == $settings['eael_dch_type']) : ?>
			<div class="eael-dual-header">
				<?php 
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo ($settings['eael_dch_separator_position'] === 'before_title' ? $separator_markup : '');
				echo wp_kses( $title_html, Helper::eael_allowed_tags() );
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo ( $settings['eael_dch_separator_position'] === 'after_title' ? $separator_markup : '');

				if( ! empty( $settings['eael_dch_subtext'] ) ) : ?>
					<span class="subtext"><?php
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo $this->parse_text_editor( $settings['eael_dch_subtext'] ); ?></span>
				<?php endif;

				if ('yes' == $settings['eael_show_dch_icon_content']) : ?>
					<?php if ($icon_is_new || $icon_migrated) {
						echo '<span class="eael-dch-svg-icon">';
						Icons_Manager::render_icon( $settings['eael_dch_icon_new'], [ 'aria-hidden' => 'true' ] );
						echo '</span>';

					} else { ?>
						<i class="<?php echo esc_attr( $settings['eael_dch_icon'] ); ?>"></i>
					<?php } ?>
				<?php endif; #if ('yes' == $settings['eael_show_dch_icon_content']) ?>
			</div>

		<?php elseif ('dch-icon-on-top' == $settings['eael_dch_type']) : ?>
			<div class="eael-dual-header">
				<?php if ('yes' == $settings['eael_show_dch_icon_content']) : ?>
					<?php if ($icon_is_new || $icon_migrated) {
						echo '<span class="eael-dch-svg-icon">';
						Icons_Manager::render_icon( $settings['eael_dch_icon_new'], [ 'aria-hidden' => 'true' ] );
						echo '</span>';

					} else { ?>
						<i class="<?php echo esc_attr($settings['eael_dch_icon']); ?>"></i>
					<?php } ?>
				<?php endif; #if ('yes' == $settings['eael_show_dch_icon_content']) ?>
				<?php 
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo ($settings['eael_dch_separator_position'] === 'before_title' ? $separator_markup : ''); 
				echo wp_kses( $title_html, Helper::eael_allowed_tags() );
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo ($settings['eael_dch_separator_position'] === 'after_title' ? $separator_markup : ''); ?>
				<span class="subtext"><?php echo wp_kses( $settings['eael_dch_subtext'], Helper::eael_allowed_tags() ); ?></span>
			</div>
		<?php elseif ('dch-icon-subtext-on-top' == $settings['eael_dch_type']) : ?>
			<div class="eael-dual-header">
				<?php if ('yes' == $settings['eael_show_dch_icon_content']) : ?>
					<?php if ($icon_is_new || $icon_migrated) {
						echo '<span class="eael-dch-svg-icon">';
						Icons_Manager::render_icon( $settings['eael_dch_icon_new'], [ 'aria-hidden' => 'true' ] );
						echo '</span>';

					} else { ?>
						<i class="<?php echo esc_attr($settings['eael_dch_icon']); ?>"></i>
					<?php } ?>
				<?php endif; #if ('yes' == $settings['eael_show_dch_icon_content']) ?>
				<span class="subtext"><?php echo wp_kses( $settings['eael_dch_subtext'], Helper::eael_allowed_tags() ); ?></span>
				<?php 
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo ($settings['eael_dch_separator_position'] === 'before_title' ? $separator_markup : ''); 
				echo wp_kses( $title_html, Helper::eael_allowed_tags() );
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo ($settings['eael_dch_separator_position'] === 'after_title' ? $separator_markup : '');
				?>
			</div>
		<?php elseif ('dch-subtext-on-top' == $settings['eael_dch_type']) : ?>
			<div class="eael-dual-header">
				<span class="subtext"><?php echo wp_kses( $settings['eael_dch_subtext'], Helper::eael_allowed_tags() ); ?></span>
				<?php
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo ($settings['eael_dch_separator_position'] === 'before_title' ? $separator_markup : '');
				echo wp_kses( $title_html, Helper::eael_allowed_tags() ); 
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo ($settings['eael_dch_separator_position'] === 'after_title' ? $separator_markup : '');
				?>
				<?php if ('yes' == $settings['eael_show_dch_icon_content']) : ?>
					<?php if ($icon_is_new || $icon_migrated) {
						echo '<span class="eael-dch-svg-icon">';
						Icons_Manager::render_icon( $settings['eael_dch_icon_new'], [ 'aria-hidden' => 'true' ] );
						echo '</span>';

					} else { ?>
						<i class="<?php echo esc_attr($settings['eael_dch_icon']); ?>"></i>
					<?php } ?>
				<?php endif; #if ('yes' == $settings['eael_show_dch_icon_content']) ?>
			</div>
		<?php endif; 
	}
}
