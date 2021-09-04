<?php
require_once('./db-data.php');

$getId = isset($_GET['id']) ? intval($_GET['id']) : null;

function getPost($getId)
{
    return getPosts("posts.id = '{$getId}'");
}

function getPostLikes($getId)
{
    return getDataFromDatabase("
        SELECT likes.id
        FROM likes
        WHERE post_id = '{$getId}'
    ");
}

function getPostComments($getId)
{ 
    return getDataFromDatabase("
        SELECT *
        FROM comments
        JOIN USERS ON comments.user_id = users.id
        WHERE post_id = '{$getId}'
    ");
}

function getPostAuthor($getId)
{ 
    return getDataFromDatabase("
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

function getAuthorSubscribers($postAuthorId) 
{
    return getDataFromDatabase("
        SELECT author_id, subscriber_id
        FROM subscribers
        JOIN users ON users.id = subscriber_id
        WHERE author_id = '{$postAuthorId}'
    ");
}

function getTotalPosts($postAuthorId)
{
    return getDataFromDatabase("
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
    }
}

echo include_template(
    'post-details.php', [
        'post' => getPost($getId),
        'postTemplate' => getPostTemplate(getPost($getId)),
        'postLikes' => getPostLikes($getId),
        'postComments' => getPostComments($getId),
        'postAuthor' => getPostAuthor($getId),
        'userRegistrationDate' => getUserRegistrationDate(getPostAuthor($getId)),
        'authorSubscribers' => getAuthorSubscribers(getPostAuthorId(getPostAuthor($getId))),
        'totalPosts' => getTotalPosts(getPostAuthorId(getPostAuthor($getId)))
    ]
);

