<!doctype html>
<html lang='en'>

<head>
    <title>Mystery Word Scramble</title>
    <meta charset='utf-8'>
</head>

<body>

    <form method='POST' action='process.php'>
        <h1>Mystery Word Scramble</h1>

        <p>Mystery word: kiumppn</p>
        <p>Hint: Halloween’s favorite fruit</p>

        <label for='answer'>Your guess:</label>
        <input type='text' name='answer' id='answer' value='<?php echo $answer ?? "" ?>'>

        <button type='submit'>Check answer</button>
    </form>

    <?php if (isset($answer)) { ?>
    <h2>Results</h2>
    <p>
        You guessed: <?php echo $answer; ?>
    </p>

    <?php if ($correct) { ?>
    You got it correct!
    <?php } else { ?>
    Sorry, incorrect. <a href='index.php'>Please try again...</a>
    <?php } ?>
    <?php } ?>

</body>

</html>