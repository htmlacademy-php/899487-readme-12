<?php
require_once('./helpers.php');

$title = 'readme: популярное';

$is_auth = rand(0, 1);

$user_name = 'Sergei';

$array = [
    [
        'title' => 'Цитата',
        'type' => 'post-quote',
        'content' => 'Мы в жизни любим только раз, а после ищем лишь похожих',
        'username' => 'Лариса',
        'avatar' => 'userpic-larisa-small.jpg',
    ],
    [
        'title' => 'Игра престолов',
        'type' => 'post-text',
        'content' => 'Не могу дождаться начала финального сезона своего любимого сериала!',
        'username' => 'Владик',
        'avatar' => 'userpic.jpg',
    ],
    [
        'title' => 'Наконец, обработал фотки!',
        'type' => 'post-photo',
        'content' => 'rock-medium.jpg',
        'username' => 'Виктор',
        'avatar' => 'userpic-mark.jpg',
    ],
    [
        'title' => 'Моя мечта',
        'type' => 'post-photo',
        'content' => 'coast-medium.jpg',
        'username' => 'Лариса',
        'avatar' => 'userpic-larisa-small.jpg',
    ],
    [
        'title' => 'Лучшие курсы',
        'type' => 'post-link',
        'content' => 'www.htmlacademy.ru',
        'username' => 'Владик',
        'avatar' => 'userpic.jpg',
    ],
];


function trimMessage ($message, $maxDisplayedMessageLength = 300)
{
    $wordsArr = explode(' ', $message);
    $trimmedWordsArr = [];
    $messageQuantity = 0;
    $readMoreButton = '<a class="post-text__more-link" href="#">Читать далее</a>';

    foreach ($wordsArr as $word) {
        $messageQuantity += strlen($word);
            if ($messageQuantity <= $maxDisplayedMessageLength) {
                array_push($trimmedWordsArr, $word);
            } else {
                break;
            }
    }

$trimmedMessage = implode(' ', $trimmedWordsArr);

return $messageQuantity > $maxDisplayedMessageLength ? "<p>{$trimmedMessage}...</p>{$readMoreButton}" : "<p>{$trimmedMessage}</p>";
}


$con = mysqli_connect('127.0.0.1', 'mysql', 'mysql', 'readme');

$contentTypesQuery = "SELECT * FROM content_types";
$postsQuery = "SELECT posts.*, login, avatar, type_name FROM posts JOIN users ON posts.author_id = users.id JOIN content_types ON posts.content_type_id = content_types.id ORDER BY posts.views";

$contentTypesRows = mysqli_query($con, $contentTypesQuery);
$contentTypes = mysqli_fetch_all($contentTypesRows, MYSQLI_ASSOC);

$postsRows = mysqli_query($con, $postsQuery);
$posts = mysqli_fetch_all($postsRows, MYSQLI_ASSOC);


echo include_template('layout.php', ['title' => $title, 'user_name' => $user_name, 'is_auth' => $is_auth, 'content' => include_template('main.php', ['posts' => $posts, 'contentTypes' => $contentTypes])]);
