<?php
//require_once('./helpers.php');
//require_once('./db-data.php');
//
//$connection = getConnection();
//
//print_r($_POST);
//
//$postData = [
//    'id' => '',
//    'created_at' => '',
//    'title' => '',
//    'content' => '',
//    'quote_author' => '',
//    'image' => '',
//    'video' => '',
//    'link' => '',
//    'views' => '',
//    'author_id' => '',
//    'content_type_id' => ''
//];
//
//function createQueryToAddPost($postData)
//{
//    if (count($_POST) > 0) {
//        foreach ($_POST as $key => $value) {
//            if ($postData[$key]) {
//                $postData[$key] = $value;
//            }
//        }
//    }
//
//}
//
//
//
//echo include_template(
//    'adding-post.php', [
//        'contentTypes' => getContentTypes($connection),
//]);
