<?php

require_once('./validation.php');

function getConnection()
{
    $connection = mysqli_connect('127.0.0.1', 'mysql', 'mysql', 'readme');
    if (!$connection) {
        echo ('Ошибка соединения. Код ошибки - ' . mysqli_connect_errno() . ': ' . mysqli_connect_error());
        exit();
    }
    if (!mysqli_set_charset($connection, "utf8")) {
        echo ("Ошибка при загрузке набора символов utf8. Код ошибки - " . mysqli_connect_errno() . ": " . mysqli_error($connection));
        exit();
    }
    return $connection;
}

function getDataFromDatabase($connection, $query)
{
    $rows = mysqli_query($connection, $query);
    if (!$rows) {
        echo ("Ошибка запроса к базе данных. Код ошибки - " . mysqli_errno($connection) . ": " . mysqli_error($connection));
        exit();
    }
    return mysqli_fetch_all($rows, MYSQLI_ASSOC);
}

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

function getPost($connection, $getId)
{
    return getPosts($connection, "posts.id = '{$getId}'");
}

function getPostLikes($connection, $getId)
{
    return getDataFromDatabase($connection, "
        SELECT likes.id
        FROM likes
        WHERE post_id = '{$getId}'
    ");
}

function getPostComments($connection, $getId)
{
    return getDataFromDatabase($connection, "
        SELECT *
        FROM comments
        JOIN users ON comments.user_id = users.id
        WHERE post_id = '{$getId}'
    ");
}

function getPostAuthor($connection, $getId)
{
    return getDataFromDatabase($connection, "
        SELECT users.id, registration_date, login
        FROM users
        JOIN posts ON users.id = posts.author_id
        WHERE posts.id = '{$getId}'
    ");
}

function getPostAuthorId($postAuthor)
{
    return isset($postAuthor[0]['id']) ? $postAuthor[0]['id']  : null;
}

function getUserRegistrationDate($postAuthor)
{
    return isset($postAuthor[0]['registration_date']) ? $postAuthor[0]['registration_date'] : null ;
}

function getAuthorSubscribers($connection, $postAuthorId)
{
    return getDataFromDatabase($connection, "
        SELECT author_id, subscriber_id
        FROM subscribers
        JOIN users ON users.id = subscriber_id
        WHERE author_id = '{$postAuthorId}'
    ");
}

function getTotalPosts($connection, $postAuthorId)
{
    return getDataFromDatabase($connection, "
        SELECT id, author_id
        FROM posts
        WHERE author_id = '{$postAuthorId}'
    ");
}

function getPostTemplate($post)
{
    $post = $post[0];
    if ($post['icon_class'] === 'text') {
        return include_template('post-text.php', ['text' => $post['content']]);
    } elseif ($post['icon_class'] === 'quote') {
        return include_template('post-quote.php', ['text' => $post['content'], 'author' => $post['quote_author']]);
    } elseif ($post['icon_class'] === 'photo') {
        return include_template('post-photo.php', ['img_url' => '../img/' . $post['image']]);
    } elseif ($post['icon_class'] === 'video') {
        return include_template('post-video.php', ['video' => $post['video']]);
    } elseif ($post['icon_class'] === 'link') {
        return include_template('post-link.php', ['url' => $post['link'], 'title' => $post['title']]);
    } else {
        return null;
    }
}

function getContentTypes($connection, $condition)
{
    return getDataFromDatabase($connection,"
        SELECT * FROM content_types
        {$condition}
    ");
}

function getNewPostData()
{
    $postData = [
        'created_at' => date('Y-m-d H:i:s', time()),
        'title' => '',
        'content' => '',
        'quote_author' => '',
        'image' => '',
        'video' => '',
        'link' => '',
        'views' => '',
        'author_id' => 1,
        'content_type_id' => ''
    ];

    if (count($_POST) > 0) {
        foreach ($_POST as $key => $value) {
            if (array_key_exists($key, $postData)) {
                $postData[$key] = $value;
            }
        }
    }
    return $postData;
}

function insertDataIntoDb($connection, $query, $dataType)
{
    if (mysqli_query($connection, $query)) {
        echo "{$dataType} - успешно добавлено.";
    } else {
        echo "Ошибка добавления данных в базу данных. Код ошибки - " . mysqli_connect_errno() . ": " . mysqli_error($connection);
    }
}

function prepareNewPostData($connection)
{
    $data = getNewPostData();
    $views = intval($data['views']);
    $contentTypeId = intval($data['content_type_id']);

    $query = "
        INSERT INTO posts SET
            created_at = '". mysqli_real_escape_string($connection, "{$data['created_at']}") ."',
            title = '". mysqli_real_escape_string($connection, "{$data['title']}") ."',
            content = '". mysqli_real_escape_string($connection, "{$data['content']}") ."',
            quote_author = '". mysqli_real_escape_string($connection, "{$data['quote_author']}") ."',
            image = '". mysqli_real_escape_string($connection, "{$data['image']}") ."',
            video = '". mysqli_real_escape_string($connection, "{$data['video']}") ."',
            link = '". mysqli_real_escape_string($connection, "{$data['link']}") ."',
            views = '". $views ."',
            author_id = '". 1 ."',
            content_type_id = '". "{$contentTypeId}" ."'
    ";

    insertDataIntoDb($connection, $query, 'Пост');
}

function insertTagsIntoDb($connection)
{
    $tags = getValidTags();
    if ($tags) {
        foreach ($tags as $tag) {
            $query = "INSERT INTO hashtags (name) VALUES ('{$tag}')";
            insertDataIntoDb($connection, $query, 'Хэш-тэг');
        }
    }
}
