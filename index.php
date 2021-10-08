<?php
require_once('./helpers.php');
require_once('./db-data.php');

$connection = getConnection();
$getId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$postsTemplate = '';

$condition = !$getId ? '' : "WHERE content_types.id = '{$getId}'";
$posts = getPosts($connection, $condition);

$contentTypes = getContentTypes($connection, '');

if ($posts) {
    $postsTemplate = include_template('posts.php', [
        'posts' => $posts
    ]);
} else {
    $postsTemplate = include_template('no-posts.php');
}

$mainTemplate = include_template('main.php', [
        'contentTypes' => $contentTypes,
        'content' => $postsTemplate
    ]
);

if (!getContentTypes($connection, $condition) || $getId === false) {
    $mainTemplate = getErrorTemplate();
}

echo include_template(
    'layout.php', [
        'title' => getTitle(),
        'user_name' => getUsername(),
        'is_auth' => isAuth(),
        'content' => $mainTemplate
    ]
);
