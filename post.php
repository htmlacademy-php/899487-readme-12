<?php
require_once('./helpers.php');
require_once('./db-data.php');

$connection = getConnection();
$getId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$template = '';
$post = !$getId ? false : getPost($connection, $getId);

if (!$post) {
    $template = getErrorTemplate();
} else {
    $template = include_template('post-details.php', [
        'post' => $post,
        'postTemplate' => getPostTemplate(getPost($connection, $getId)),
        'postComments' => getPostComments($connection, $getId),
        'postAuthor' => getPostAuthor($connection, $getId),
        'userRegistrationDate' => getUserRegistrationDate(getPostAuthor($connection, $getId)),
        'authorSubscribers' => getAuthorSubscribers($connection, (getPostAuthor($connection, $getId))),
        'totalPosts' => getTotalPosts($connection, getPostAuthorId(getPostAuthor($connection, $getId)))
    ]);
}

echo include_template(
    'layout.php', [
    'title' => getTitle(),
    'user_name' => getUsername(),
    'is_auth' => isAuth(),
    'content' => $template
]);
