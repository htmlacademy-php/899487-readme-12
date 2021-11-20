<?php
require_once('./helpers.php');
require_once('./db-data.php');
require_once('./validation.php');

$connection = getConnection();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//    prepareNewPostData($connection);

    $tagsError = getTagsError($tags);
    $titleError = isInvalidStringLength($_POST['title'], 'title');
    $linkError = isInvalidStringLength($_POST['link'], 'link');
    $contentError = isInvalidStringLength($_POST['content'], 'content');
    $quoteError = isInvalidStringLength($_POST['quote'], 'quote');
    $quoteAuthorError = isInvalidStringLength($_POST['quote_author'], 'quote_author');

    if ($tagsError) {
        array_push($errors, $tagsError);
    }

    if ($titleError) {
        array_push($errors, $titleError);
    }

    if ($linkError) {
        array_push($errors, $linkError);
    }

    if ($contentError) {
        array_push($errors, $contentError);
    }

    if ($quoteError) {
        array_push($errors, $quoteError);
    }

    if ($quoteAuthorError) {
        array_push($errors, $quoteAuthorError);
    }


    // insertTagsIntoDb($connection, $tags);
    // header("Location: /index.php?success=true");
}

// print_r(getTagsError($tags));
print_r($_FILES);

print_r($_POST);

print_r($errors);



echo include_template(
    'layout.php', [
        'title' => getTitle(),
        'user_name' => getUsername(),
        'is_auth' => isAuth(),
        'content' => include_template('adding-post.php',
            [
                'formTitle' => include_template('form-title.php',
                    ['titleError' => $titleError]),
                'formLink' => include_template('form-link.php',
                    ['linkError' => $linkError]),
                'formTags' => include_template('form-tags.php',
                    ['tagsError' => getTagsError($tags)]),
                'contentError' => $contentError,
                'quoteError' => $quoteError,
                'quoteAuthorError' => $quoteAuthorError,
                'formError' => include_template('form-error.php',
                    ['errors' => $errors]),
                'submitButton' => include_template('submit-button.php'),
                'contentTypes' => getContentTypes($connection, '')
            ]
        )
    ]
);
