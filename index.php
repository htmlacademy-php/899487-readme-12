<?php
require_once('./helpers.php');
require_once('./db-data.php');

$connection = getConnection();

$getId = isset($_GET['id']) ? intval($_GET['id']) : null;

$condition = $getId ? "content_types.id = '{$getId}'" : null;

echo include_template(
    'layout.php', [
    'title' => getTitle(),
    'user_name' => getUsername(),
    'is_auth' => isAuth(),
        'content' => include_template('main.php', [
            'contentTypes' => getContentTypes($connection),
            'posts' => getPosts($connection, $condition)
        ])
    ]
);
