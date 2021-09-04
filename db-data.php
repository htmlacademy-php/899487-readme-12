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

$getId = isset($_GET['id']) ? intval($_GET['id']) : null;

function getPosts($connection, $condition)
{
    $queryFragment = $condition ? "WHERE {$condition}" : "";

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
        {$queryFragment}
        GROUP BY posts.id
        ORDER BY likes_amount DESC
        LIMIT 6
    ");
}

$contentTypes = getDataFromDatabase($connection, "SELECT * FROM content_types");
