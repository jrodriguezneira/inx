<?php
// Tell browser it's a file, not HTML
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
$allowed_origins = [
    "http://localhost:3000",
    "http://10.25.30.23:30080"
];

if (in_array($_SERVER['HTTP_ORIGIN'], $allowed_origins)) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
}

//Export productc to excel file
if(isset($_GET['rep'])){           
include 'extractors/offer-to-file.php'; 
create_current_new_pricing_file();
}

// Let's say you generate or locate the file here
// $filePath = "/path/to/generated/report.csv";
// $fileName = "report.csv";


// header('Content-Disposition: attachment; filename="' . basename($flname) . '"');
// header('Content-Transfer-Encoding: binary');
// readfile($flname);
// exit;

?>


