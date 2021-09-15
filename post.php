<?php
require_once('./helpers.php');
require_once('./db-data.php');

$connection = getConnection();
$getId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

echo include_template(
    'layout.php', [
    'title' => $title,
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'content' => include_template('post-details.php', [
            'post' => getPost($connection, $getId),
            'postTemplate' => getPostTemplate(getPost($connection, $getId)),
            'postComments' => getPostComments($connection, $getId),
            'postAuthor' => getPostAuthor($connection, $getId),
            'userRegistrationDate' => getUserRegistrationDate(getPostAuthor($connection, $getId)),
            'authorSubscribers' => getAuthorSubscribers($connection, (getPostAuthor($connection, $getId))),
            'totalPosts' => getTotalPosts($connection, getPostAuthorId(getPostAuthor($connection, $getId)))
        ]
    )
]);
