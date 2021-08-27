<?php
require_once('./helpers.php');
require_once('./db-data.php');

$title = 'readme: популярное';

$is_auth = rand(0, 1);

$user_name = 'Sergei';


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


$contentTypes = getDataFromDatabase($connection, "SELECT * FROM content_types");

$getId = $_GET['id'];

$condition = $getId ? "content_types.id = '{$getId}'" : false;

echo include_template('layout.php', ['title' => $title, 'user_name' => $user_name, 'is_auth' => $is_auth, 'content' => include_template('main.php', ['contentTypes' => $contentTypes, 'posts' => makeRequestToDb($connection, $condition)])]);
