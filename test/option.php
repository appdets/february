<?php 

// load the class 
require_once( plugin_dir_path( __FILE__ ) . '/../february/class.february.php' );

$options = [
    'menu_title' => 'February Options',
    'menu_slug' => 'february-options',
    'capability' => 'manage_options',
    'icon_url' => 'dashicons-admin-generic',
    'position' => null,
    
    'label' => 'February Options',
    'description' => 'A simple options page with a few options.',
    'default' => false,
    "tools" => true,
            
    'sections' => [
        [
            'id' => 'february-options',
            'title' => 'February Options',
            'description' => 'A simple options page with a few options.',
            'condition' => '',
            'submit' => 'Save Settings',
            
            'fields' => [
                [
                    'id' => 'text',
                    'type' => 'text',
                    'label' => 'Text',
                    'description' => 'A simple text field.',
                    'default' => '',
                ],
                [
                    'id' => 'textarea',
                    'type' => 'textarea',
                    'label' => 'Textarea',
                    'description' => 'A simple textarea field.',
                    'default' => '',
                ],
                [
                    'id' => 'checkbox',
                    'type' => 'checkbox',
                    'label' => 'Checkbox',
                    'description' => 'A simple checkbox field.',
                    'default' => '',
                ],
                [
                    'id' => 'radio',
                    'type' => 'radio',
                    'label' => 'Radio',
                    'description' => 'A simple radio field.',
                    'default' => '',
                    'options' => [
                        'option-1' => 'Option 1',
                        'option-2' => 'Option 2',
                        'option-3' => 'Option 3',
                    ],
                ],
                [
                    'id' => 'select',
                    'type' => 'select',
                    'label' => 'Select',
                    'description' => 'A simple select field.',
                    'default' => '',
                    'options' => [
                        'option-1' => 'Option 1',
                        'option-2' => 'Option 2',
                        'option-3' => 'Option 3',
                    ],
                ],
                [
                    'id' => 'select_multiple',
                    'type' => 'select_multiple',
                    'label' => 'Select Multiple',
                    'description' => 'A simple select multiple field.',
                    'default' => '',
                    'options' => [
                        'option-1' => '
                        Option 1',
                        'option-2' => '
                        Option 2',
                        'option-3' => '
                        Option 3',
                    ],
                ]],
        ],
    ],
                
];

new February($options);