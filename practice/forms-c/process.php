<?php

session_start();

$answer = $_POST['answer'];

$correct = $answer == 'pumpkin';

$_SESSION['results'] = [
    'answer' => $answer,
    'correct' => $correct
];

# Redirect
header('Location: index.php');