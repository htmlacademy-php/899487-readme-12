<?php
require_once('./db-data.php');

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

$postAuthorId = isset($postAuthor[0]['id']) ? $postAuthor[0]['id']  : null;
$userRegistrationDate = isset($postAuthor[0]['registration_date']) ? $postAuthor[0]['registration_date'] : null ;

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
        'post' => getPosts($connection, "posts.id = '{$getId}'"),
        'postTemplate' => getPostTemplate(getPosts($connection, "posts.id = '{$getId}'")),
        'postLikes' => $postLikes,
        'postComments' => $postComments,
        'postAuthor' => $postAuthor,
        'userRegistrationDate' => $userRegistrationDate,
        'authorSubscribers' => $authorSubscribers,
        'totalPosts' => $totalPosts
    ]);
