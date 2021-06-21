/* Добавляем данные в таблицу content_types */
INSERT INTO content_types (id, name, icon_class) VALUES
(1, 'Текст', 'text'),
(2, 'Цитата', 'quote'),
(3, 'Картинка', 'photo'),
(4, 'Видео', 'video'),
(5, 'Ссылка', 'link');

/* Добавляем данные в таблицу users */
INSERT INTO users (id, registration_date, email, login, password, avatar) VALUES
(1, '2021-06-10', 'viktor@email.com', 'viktor', 'af3Pqfwl412', 'userpic-mark.jpg'),
(2, '2021-06-14', 'larisa@email.com', 'larisa', 'asf23Dfffa', 'userpic-larisa-small.jpg'),
(3, '2021-06-17', 'vladik@email.com', 'vladik', 'fkr#$lkfvd', 'userpic.jpg');

/* Добавляем данные в таблицу posts */
INSERT INTO posts (id, created_at, title, content, quote_author, image, video, link, views, author_id, content_type_id) VALUES
(1, '2021-06-16 12:00:05', 'Цитата', 'Мы в жизни любим только раз, а после ищем лишь похожих', '', '', '', '', 5, 1, 2),
(2, '2021-06-15 15:14:21', 'Наконец, обработал фотки!', '', '', 'rock-medium.jpg', '', '', 10, 1, 3),
(3, '2021-06-17 11:15:12', 'Лучшие курсы', '', '', '', '', 'www.htmlacademy.ru', 15, 3, 5);

/* Добавляем данные в таблицу comments */
INSERT INTO comments (id, created_at, content, user_id, post_id) VALUES
(1, '2021-06-17 12:15:00', 'Замечательные слова!', 2, 1),
(2, '2021-06-16 10:15:25', 'Очень красиво!', 2, 2),
(3, '2021-06-17 17:29:11', 'Согласен! Я тоже прохожу их :)', 1, 3),
(4, '2021-06-18 15:10:44', 'Отличные снимки!', 3, 2);

/* Объединяем таблицы posts, users, content_types и выбираем все поля из posts, login из users, name из content_types и сортируем полученные данные по views из posts */
SELECT posts.*, login, name FROM posts JOIN users ON posts.author_id = users.id JOIN content_types ON posts.content_type_id = content_types.id ORDER BY posts.views;

/* Объединям таблицы posts и users и выбираем все поля из posts, login из users, где login = vladik */
SELECT posts.* FROM posts JOIN users ON posts.author_id = users.id WHERE users.login = 'vladik';

/* Объединям таблицы comments и users и выбираем поля content из comments и login из users, где comment.id = 1 */
SELECT content, login FROM comments JOIN users ON comments.user_id = users.id WHERE comments.post_id = 2;

/* viktor ставит like посту vladik */
INSERT INTO likes (id, user_id, post_id) VALUES (1, 1, 3);

/* larisa подписывается на viktor */
INSERT INTO subscribers (id, author_id, subscriber_id) VALUES (1, 1, 2);
