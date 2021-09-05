<?php
require_once('./db-data.php');

$connection = getConnection();
$getId = isset($_GET['id']) ? intval($_GET['id']) : null;

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
        JOIN USERS ON comments.user_id = users.id
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

