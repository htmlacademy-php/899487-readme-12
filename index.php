<?php
require_once('./helpers.php');
require_once('./db-data.php');

$connection = getConnection();
$getId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$template = '';

$condition = !$getId ? '' : "WHERE content_types.id = '{$getId}'";
$posts = getPosts($connection, $condition);

$contentTypes = getContentTypes($connection, '');

if (!isIdAvailable($getId, $contentTypes) || $getId === false) {
    $template = getErrorTemplate();
} else {
    if ($posts) {
        $template = include_template('main.php', [
            'contentTypes' => $contentTypes,
            'content' => include_template('posts.php', [
                'posts' => $posts
            ])
        ]);
    } else {
        $template = include_template('main.php', [
            'contentTypes' => $contentTypes,
            'content' => include_template('no-posts.php')
        ]);
    }
}

echo include_template(
    'layout.php', [
        'title' => getTitle(),
        'user_name' => getUsername(),
        'is_auth' => isAuth(),
        'content' => $template
    ]
);
