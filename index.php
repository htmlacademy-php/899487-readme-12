<?php
require_once('./helpers.php');
require_once('./db-data.php');

$connection = getConnection();

$getId = isset($_GET['id']) ? intval($_GET['id']) : null;

$condition = $getId ? "content_types.id = '{$getId}'" : null;

echo include_template(
    'layout.php', [
        'title' => $title,
        'user_name' => $user_name,
        'is_auth' => $is_auth,
        'content' => include_template('main.php', [
            'contentTypes' => getContentTypes($connection),
            'posts' => getPosts($connection, $condition)])
    ]);
