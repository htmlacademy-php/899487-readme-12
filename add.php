<?php
require_once('./helpers.php');
require_once('./db-data.php');

$connection = getConnection();

function createQueryToAddPost()
{
    $postData = [
        'id' => '',
        'created_at' => date('Y/m/d H:i:s', time()),
        'title' => '',
        'content' => '',
        'quote_author' => '',
        'image' => '',
        'video' => '',
        'link' => '',
        'views' => '',
        'author_id' => 1,
        'content_type_id' => ''
    ];

    if (count($_POST) > 0) {
        foreach ($_POST as $key => $value) {
            if (array_key_exists($key, $postData)) {
                $postData[$key] = $value;
            }
        }
    }
    return $postData;
}


print_r(createQueryToAddPost());

echo include_template(
    'adding-post.php', [
        'contentTypes' => getContentTypes($connection)
]);
