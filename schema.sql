CREATE DATABASE IF NOT EXISTS readme;

USE readme;

CREATE TABLE IF NOT EXISTS users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  registration_date DATETIME NOT NULL,
  email VARCHAR(2048) NOT NULL,
  login VARCHAR(2048) NOT NULL,
  password BINARY(32) NOT NULL,
  avatar VARCHAR(2048)
);

CREATE TABLE IF NOT EXISTS posts (
  id INT PRIMARY KEY AUTO_INCREMENT,
	date DATETIME NOT NULL,
	title VARCHAR(2048) NOT NULL,
	content TEXT NOT NULL,
	quote_author VARCHAR(2048),
	image VARCHAR(2048),
	video VARCHAR(2048),
	link VARCHAR(2048),
	views INT,
  author_id INT,
  content_type VARCHAR(2048),
  hashtag VARCHAR(2048),
  FOREIGN KEY (author_id) REFERENCES users(id),
  FOREIGN KEY (content_type) REFERENCES content_types(content_type),
  FOREIGN KEY (hashtag) REFERENCES hashtags(hashtag)
);

CREATE TABLE IF NOT EXISTS comemnts (
  id INT PRIMARY KEY AUTO_INCREMENT,
  date DATETIME NOT NULL,
  content TEXT NOT NULL,
  user_id INT,
  post_id INT,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (post_id) REFERENCES posts(id)
);

CREATE TABLE IF NOT EXISTS likes (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT,
  post_id INT,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (post_id) REFERENCES posts(id)
);

CREATE TABLE IF NOT EXISTS subscribers (
  id INT PRIMARY KEY AUTO_INCREMENT,
  author_id INT NOT NULL,
  subscriber_id INT NOT NULL,
  FOREIGN KEY (author_id) REFERENCES users(id),
  FOREIGN KEY (subscriber_id) REFERENCES user(id)
);

CREATE TABLE IF NOT EXISTS messages (
  id INT PRIMARY KEY AUTO_INCREMENT,
  date DATETIME NOT NULL,
  content TEXT NOT NULL,
  author_id INT,
  recipient_id INT,
  FOREIGN KEY (author_id) REFERENCES users(id),
  FOREIGN KEY (recipient_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS hashtags (
  id INT PRIMARY KEY AUTO_INCREMENT,
  hashtag VARCHAR(2048) NOT NULL
);

CREATE TABLE IF NOT EXISTS content_types (
  id INT PRIMARY KEY AUTO_INCREMENT,
	content_type VARCHAR(2048) NOT NULL,
	icon_classname VARCHAR(2048) NOT NULL
);

CREATE TABLE IF NOT EXISTS roles (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(2048) NOT NULL
);
