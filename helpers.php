<?php


/**
 * Get the base path
 * 
 * @param strimg $path
 * @return string
 */
function basePath($path = "")
{
    return __DIR__ . "/" . $path;
}


/**
 * Load a view
 * 
 * @param string $name
 * @return void
 */
function view(string $name, array $context = []): void
{
    $file = basePath("app/views/$name.view.php");
    if (file_exists($file)) {
        ob_start();
        extract($context);
        require $file;
        $tpl = ob_get_clean();
        echo $tpl;
    } else {
        echo "View '$name' not found";
    }
}


/**
 * Load a partial
 * 
 * @param string $name
 * @return void
 */
function loadPartial(string $name): void
{
    $file = basePath("app/views/partials/$name.php");
    if (file_exists($file)) {
        require $file;
    } else {
        echo "Partial '$name' not found!";
    }
}

/**
 * Inspect a value(s)
 * 
 * @param mixed $value
 * @return void
 */
function d(mixed $value): void
{
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
function dd(mixed $value): void
{
    d($value);
    die;
}



function esc(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, "UTF-8", true);
}
