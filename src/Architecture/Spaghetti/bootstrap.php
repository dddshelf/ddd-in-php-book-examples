<?php

/**
 * The only purpose of this file is to make the spaghetti example work
 */

error_reporting(E_ALL);

function init_database() {
    $link = mysqli_connect('127.0.0.1', 'user', 'pass');
    mysqli_select_db($link, 'db');
    mysqli_query($link, <<<SQL
CREATE TABLE posts (
    id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    title TEXT NOT NULL,
    content TEXT NOT NULL,
    PRIMARY KEY (id)
);
SQL);
    mysqli_query($link, "INSERT INTO posts (title, content) VALUES ('A title', 'Some content')");
    mysqli_close($link);
}

function clear_database() {
    $link = mysqli_connect('127.0.0.1', 'user', 'pass');
    mysqli_select_db($link, 'db');
    mysqli_query($link, 'DROP TABLE posts');
    mysqli_close($link);
}

function is_valid(array $post): bool {
    return true;
}

function extract_post(array $post): array {
    return ['title' => $post['title'], 'content' => $post['content']];
}

function edit_post_url($post_id): string {
    return '/irrelevant';
}
