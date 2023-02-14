<?php

session_start();

# If we’re coming back from the form being submitted
# We have results from the session to extract
if (isset($_SESSION['results'])) {
    $results = $_SESSION['results'];
    $inputString = $results['inputString'];
    $isBigWord = $results['isBigWord'];
    $isPalindrome = $results['isPalindrome'];
    $vowelCount = $results['vowelCount'];

    # Reset the results so we don’t see them when the page is refreshed
    $_SESSION['results'] = null;
}

# Load the view
require 'index-view.php';