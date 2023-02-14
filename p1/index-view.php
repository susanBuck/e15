<!doctype html>
<html lang='en'>

<head>
    <title>Project 1 - String Processor</title>
    <meta charset='utf-8'>
    <link href=data: , rel=icon>
</head>

<body>
    <h1>Project 1 - String Processor</h1>

    <form method='POST' action='process.php'>
        <label for='inputString'>Enter a word to process:</label>
        <input type='text' id='inputString' name='inputString' value='<?php echo $inputString ?? ""; ?>'>
        <button type='submit'>Process word</button>
    </form>

    <?php if (isset($inputString)) { ?>
    <h2>Results for the word “<?php echo $inputString; ?>”
    </h2>
    <ul>
        <li>
            This is a <?php $isBigWord ? "" : 'not' ?> a “big” word (> 10 characters)
        </li>

        <li>
            This is a <?php $isPalindrome ? "" : 'not' ?> a palindrome (same forwards and backwards)
        </li>

        <li>
            There are <?php echo $vowelCount ?> vowels in this word
        </li>
    </ul>
    <?php } ?>
</body>

</html>