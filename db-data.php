<?php
require_once('./helpers.php');

$connection = mysqli_connect('127.0.0.1', 'mysql', 'mysql', 'readme');

if (!$connection) {
    printf('Ошибка соединения: ' . mysqli_connect_error() . '<br>');
    printf('Код ошибки: ' . mysqli_connect_errno());
    exit();
}

if (!mysqli_set_charset($connection, "utf8")) {
    printf("Ошибка при загрузке набора символов utf8: %s\n", mysqli_error($connection));
    exit();
}

function getDataFromDatabase($connection, $query)
{
    $rows = mysqli_query($connection, $query);
    if (!$rows) {
        printf("Код ошибки: %d\n", mysqli_errno($connection));
        exit();
    }
    return mysqli_fetch_all($rows, MYSQLI_ASSOC);
}

$getId = intval($_GET['id']);

function makeRequestToDb($connection, $condition)
{
    if ($condition) {
        return getDataFromDatabase($connection, "
            SELECT
                posts.*,
                users.login,
                users.avatar,
                content_types.name,
                content_types.icon_class,
                COUNT(likes.id) AS likes_amount,
                COUNT(comments.id) AS comments_amount
            FROM posts
            JOIN users ON posts.author_id = users.id
            JOIN content_types ON posts.content_type_id = content_types.id
            LEFT OUTER JOIN likes ON likes.post_id = posts.id
            JOIN comments ON posts.id = comments.post_id
            WHERE $condition
            GROUP BY posts.id
            ORDER BY likes_amount DESC
            LIMIT 6
        ");
    } else {
        return getDataFromDatabase($connection, "
            SELECT
                posts.*,
                users.login,
                users.avatar,
                content_types.name,
                content_types.icon_class,
                COUNT(likes.id) AS likes_amount,
                COUNT(comments.id) AS comments_amount
            FROM posts
            JOIN users ON posts.author_id = users.id
            JOIN content_types ON posts.content_type_id = content_types.id
            LEFT OUTER JOIN likes ON likes.post_id = posts.id
            JOIN comments ON posts.id = comments.post_id
            GROUP BY posts.id
            ORDER BY likes_amount DESC
            LIMIT 6
        ");
    }
}

//select comments.content, comments.post_id
//from comments
//join posts on comments.post_id = posts.id
//where posts.id = 1

$contentTypes = getDataFromDatabase($connection, "SELECT * FROM content_types");

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
    SELECT users.id, registration_date, login
    FROM users
    JOIN posts ON users.id = posts.author_id
    WHERE posts.id = '{$getId}'
");

$postAuthorId = $postAuthor[0]['id'];
$userRegistrationDate = $postAuthor[0]['registration_date'];

$authorSubscribers = getDataFromDatabase($connection, "
    SELECT author_id, subscriber_id
    FROM subscribers
    JOIN users ON users.id = subscriber_id
    WHERE author_id = '{$postAuthorId}'
");

$totalPosts = getDataFromDatabase($connection, "
    SELECT id, author_id
    FROM posts
    WHERE author_id = '{$postAuthorId}'
");
