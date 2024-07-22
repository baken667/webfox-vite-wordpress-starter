<?php

if (!defined("ABSPATH"))
    exit;

const DIST_DEF = 'dist';
const VITE_SERVER = 'http://localhost:3000';
const VITE_ENTRY_POINT = '/main.js';
const JS_LOAD_IN_FOOTER = true;

define('DIST_URI', get_template_directory_uri() . '/' . DIST_DEF);
define('DIST_PATH', get_template_directory() . '/' . DIST_DEF);

define('JS_DEPENDENCIES', []);

add_action('wp_enqueue_scripts', function () {
    if (defined('IS_VITE_DEVELOPMENT') && IS_VITE_DEVELOPMENT === true) {
        function vite_head_module_hook()
        {
            echo '<script type="module" crossorigin src="' . VITE_SERVER . VITE_ENTRY_POINT . '"></script>';
        }

        add_action('wp_head', 'vite_head_module_hook');
    } else {
        $manifest = json_decode(file_get_contents(DIST_PATH . '/.vite/manifest.json'), true);

        if (is_array($manifest)) {

            foreach($manifest as $entry) {
                if (isset($entry['css'])) {
                    foreach($entry['css'] as $css_file) {
                        wp_enqueue_style('main', DIST_URI . '/' . $css_file);
                    }
                }

                if (isset($entry['file'])) {
                    wp_enqueue_script('main', DIST_URI.'/'. $entry['file'], JS_DEPENDENCIES, '', JS_LOAD_IN_FOOTER);
                }
            }
        }
    }
});