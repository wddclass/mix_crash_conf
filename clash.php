<?php

$param_template_url = isset($_GET['template']) ? $_GET['template'] : '';
$param_url_key = isset($_GET['urlKey']) ? $_GET['urlKey'] : '';
$param_file_name = isset($_GET['name']) ? $_GET['name'] : '';
$param_url = isset($_GET['url']) ? $_GET['url'] : '';

$template_context = file_get_contents($param_template_url, false);
// echo $template_context;

$options = array(
    'http' => array(
        'header' => "User-Agent: clash"
    )
);
$context = stream_context_create($options);
$res = file_get_contents($param_url, false, $context);
$url_headers = get_headers($param_url, false, $context);

foreach ($url_headers as $key => $value) {
    if (strpos($value, 'ubscription')) {
        header($value);
    }   
}
header('Content-Type: text/plain');
header('content-disposition:attachment; filename=' . $param_file_name . '');


$clash_content = str_replace($param_url_key, $param_url, $template_context);
if (!empty($param_file_name)) {
    $clash_content = str_replace("Subscribe", $param_file_name, $clash_content);
}

echo $clash_content;
?>
