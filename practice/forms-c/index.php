<?php

session_start();

if (isset($_SESSION['results'])) {
    $results = $_SESSION['results'];

    $answer = $results['answer'];
    $correct = $results['correct'];

    $_SESSION['results'] = null;
}



require 'index-view.php';