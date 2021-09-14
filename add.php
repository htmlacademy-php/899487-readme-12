<?php
require_once('./helpers.php');
require_once('./db-data.php');

$connection = getConnection();




print_r(createQueryToAddPost());

echo include_template(
    'adding-post.php', [
        'contentTypes' => getContentTypes($connection)
]);
