<?php

$con = mysqli_connect('127.0.0.1', 'mysql', 'mysql', 'readme');

if (!$con) {
    printf('Ошибка соединения: ' . mysqli_connect_error() . '<br>');
    printf('Код ошибки: ' . mysqli_connect_errno());
    exit();
}

if (!mysqli_set_charset($con, "utf8")) {
    printf("Ошибка при загрузке набора символов utf8: %s\n", mysqli_error($con));
    exit();
}

function getDataFromDatabase($con, $query)
{
    $rows = mysqli_query($con, $query);
    if (!$rows) {
        printf("Код ошибки: %d\n", mysqli_errno($con));
        exit();
    }
    return mysqli_fetch_all($rows, MYSQLI_ASSOC);
}
