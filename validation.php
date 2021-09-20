<?php

const TAGS_MAX = 5;
const TAGS_MAX_LENGTH = 20;

function getTags()
{
    if ($_POST['tags'] !== '') {
        return array_filter(explode(' ', $_POST['tags']), function($tag) {
            return $tag !== '';
        }, ARRAY_FILTER_USE_KEY);
    }
    echo 'Укажите хэш-теги.';
    return false;
}

function checkTagsValidity($tags)
{
    foreach ($tags as $tag) {
        if (substr($tag , 0 , 1) !== '#') {
            echo 'Хэш-тег должен начинаться с "#".';
            return false;
        }

        if ($tag === '#') {
            echo 'Хэш-тег не может состоять только из одной решётки.';
            return false;
        }

        preg_match_all('/#/' , $tag , $matches);

        if (substr($tag , 0 , 1) === '#' && count($matches[0]) > 1) {
            echo 'Хэш-теги разделяются пробелами.';
            return false;
        }

//        $repeats = array_filter($tags , function ($checkedTag) {
//                return strtolower($tag) === strtolower($checkedTag);
//            } , ARRAY_FILTER_USE_KEY);
//        }
//
//        if (count($repeats) > 1) {
//            echo 'Один и тот же хэш-тег не может быть использован дважды';
//            return false;
//        }

        if (count($tags) > TAGS_MAX) {
            echo 'Нельзя указать больше пяти хэш-тегов.';
            return false;
        }

        if (strlen($tag) > TAGS_MAX_LENGTH) {
            echo 'Максимальная длина одного хэш-тега 20 символов.';
            return false;
        }
    }
    return $tags;
}

function getValidTags()
{
    return getTags() ? checkTagsValidity(getTags()) : false;
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

    if ($_POST['content_type_id'] == 1 && filter_var($_POST['link'],FILTER_VALIDATE_URL) && $_POST['link'] !== '' && $_FILES['image']['name'] === '') {
        echo 'Картинка добавлена.';
        return true;
    }
}





