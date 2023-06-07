<?php
// PHP code
$pythonScript = 'severityfull.py';
$command = 'C:\Users\aashi\AppData\Local\Programs\Python\Python311\python.exe ' . $pythonScript . ' 2>&1';

// Execute the command and capture output and error streams
exec($command, $outputLines, $returnStatus);

if ($returnStatus === 0) {
    // Execution was successful
    echo "Output:<br>";
    foreach ($outputLines as $line) {
        echo $line . "<br>";
    }
} else {
    // Execution encountered an error
    echo "Error occurred:<br>";
    foreach ($outputLines as $line) {
        echo $line . "<br>";
    }
    echo "Return status: " . $returnStatus;
}
?>
