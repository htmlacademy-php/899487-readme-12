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
        'title' => getTitle(),
        'user_name' => getUsername(),
        'is_auth' => isAuth(),
        'content' => include_template('adding-post.php', [
            'formTitle' => include_template('form-title.php'),
            'formTags' => include_template('form-tags.php'),
            'contentTypes' => getContentTypes($connection)
            ]
        )
    ]
);



