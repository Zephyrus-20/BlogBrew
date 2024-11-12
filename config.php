<?php
$con = mysqli_connect("localhost", "root", "") or die("Could not establish connection: " . mysqli_error($con));

$create_db = "CREATE DATABASE IF NOT EXISTS social_media_app";
mysqli_query($con, $create_db) or die("Could not create database: " . mysqli_error($con));

mysqli_select_db($con, "social_media_app") or die("Could not select database: " . mysqli_error($con));

$create_table_user = "CREATE TABLE IF NOT EXISTS user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30),
    email VARCHAR(30),
    phone VARCHAR(12),
    password VARCHAR(30),
    profile_pic VARCHAR(255),
    bio TEXT,
    created_at DATETIME
)";
mysqli_query($con, $create_table_user) or die("Could not create table user: " . mysqli_error($con));

$create_table_posts = "CREATE TABLE IF NOT EXISTS posts (
    post_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    content TEXT,
    posted_at DATETIME,
    FOREIGN KEY (user_id) REFERENCES user(user_id)
)";
mysqli_query($con, $create_table_posts) or die("Could not create table posts: " . mysqli_error($con));

?>