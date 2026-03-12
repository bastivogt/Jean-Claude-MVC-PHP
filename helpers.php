<?php


/**
 * Get the base path
 * 
 * @param strimg $path
 * @return string
 */
function basePath($path = "") {
    return __DIR__ . "/" . $path;
}


/**
 * Load a view
 * 
 * @param string $name
 * @return void
 */
function view($name, $context = []) {
    $file = basePath("app/views/$name.view.php");
    if(file_exists($file)) {
        extract($context);
        require $file;

    }else {
        echo "View '$name' not found";
    }
}


/**
 * Load a partial
 * 
 * @param string $name
 * @return void
 */
function loadPartial($name) {
    $file = basePath("app/views/partials/$name.php");
    if(file_exists($file)) {
        require $file;
    }else {
        echo "Partial '$name' not found!";
    }
}

/**
 * Inspect a value(s)
 * 
 * @param mixed $value
 * @return void
 */
function d($value) {
    echo "<pre style='background-color: black; color: lime; padding: 10px;'>";
    var_dump($value);
    echo "</pre>";
}



/**
 * Inspect a value(s) and die
 * 
 * @param mixed $value
 * @return void
 */
function dd($value) {
    d($value);
    die;
}