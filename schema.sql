CREATE DATABASE readme;

USE readme;

CREATE TABLE users (
  user_id INT PRIMARY KEY,
  registration_date DATETIME,
  email CHAR(255),
  login CHAR(255),
  password BINARY(32),
  avatar CHAR(255)
);

CREATE TABLE posts (
  post_id INT,
	date DATETIME,
	title CHAR(255),
	content TEXT,
	quote_author CHAR(255),
	image CHAR(255),
	video CHAR(255),
	link CHAR(255),
	views INT,
  FOREIGN KEY (post_id) REFERENCES users(user_id),
  FOREIGN KEY (post_id) REFERENCES contents_types(name),
  FOREIGN KEY (post_id) REFERENCES hashtags(hashtag)
);

CREATE TABLE comemnts (
  comment_id INT,
  date DATETIME,
  content TEXT,
  FOREIGN KEY (comment_id) REFERENCES users(user_id),
  FOREIGN KEY (comment_id) REFERENCES posts(post_id)
);

CREATE TABLE likes (
  like_id INT,
  FOREIGN KEY (like_id) REFERENCES users(user_id),
  FOREIGN KEY (like_id) REFERENCES posts(post_id)
);

CREATE TABLE subscribes (
  subscribe_id INT,
  FOREIGN KEY (subscribe_id) REFERENCES users(user_id)
);

CREATE TABLE messages (
  message_id INT,
  date DATETIME,
  content TEXT,
  FOREIGN KEY (message_id) REFERENCES users(user_id)
);

CREATE TABLE hashtags (
  hashtag CHAR(255)
);

CREATE TABLE content_types (
	name CHAR(255),
	icon__classname CHAR(255)
);

CREATE TABLE roles (
  id INT,
  name CHAR(255),
  FOREIGN KEY (id) REFERENCES users(user_id)
);