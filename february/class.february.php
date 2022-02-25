<?php

defined('ABSPATH') or die('No script kiddies please!');

if (!class_exists('February')) {
        final class February
        {

                public $options = array();

                protected $default_options = array(
                        'id' => '',
                        'title' => '',
                        'description' => '',
                        'condition' => '',
                );

                static public function create($options = array())
                {
                        $instance = new self();
                        $instance->options = $options;
                        $instance->init_options();
                }

                public function init_options()
                {
                        add_action('admin_menu', array($this, 'add_menu_page'));
                        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
                }

                public function add_menu_page()
                {
                        add_menu_page(
                                $this->options['menu_title'] ?? 'February Options',
                                $this->options['menu_title'] ?? 'February Options',
                                $this->options['capability'] ?? 'manage_options',
                                $this->options['menu_slug'] ?? sanitize_title($this->options['menu_title']) ?? 'february-options',
                                array($this, 'render_menu_page'),
                                $this->options['icon_url'] ?? 'dashicons-admin-generic',
                                $this->options['position'] ?? null
                        );
                }

                public function render_menu_page()
                {
                        // enqueue localize scripts
                        add_filter('february_localize_script', array($this, 'localize_script'), 0);

                        $this->render_body();

                        // filter footer 

                        add_filter('admin_footer_text', array($this, 'filter_footer'));
                }

                function getOptionScript () {
                        return $this->options;
                }

                function localize_script()
                {

                        $script = $this->getOptionScript();

                        $script['ajax_url'] = admin_url('admin-ajax.php');
                        $script['nonce'] = wp_create_nonce('february_nonce');

                        return $script;
                }

                function filter_footer()
                {
                        echo __('<span id="footer-thankyou">Thank you for choosing <a href="https://wordpress.org/plugins/february-framework/" target="_blank">February Framework</a>.</span>');
                }

                public function render_body()
                {
                        if (file_exists(__DIR__ . '/menu-page.php')) include_once  __DIR__ . '/menu-page.php';
                }

                function enqueue_scripts($hook)
                {
                        if ($hook != 'toplevel_page_' . $this->options['menu_slug']) return false;

                        wp_register_script('february_data', '');
                        wp_localize_script('february_data', 'february_data', $this->localize_script());
                        wp_enqueue_script('february_data');

                        wp_enqueue_style('february-style', plugins_url('february.min.css', __FILE__));
                        wp_enqueue_script('february-script', plugins_url('february.min.js', __FILE__));
                }

                function render_field($field)
                {
                        $value = get_option($field['id']);
                        if (!$value) {
                                $value = $field['default'];
                        }
                }
        }
}
