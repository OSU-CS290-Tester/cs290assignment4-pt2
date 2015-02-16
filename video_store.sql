-- Ian Taylor
-- CS 290 Web Dev
-- Assignment #4 Pt 2


-- SQL used to create the database:

CREATE TABLE video_store(
    id INT AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(255),
    length INT UNSIGNED,
    rented BOOLEAN NOT NULL DEFAULT TRUE,
    PRIMARY KEY(id),
    UNIQUE(name)
);