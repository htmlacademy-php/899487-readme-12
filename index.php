<?php
require_once('./helpers.php');
require_once('./db-data.php');

$connection = getConnection();
$getId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$template = '';

$condition = !$getId ? false : "content_types.id = '{$getId}'";
$postsData = getPosts($connection, $condition);

$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

if ($postsData) {
    $template = include_template('main.php', [
        'contentTypes' => getContentTypes($connection, ''),
        'content' => include_template('posts.php', [
            'posts' => getPosts($connection, $condition)])
    ]);
} else {
    $template = include_template('main.php', [
        'contentTypes' => getContentTypes($connection, ''),
        'content' => include_template('no-posts.php')
    ]);
}

if (!$getId || !getContentTypes($connection, "WHERE content_types.id = '{$getId}'")) {
    $template = include_template('main.php', [
        'contentTypes' => getContentTypes($connection, ''),
        'content' => getErrorTemplate()
    ]);
}

if ($url === 'http://899487-readme-12/') {
    $template = include_template('main.php', [
        'contentTypes' => getContentTypes($connection, ''),
        'content' => include_template('posts.php', [
            'posts' => getPosts($connection, $condition)])
    ]);
}

echo include_template(
    'layout.php', [
        'title' => getTitle(),
        'user_name' => getUsername(),
        'is_auth' => isAuth(),
        'content' => $template
    ]
);
