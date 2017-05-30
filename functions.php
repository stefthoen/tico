<?php

$timber = new \Timber\Timber();
$dirs = get_directories('components');
Timber::$dirname = array_merge(add_components_dir($dirs), ['views']);

/*
 * @todo: Check if file exists before trying to enqueue it.
 */
add_action('wp_enqueue_scripts', function() use ($dirs) {
    foreach ($dirs as $file) {
        wp_enqueue_style("c-$file", get_template_directory_uri()
        . "/components/$file/$file.css");
    }
});

function get_directories($components_dir) {
    $dir = get_template_directory() . '/' . $components_dir;
    $dir_iterator = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);

    return array_reduce(iterator_to_array($dir_iterator, true), function($dirs, $dir) use ($components_dir) {
        $dirs[] = $dir->getFilename();
        return $dirs;
    }, []);
}

function add_components_dir($dirs) {
    return array_map(function($dir) {
        return 'components/' . $dir;
    }, $dirs);
}
