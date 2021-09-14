<?php
require_once('./helpers.php');
require_once('./db-data.php');

$connection = getConnection();


print_r(getNewPostData());

insertDataIntoDb($connection);

echo include_template(
    'adding-post.php', [
        'formTitle' => include_template('form-title.php'),
        'formTags' => include_template('form-tags.php'),
        'contentTypes' => getContentTypes($connection)
]);
