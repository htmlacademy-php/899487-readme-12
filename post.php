<?php
require_once('./helpers.php');
require_once('./db-data.php');

$getId = $_GET['id'];

$postLikes = getDataFromDatabase($connection, "
    SELECT likes.id
    FROM likes
    WHERE post_id = '{$getId}'
");

$postComments = getDataFromDatabase($connection, "
    SELECT *
    FROM comments
    JOIN USERS ON comments.user_id = users.id
    WHERE post_id = '{$getId}'
");

$postAuthor = getDataFromDatabase($connection, "
    SELECT login
    FROM users
    JOIN posts ON users.id = posts.author_id
    WHERE posts.id = '{$getId}'
");

echo include_template('post-details.php', ['post' => makeRequestToDb($connection, "posts.id = '{$getId}'"), 'postLikes' => $postLikes, 'postComments' => $postComments, 'postAuthor' => $postAuthor]);
