CREATE DATABASE IF NOT EXISTS readme;

USE readme;

CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  registration_date DATETIME,
  email VARCHAR(2048),
  login VARCHAR(2048),
  password BINARY(32),
  avatar VARCHAR(2048),
  CONSTRAINT nn_user NOT NULL (registration_date, email, login, password)
);

CREATE TABLE posts (
  id INT PRIMARY KEY AUTO_INCREMENT,
	date DATETIME,
	title VARCHAR(2048),
	content TEXT,
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
  FOREIGN KEY (hashtag) REFERENCES hashtags(hashtag),
  CONSTRAINT nn_post NOT NULL (date, title, content)
);

CREATE TABLE comemnts (
  id INT PRIMARY KEY AUTO_INCREMENT,
  date DATETIME,
  content TEXT,
  user_id INT,
  post_id INT,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (post_id) REFERENCES posts(id),
  CONSTRAINT nn_comment NOT NULL (date, content)
);

CREATE TABLE likes (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT,
  post_id INT,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (post_id) REFERENCES posts(id)
);

CREATE TABLE subscribers (
  id INT PRIMARY KEY AUTO_INCREMENT,
  author_id INT,
  subscriber_id INT,
  FOREIGN KEY (author_id) REFERENCES users(id),
  FOREIGN KEY (subscriber_id) REFERENCES user(id),
  CONSTRAINT nn_subscriber NOT NULL (author_id, subscriber_id)
);

CREATE TABLE messages (
  id INT PRIMARY KEY AUTO_INCREMENT,
  date DATETIME,
  content TEXT,
  author_id INT,
  recipient_id INT,
  FOREIGN KEY (author_id) REFERENCES users(id),
  FOREIGN KEY (recipient_id) REFERENCES users(id),
  CONSTRAINT nn_message NOT NULL (date, content)
);

CREATE TABLE hashtags (
  id INT PRIMARY KEY AUTO_INCREMENT,
  hashtag VARCHAR(2048) NOT NULL
);

CREATE TABLE content_types (
  id INT PRIMARY KEY AUTO_INCREMENT,
	content_type VARCHAR(2048),
	icon_classname VARCHAR(2048),
  CONSTRAINT nn_content_type NOT NULL (name, icon_classname)
);

CREATE TABLE roles (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(2048) NOT NULL
);
