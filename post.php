<?php
require_once('./helpers.php');
require_once('./db-data.php');

$connection = getConnection();
$getId = isset($_GET['id']) ? intval($_GET['id']) : null;

echo include_template(
    'post-details.php', [
        'post' => getPost($connection, $getId),
        'postTemplate' => getPostTemplate(getPost($connection, $getId)),
        'postComments' => getPostComments($connection, $getId),
        'postAuthor' => getPostAuthor($connection, $getId),
        'userRegistrationDate' => getUserRegistrationDate(getPostAuthor($connection, $getId)),
        'authorSubscribers' => getAuthorSubscribers($connection, (getPostAuthor($connection, $getId))),
        'totalPosts' => getTotalPosts($connection, getPostAuthorId(getPostAuthor($connection, $getId)))
    ]
);
