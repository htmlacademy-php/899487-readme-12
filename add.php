<?php
require_once('./helpers.php');
require_once('./db-data.php');
require_once('./validation.php');

$connection = getConnection();

print_r($_POST);
print_r($_FILES['image']);

checkImageValidity();

echo include_template(
    'layout.php', [
        'title' => $title,
        'user_name' => $user_name,
        'is_auth' => $is_auth,
        'content' => include_template('adding-post.php', [
            'formTitle' => include_template('form-title.php'),
            'formTags' => include_template('form-tags.php'),
            'contentTypes' => getContentTypes($connection)
            ]
        )
    ]
);



