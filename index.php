<?php
require_once('./helpers.php');

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


$con = mysqli_connect('127.0.0.1', 'mysql', 'mysql', 'readme');

if (!$con) {
    printf('Ошибка соединения: ' . mysqli_connect_error() . '<br>');
    printf('Код ошибки: ' . mysqli_connect_errno());
    exit();
}

if (!mysqli_set_charset($con, "utf8")) {
    printf("Ошибка при загрузке набора символов utf8: %s\n", mysqli_error($con));
    exit();
}

function getDataFromDatabase($con, $query)
{
    $rows = mysqli_query($con, $query);
    if (!$rows) {
        printf("Код ошибки: %d\n", mysqli_errno($con));
        exit();
    }
    return mysqli_fetch_all($rows, MYSQLI_ASSOC);
}


$contentTypes = getDataFromDatabase($con, "SELECT * FROM content_types");
$getId = $_GET['id'];

$posts = getDataFromDatabase($con, "
    SELECT
        posts.*, 
        users.login, 
        users.avatar,
        content_types.name,
        content_types.icon_class,
        COUNT(likes.id) AS likes_amount
    FROM posts 
    JOIN users ON posts.author_id = users.id 
    JOIN content_types ON posts.content_type_id = content_types.id
    LEFT OUTER JOIN likes ON likes.post_id = posts.id 
    WHERE content_types.id = {$getId}
    GROUP BY posts.id
    ORDER BY likes_amount DESC  
    LIMIT 6 
");


echo include_template('layout.php', ['title' => $title, 'user_name' => $user_name, 'is_auth' => $is_auth, 'content' => include_template('main.php', ['contentTypes' => $contentTypes, 'posts' => $posts])]);
