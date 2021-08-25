<?php
require_once('./helpers.php');
require_once('./db-data.php');

$getId = $_GET['id'];

$post  = getDataFromDatabase($con, "
    SELECT
        posts.*,
        users.login, 
        users.avatar,
        content_types.name,
        content_types.icon_class,
        COUNT(likes.id) AS likes_amount
    FROM posts 
    JOIN users ON posts.author_id = users.id 
    JOIN content_types ON posts.content_type_id = content_types.id
    LEFT OUTER JOIN likes ON likes.post_id = posts.id 
    WHERE posts.id = '{$getId}'
    GROUP BY posts.id
    ORDER BY likes_amount DESC
    LIMIT 6 
");

$postLikes = getDataFromDatabase($con, "
    SELECT likes.id
    FROM likes
    WHERE post_id = '{$getId}'
");

$postComments = getDataFromDatabase($con, "
    SELECT *
    FROM comments
    JOIN USERS ON comments.user_id = users.id
    WHERE post_id = '{$getId}'
");

$postAuthor = getDataFromDatabase($con, "
    SELECT login
    FROM users
    JOIN posts ON users.id = posts.author_id
    WHERE posts.id = '{$getId}'
");

echo include_template('post-details.php', ['post' => $post, 'postLikes' => $postLikes, 'postComments' => $postComments, 'postAuthor' => $postAuthor]);
