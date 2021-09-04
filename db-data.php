<?php
require_once('./helpers.php');

function getConnection()
{
    $connetion = mysqli_connect('127.0.0.1', 'mysql', 'mysql', 'readme');
    if (!$connetion) {
        printf('Ошибка соединения: ' . mysqli_connect_error() . '<br>');
        printf('Код ошибки: ' . mysqli_connect_errno());
        exit();
    }
    return $connetion;
}

if (!mysqli_set_charset(getConnection(), "utf8")) {
    printf("Ошибка при загрузке набора символов utf8: %s\n", mysqli_error(getConnection()));
    exit();
}

function getDataFromDatabase($query)
{
    $rows = mysqli_query(getConnection(), $query);
    if (!$rows) {
        printf("Код ошибки: %d\n", mysqli_errno(getConnection()));
        exit();
    }
    return mysqli_fetch_all($rows, MYSQLI_ASSOC);
}

function getPosts($condition)
{
    $queryFragment = $condition ? "WHERE {$condition}" : "";

    return getDataFromDatabase("
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

function getContentTypes()
{
    return getDataFromDatabase("SELECT * FROM content_types");
}

