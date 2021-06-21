CREATE DATABASE readme CHARACTER SET utf8 COLLATE utf8_general_ci;

USE readme;

CREATE TABLE IF NOT EXISTS users
(
    id                INT PRIMARY KEY AUTO_INCREMENT,
    registration_date DATETIME     NOT NULL,
    email             VARCHAR(255) NOT NULL,
    login             VARCHAR(255) NOT NULL,
    password          BINARY(32)   NOT NULL,
    avatar            VARCHAR(2048)
);

CREATE TABLE IF NOT EXISTS content_types
(
    id             INT PRIMARY KEY AUTO_INCREMENT,
    name   VARCHAR(64) NOT NULL,
    icon_class VARCHAR(64) NOT NULL
);

CREATE TABLE IF NOT EXISTS posts
(
    id              INT PRIMARY KEY AUTO_INCREMENT,
    created_at      DATETIME      NOT NULL,
    title           VARCHAR(2048) NOT NULL,
    content         TEXT          NOT NULL,
    quote_author    VARCHAR(255),
    image           VARCHAR(2048),
    video           VARCHAR(2048),
    link            VARCHAR(2048),
    views           INT,
    author_id       INT,
    content_type_id INT,
    FOREIGN KEY (author_id) REFERENCES users (id),
    FOREIGN KEY (content_type_id) REFERENCES content_types (id)
);

CREATE TABLE IF NOT EXISTS hashtags
(
    id   INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS posts_hashtags
(
    post_id    INT NOT NULL,
    hashtag_id INT NOT NULL,
    FOREIGN KEY (post_id) REFERENCES posts (id),
    FOREIGN KEY (hashtag_id) REFERENCES hashtags (id)
);

CREATE TABLE IF NOT EXISTS comments
(
    id         INT PRIMARY KEY AUTO_INCREMENT,
    created_at DATETIME NOT NULL,
    content    TEXT     NOT NULL,
    user_id    INT,
    post_id    INT,
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (post_id) REFERENCES posts (id)
);

CREATE TABLE IF NOT EXISTS likes
(
    id      INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    post_id INT,
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (post_id) REFERENCES posts (id)
);

CREATE TABLE IF NOT EXISTS subscribers
(
    id            INT PRIMARY KEY AUTO_INCREMENT,
    author_id     INT NOT NULL,
    subscriber_id INT NOT NULL,
    FOREIGN KEY (author_id) REFERENCES users (id),
    FOREIGN KEY (subscriber_id) REFERENCES users (id)
);

CREATE TABLE IF NOT EXISTS messages
(
    id           INT PRIMARY KEY AUTO_INCREMENT,
    created_at   DATETIME NOT NULL,
    content      TEXT     NOT NULL,
    author_id    INT,
    recipient_id INT,
    FOREIGN KEY (author_id) REFERENCES users (id),
    FOREIGN KEY (recipient_id) REFERENCES users (id)
);

CREATE TABLE IF NOT EXISTS roles
(
    id   INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
);
