<?php
  require('./helpers.php');

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
      if ($messageQuantity <= $maxDisplayedMessageLength)
      {
        array_push($trimmedWordsArr, $word);
      } else {
        break;
      }
    }

    $trimmedMessage = implode(' ', $trimmedWordsArr);

    return $messageQuantity > $maxDisplayedMessageLength ? "<p>{$trimmedMessage}...</p>{$readMoreButton}" : "<p>{$trimmedMessage}</p>";
  }

include_template('main.php', $array);

print_r('12345');