<?php

const TAGS_MAX = 5;
const TAGS_MAX_LENGTH = 20;

$tags = getTags();

$errors = [];

function getTags()
{
    if ($_POST['tags'] !== '') {
        return array_filter(explode(' ', $_POST['tags']), function($tag) {
            return $tag !== '';
        }, ARRAY_FILTER_USE_KEY);
    }
    return false;
}

function getTagsError($tags)
{
    if (!$tags) {
        return 'Укажите хэш-теги.';
    } else {
        foreach ($tags as $tag) {
            $repeats = array_filter($tags , function ($checkedTag) use ($tag) {
                return $tag !== '' ? strtolower($tag) === strtolower($checkedTag) : '';
            });

            if (count($repeats) > 1) {
                return 'Один и тот же хэш-тег не может быть использован дважды';
            }

            if (count($tags) > TAGS_MAX) {
                return 'Нельзя указать больше пяти хэш-тегов.';
            }

            if (strlen($tag) > TAGS_MAX_LENGTH) {
                return 'Максимальная длина одного хэш-тега 20 символов.';
            }
        }
    }
    return false;
}

function isInvalidStringLength($input, $dataType) {
    if (strlen(trim($input)) === 0) {
        switch($dataType) {
            case 'title':
                return 'Введите заголовок.';
                break;
            case 'link':
                return 'Введите ссылку.';
                break;
            case 'content':
                return 'Введите текст публикации.';
                break;
            case 'quote':
                return 'Введите текст цитаты.';
                break;
            case 'quote_author':
                return 'Введите имя автора.';
                break;
        }
    }
    
}


function checkImageValidity()
{
    if ($_POST['content_type_id'] == 1 && $_POST['link'] === '' && $_FILES['image']['name'] === '') {
        echo 'Добавьте картинку.';
        return false;
    }

    if ($_POST['content_type_id'] == 1 && !filter_var($_POST['link'], FILTER_VALIDATE_URL) && $_FILES['image']['name'] === '') {
        echo 'Некорректная ссылка на картинку.';
        return false;
    }

    if ($_FILES['image']['name'] !== '' && $_FILES['image']['type'] !== 'image/png' || $_FILES['image']['type'] !== 'image/jpeg' || $_FILES['image']['type'] !== 'image/gif') {
        echo 'Неподдерживаемый тип файла.';
        return false;
    }

    if ($_POST['content_type_id'] == 1 && $_POST['link'] === '' && $_FILES['image']['name'] !== '' || $_POST['link'] !== '' && $_FILES['image']['name'] !== '') {
        $name = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "./uploads/{$name}");
        $_POST['link'] = "./uploads/{$name}";
        echo 'Картинка добавлена.';
        return true;
    }

    if ($_POST['content_type_id'] == 1 && filter_var($_POST['link'], FILTER_VALIDATE_URL) && $_POST['link'] !== '' && $_FILES['image']['name'] === '') {
        echo 'Картинка добавлена.';
        return true;
    }
}





