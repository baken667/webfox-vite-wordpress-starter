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
            // echo '<script type="module" crossorigin src="' . VITE_SERVER . VITE_ENTRY_POINT . '></script>';
            // echo '<!-- '. VITE_ENTRY_POINT .' -->';
            echo '<script type="module" crossorigin src="' . VITE_SERVER . VITE_ENTRY_POINT . '"></script>';
        }

        add_action('wp_head', 'vite_head_module_hook');
    } else {
        $manifest = json_decode(file_get_contents(DIST_PATH . '/manifest.json'), true);

        if (is_array($manifest)) {
            $manifest_key = array_keys($manifest);

            if (isset($manifest_key[0])) {
                foreach (@$manifest_key[0]['css'] as $css_file) {
                    wp_enqueue_style('main', DIST_URI . '/' . $css_file);
                }

                $js_file = @$manifest[$manifest_key[0]]['file'];

                if (!empty($js_file)) {
                    wp_enqueue_script('main', DIST_URI . '/' . $js_file, JS_DEPENDENCIES, '', JS_LOAD_IN_FOOTER);
                }
            }
        }
    }
});