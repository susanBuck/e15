<?php

session_start();

$results = $_SESSION['results'];

$answer = $results['answer'];
$correct = $results['correct'];

require 'done-view.php';