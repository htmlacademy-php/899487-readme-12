<?php
require_once('./db-data.php');

echo include_template(
    'post-details.php', [
        'post' => makeRequestToDb($connection, "posts.id = '{$getId}'"),
        'postLikes' => $postLikes,
        'postComments' => $postComments,
        'postAuthor' => $postAuthor,
        'userRegistrationDate' => $userRegistrationDate,
        'authorSubscribers' => $authorSubscribers,
        'totalPosts' => $totalPosts
    ]);
