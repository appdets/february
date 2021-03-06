<?php

defined('ABSPATH') or die('No script kiddies please!');

if (!class_exists('February')) {
        final class February
        {

                public $options = array();

                # Default options
                protected $default_options = array(
                        'id' => '',
                        'title' => '',
                        'description' => '',
                        'condition' => '',
                );

                # Sanitizer
                function sanitize_inputs($inputs = [])
                {
                        if (is_array($inputs)) {
                                foreach ($inputs as $key => $value) {
                                        $inputs[$key] = sanitize_text_field($value);
                                }
                        }
                        return $inputs;
                }

                # Get requested inputs
                function inputs()
                {
                        try {
                                $json = file_get_contents('php://input');
                                $request = json_decode(sanitize_text_field($json));
                        } catch (\Exception $e) {
                        }

                        if (!$request || empty($request)) {
                                $request =  $_REQUEST;
                        }

                        $request = $this->sanitize_inputs($request);

                        return (object) $request;
                }

                # Input fields
                public function input_fields()
                {
                        return apply_filters('february_fields', ['text', 'textarea', 'checkbox', 'multi_checkbox', 'tab', 'switch', 'multi_switch', 'radio', 'select', 'number', 'email', 'url', 'password', 'color', 'date', 'time', 'range', 'media', 'editor', 'repeater', 'css', 'js']);
                }

                # Initialize
                static public function create($options = array())
                {
                        $instance = new self();
                        $instance->options = $options;
                        $instance->init_hooks();
                }

                #  Register hooks
                public function init_hooks()
                {
                        add_action('init', [$this, 'reset_options']);
                        add_action('wp_ajax_february_save_options', array($this, 'ajax_save_options'));
                        add_action('wp_ajax_february_reset_options', array($this, 'ajax_reset_options'));
                        add_action('admin_menu', array($this, 'add_menu_page'));
                        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
                }

                # Ajax handler for saving options
                function ajax_save_options()
                {
                        $inputs = $this->inputs();

                        $this->save_options($inputs->options);

                        wp_send_json_success($inputs->options);
                        wp_die();
                }

                # Ajax handler for resetting options
                function ajax_reset_options()
                {
                        $this->reset_options();
                        wp_send_json_success();
                        wp_die();
                }

                # Get id
                public function get_id()
                {
                        return $this->options && isset($this->options['id']) ? $this->options['id'] : sanitize_title($this->options['menu_title']);
                }

                # Get field defaults
                public function field_default_values()
                {
                        $sections = array_filter($this->options['sections'], function ($item) {
                                return isset($item['fields']) && is_array($item['fields']);
                        });

                        $section_fields = array_reduce($sections, function ($carry, $item) {
                                return array_merge($carry, $item['fields']);
                        }, []);

                        $fields = array_filter($section_fields, function ($item) {
                                return isset($item['id']) && isset($item['type']) && in_array($item['type'], $this->input_fields());
                        });

                        // default fields 
                        $default_fields = array_map(function ($item) {
                                return [
                                        'id' => $item['id'],
                                        'default' => isset($item['default']) ? $item['default'] : '',
                                ];
                        }, $fields);

                        return $default_fields;
                }

                # Reset options
                public function reset_options()
                {
                        $id = $this->get_id();
                        $requested_id = $this->inputs()->id ?? '';

                        if ($requested_id !== $id) {
                                return;
                        }

                        $fields =  $this->field_default_values();

                        foreach ($fields as $field) {
                                add_option($id . '_' . $field['id'], $field['default']);
                        }
                }

                # Save options
                public function save_options($options = [])
                {
                        $id = $this->get_id();
                        $requested_id = $this->inputs()->id ?? '';

                        if ($requested_id !== $id) {
                                return;
                        }

                        foreach ($options as $key => $value) {
                                update_option($id . '_' . $key, $value);
                        }
                }

                # Get options
                public function get_options($id = null)
                {
                        $id = $id ?? $this->get_id();

                        global $wpdb;
                        $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}options WHERE `option_name` LIKE '{$id}%'");
                        $rows = $wpdb->get_results($sql);
                        if ($rows) {

                                $options = [];

                                foreach ($rows as $row) {
                                        $option_name = str_replace($id . '_', '', $row->option_name);
                                        $options[$option_name] = maybe_unserialize($row->option_value);
                                }

                                return $options;
                        } else {
                                return false;
                        }
                }

                # Get field
                public static function get_field($name, $id = 'option')
                {
                        $value = get_option($id . '_' . $name);
                        return $value;
                }

                # Add menu page
                public function add_menu_page()
                {
                        if (!$this->options) {
                                return;
                        }

                        if (isset($this->options['parent_menu']) && $this->options['parent_menu']) {
                                add_submenu_page($this->options['parent_menu'], $this->options['menu_title'], $this->options['menu_title'], $this->options['capability'], $this->options['menu_slug'], array($this, 'render_page'));
                        } else {
                                add_menu_page($this->options['menu_title'], $this->options['menu_title'], $this->options['capability'], $this->options['menu_slug'], array($this, 'render_page'), $this->options['icon_url'], $this->options['position']);
                        }
                }

                # Render page
                public function render_page()
                {
                        # enqueue localize scripts
                        add_filter('february_localize_script', array($this, 'localize_script'), 0);

                        $this->render_body();

                        # filter footer 
                        add_filter('admin_footer_text', array($this, 'filter_footer'));
                }

                # Get object scripts
                function getOptionScript()
                {
                        $sections = array_map(function ($section) {
                                $fields = array_map(function ($field) {
                                        if (isset($field['type']) && in_array($field['type'], $this->input_fields())) {
                                                $value = get_option($this->get_id() . '_' . $field['id']);
                                                $field['value'] = in_array($field['type'], ['switch', 'checkbox']) ? (bool) $value : $value;
                                        }
                                        return $field;
                                }, $section['fields']);
                                $section['fields'] = $fields;
                                return $section;
                        }, $this->options['sections']);


                        $this->options['sections'] = $sections;
                        return $this->options;
                }

                # Localize script
                function localize_script()
                {

                        $script = $this->getOptionScript();
                        $script['ajax_url'] = admin_url('admin-ajax.php');
                        $script['nonce'] = wp_create_nonce('february_nonce');
                        $script['input_fields'] = $this->input_fields();

                        return $script;
                }

                # Filter footer
                function filter_footer()
                {
                        echo __('<span id="footer-thankyou">Thank you for choosing <a href="https://wordpress.org/plugins/february-framework/" target="_blank">February Framework</a>.</span>');
                }

                # Render body
                public function render_body()
                {
                        if (file_exists(__DIR__ . '/february-template.php')) include_once  __DIR__ . '/february-template.php';
                }

                # Enqueue scripts
                function enqueue_scripts()
                {

                        $page = $_GET['page'] ?? '';


                        if ($page != $this->options['menu_slug']) return false;

                        wp_register_script('february_data', '');
                        wp_localize_script('february_data', 'february_data', $this->localize_script());
                        wp_enqueue_script('february_data');

                        wp_enqueue_style('february-style', plugins_url('february.min.css', __FILE__));
                        wp_enqueue_script('february-script', plugins_url('february.min.js', __FILE__));
                }

                # Render field
                function render_field($field)
                {
                        $value = get_option($field['id']);
                        if (!$value) {
                                $value = $field['default'];
                        }
                }
        }
}
