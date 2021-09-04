<?php
require_once('./db-data.php');

echo include_template(
    'adding-post.php', [
        'contentTypes' => $contentTypes,
]);
