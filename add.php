<?php
require_once('./helpers.php');
require_once('./db-data.php');
require_once('./validation.php');

$connection = getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//    prepareNewPostData($connection);

    if (!getTagsError($tags)) {
        insertTagsIntoDb($connection, $tags);
    } else {
        array_push($errors, getTagsError($tags));
    }

    if (getFormError($_POST['title'], 'title')) {
        array_push($errors, getFormError($_POST['title'], 'title'));
    }

    if (getFormError($_POST['link'], 'video')) {
        array_push($errors, getFormError($_POST['link'], 'link'));
    }

//    header("Location: /index.php?success=true");
}

print_r(getTagsError($tags));

echo include_template(
    'layout.php', [
        'title' => getTitle(),
        'user_name' => getUsername(),
        'is_auth' => isAuth(),
        'content' => include_template('adding-post.php',
            [
                'videoLinkError' => getFormError($_POST['link'], 'video'),
                'formTitle' => include_template('form-title.php',
                    ['titleError' => getFormError($_POST['title'], 'title')]),
                'inputError' => include_template('input-error.php'),
                'formError' => include_template('form-error.php',
                    ['errors' => $errors]),
                'submitButton' => include_template('submit-button.php'),
                'formTags' => include_template('form-tags.php',
                    ['tagsError' => getTagsError($tags)]),
                'contentTypes' => getContentTypes($connection, '')
            ]
        )
    ]
);
