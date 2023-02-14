<?php

$answer = $_POST['answer'];

$correct = $answer == 'pumpkin';

require 'process-view.php';