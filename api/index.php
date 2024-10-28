<?php
// Categories URL: https://cdn.apc.360.cn/index.php?c=WallPaper&a=getAllCategoriesV2&from=360chrome
// Latest wallpapers URL: https://wallpaper.apc.360.cn/index.php?c=WallPaper&a=getAppsByOrder&order=create_time&start=[start index]&count=[number of wallpapers]&from=360chrome
// Category wallpapers URL: https://wallpaper.apc.360.cn/index.php?c=WallPaper&a=getAppsByCategory&cid=[category ID]&start=[start index]&count=[number of wallpapers]&from=360chrome

$cid = getParam('cid', '360new');

switch($cid) {
    case '360new':  // 360 Wallpaper - Latest images
        $start = getParam('start', 0);
        $count = getParam('count', 10);
        echoJson(file_get_contents("https://wallpaper.apc.360.cn/index.php?c=WallPaper&a=getAppsByOrder&order=create_time&start={$start}&count={$count}&from=360chrome"));
        break;
    
    case '360tags':  // 360 Wallpaper - All categories
        echoJson(file_get_contents("https://cdn.apc.360.cn/index.php?c=WallPaper&a=getAllCategoriesV2&from=360chrome"));
        break;
    
    case 'bing':  // Bing - Daily images
        $start = getParam('start', -1);
        $count = getParam('count', 8);
        echoJson(file_get_contents("https://cn.bing.com/HPImageArchive.aspx?format=js&idx={$start}&n={$count}"));
        break;
    
    default:  // Category wallpapers
        $start = getParam('start', 0);
        $count = getParam('count', 10);
        echoJson(file_get_contents("https://wallpaper.apc.360.cn/index.php?c=WallPaper&a=getAppsByCategory&cid={$cid}&start={$start}&count={$count}&from=360chrome"));
}

/**
 * Retrieve a GET or POST parameter
 * @param string $key Key for the parameter
 * @param mixed $default Default value if the parameter is not found
 * @return mixed The parameter value, or the default value if not found
 */
function getParam($key, $default = '') {
    return trim(
        is_string($key) && $key ? 
        (isset($_POST[$key]) ? $_POST[$key] : (isset($_GET[$key]) ? $_GET[$key] : $default)) 
        : $default
    );
}

/**
 * Output data in JSON or JSONP format
 * @param string $data The data to be output
 */
function echoJson($data) {
    header('Content-Type: application/json');
    $callback = getParam('callback');
    if ($callback != '') {
        // Output JSONP format if callback is specified
        die(htmlspecialchars($callback) . '(' . $data . ')');
    } else {
        // Output standard JSON format
        die($data);
    }
}
