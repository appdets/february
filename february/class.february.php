<?php

final class February
{

        public $options = array();
        public $sections = array();

        public function __construct($options = array())
        {
                $this->options = $options;
                $this->sections = $options['sections'];
                if ($this->options) $this->init();
        }

        public function init()
        {
                add_action('admin_menu', array($this, 'add_menu'));
                add_action('admin_init', array($this, 'register_settings'));
                add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        }

        public function add_menu()
        {
                add_menu_page(
                        $this->options['menu_title'],
                        $this->options['menu_title'],
                        $this->options['capability'],
                        $this->options['menu_slug'],
                        array($this, 'render_page'),
                        $this->options['icon_url'],
                        $this->options['position']
                );
        }

        public function render_page()
        {
                $this->render_body(); 

                // filter footer 

                add_filter('admin_footer_text', array($this, 'filter_footer'));
        }

        function filter_footer()
        {
                echo __('<span id="footer-thankyou">Thank you for creating with <a href="https://wordpress.org/plugins/february-framework/" target="_blank">February Framework</a>.</span>');
        }

        public function render_body()
        {
                include_once  __DIR__ . '/template.php';
        }
 
        public function register_settings()
        {
                register_setting($this->options['menu_slug'], $this->options['menu_slug']);
                foreach ($this->sections as $section) {
                        add_settings_section($section['id'], $section['title'], array($this, 'render_section'), $this->options['menu_slug']);
                        foreach ($section['fields'] as $field) {
                                add_settings_field($field['id'], $field['label'], array($this, 'render_field'), $this->options['menu_slug'], $section['id'], $field);
                        }
                }
        }

        public function render_section($section)
        {
                if (isset($section['description'])) {
                        echo '<p>' . $section['description'] . '</p>';
                }
        }

        function enqueue_scripts($hook)
        {

                if ($hook != 'toplevel_page_february-options') return false;
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
