<?php
require_once('./helpers.php');
require_once('./db-data.php');

$title = 'readme: популярное';
$is_auth = rand(0, 1);
$user_name = 'Sergei';

$getId = isset($_GET['id']) ? intval($_GET['id']) : null;

$condition = $getId ? "content_types.id = '{$getId}'" : null;

echo include_template(
    'layout.php', [
        'title' => $title,
        'user_name' => $user_name,
        'is_auth' => $is_auth,
        'content' => include_template('main.php', [
            'contentTypes' => getContentTypes(),
            'posts' => getPosts($condition)])
    ]);
