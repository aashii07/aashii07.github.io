<!DOCTYPE html>
<html>
<head>
    <title>Execute Python from HTML</title>
</head>
<body>
    <?php
    // Python code to execute
    $pythonCode = "
print('Hello, Python!')
a = 10
b = 20
sum = a + b
print('The sum of', a, 'and', b, 'is', sum)
";

    // Save the Python code to a file
    $pythonFile = 'test.py';
    file_put_contents($pythonFile, $pythonCode);

    // Execute the Python code
    $output = shell_exec("python $pythonFile");

    // Display the output
    echo "<pre>$output</pre>";

    // Delete the temporary Python file
    unlink($pythonFile);
    ?>
</body>
</html>
