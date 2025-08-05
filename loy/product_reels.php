<?php include 'business/trends.php'; ?>
<?php include 'business/read_trends.php'; ?>

<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Insights</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        
        <!-- Start of Sidebar -->
        <?php include 'sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include 'topbar.php'; ?>
                <!-- End of Topbar -->
                <script>
                    document.getElementById('form_sku_search').style.visibility='hidden';
                </script>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><b>Update Feature Reel</b> </h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> <?php echo get_trend('date_last',$_GET['text_sku_search']); ?></a>
                    </div>

                    <!-- Content Row -->
                   

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-9 col-lg-9">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Agora Feature Reel</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header"></div>
                                            <a class="dropdown-item" href="#"></a>
                                            <a class="dropdown-item" href="#"></a>
                                            </div>
                                    </div>
                                </div>
                                <!-- Card Body content goes here -->
                                <div class="card-body">

                                    <?php
                                        // Handle upload if form submitted
                              
                                    $uploadSuccess = false;
                                    $errorMessage = '';

                                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                        $targetDir = "uploads/";
                                        $targetFile = $targetDir . "featurereel.html";
                                        $file = $_FILES["fileToUpload"];
                                        $uploadOk = 1;

                                        // Check if file was uploaded without errors
                                        if ($file["error"] !== UPLOAD_ERR_OK) {
                                            $errorMessage = "Upload error code: " . $file["error"];
                                            $uploadOk = 0;
                                        }

                                        // Optional: allow only certain file types
                                        $allowedTypes = ['html'];  // Only accept HTML since output file is fixed
                                        $fileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

                                        if (!in_array($fileType, $allowedTypes)) {
                                            $errorMessage = "Only HTML files are allowed.";
                                            $uploadOk = 0;
                                        }

                                        // Optional: check file size (e.g., 5MB max)
                                        if ($file["size"] > 5 * 1024 * 1024) {
                                            $errorMessage = "File is too large. Max size is 5MB.";
                                            $uploadOk = 0;
                                        }

                                        // Upload file
                                        if ($uploadOk) {
                                            if (!is_dir($targetDir)) {
                                                mkdir($targetDir, 0777, true);
                                            }

                                            // Delete existing file if it exists
                                            if (file_exists($targetFile)) {
                                                unlink($targetFile);
                                                $targetFile2 = $targetDir . "featurereel-updated.html";
                                                unlink($targetFile2);
                                            }

                                            if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                                                $uploadSuccess = true;
                                            } else {
                                                $errorMessage = "Failed to move uploaded file.";
                                            }
                                        }
                                    }

                                 
                                        ?>

                                        <!DOCTYPE html>
                                        <html lang="en">
                                        <head>
                                            <meta charset="UTF-8">
                                            <title>Upload File</title>
                                        </head>
                                        <body class="bg-light">
                                        <div class="container py-5">
                                            <div class="row justify-content-center">
                                                <div class="col-md-6">

                                                    <div class="card shadow-sm">
                                                        <div class="card-body">
                                                            <h4 class="card-title mb-4">Upload a File</h4>

                                                            <?php if ($uploadSuccess): ?>
                                                                <div class="alert alert-success">
                                                                    File <strong><?= htmlspecialchars($file["name"]) ?></strong> uploaded successfully.
                                                                </div>
                                                            <?php elseif ($errorMessage): ?>
                                                                <div class="alert alert-danger">
                                                                    <?= htmlspecialchars($errorMessage) ?>
                                                                </div>
                                                            <?php endif; ?>


                                                            <?php if (!$uploadSuccess): ?>
                                                            <form action="product_reels.php" method="post" enctype="multipart/form-data">
                                                                <div class="mb-3">
                                                                    <label for="fileToUpload" class="form-label">Choose file</label>
                                                                    <input class="form-control" type="file" name="fileToUpload" id="fileToUpload" required>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary">Upload File</button>
                                                            </form>
                                                            <?php endif; ?>

                                                            <?php if ($uploadSuccess): 


                                                            
                                                                  
                                                                // // Input and output file paths
                                                                $inputFile = __DIR__ . '/uploads/featurereel.html';
                                                                $outputFile = __DIR__ . '/uploads/featurereel-updated.html';

                                                                // Check if the input file exists
                                                                if (!file_exists($inputFile)) {
                                                                    die("Input file not found: $inputFile");
                                                                }

                                                                // Read the content from the file
                                                                $content = file_get_contents($inputFile);

                                                                if ($content === false) {
                                                                    die("Failed to read content from: $inputFile");
                                                                }

                                                                // Perform the replacement
                                                                $updated = preg_replace(
                                                                    '#(?<!https://www\.telstra\.com\.au)/etc/designs/#', 
                                                                    'https://www.telstra.com.au/etc/designs/', 
                                                                    $content
                                                                );
                                                                $updated = preg_replace(
                                                                    '#(?<!https://www\.telstra\.com\.au)/content/dam/#',
                                                                    'https://www.telstra.com.au/content/dam/',
                                                                    $updated
                                                                );

                                                                // Save the updated content
                                                                $result = file_put_contents($outputFile, $updated);

                                                                if ($result === false) {
                                                                    die("Failed to write updated content to: $outputFile");
                                                                }

                                                                //echo "Design libraries links have been updated on: $outputFile";

                                                                ?>
                                                                <div class="alert alert-success">
                                                                    Design libraries links are updated 
                                                                </div>

                                                                <?php
                                                                 // // Load the HTML file to update image links

                                                                $file = __DIR__ . '/uploads/featurereel-updated.html';  // Change to your actual file
                                                                $html = file_get_contents($file);

                                                                // Load into DOMDocument
                                                                libxml_use_internal_errors(true);
                                                                $doc = new DOMDocument();
                                                                $doc->loadHTML($html);

                                                                // Get all <picture> elements
                                                                $pictures = $doc->getElementsByTagName('picture');

                                                                foreach ($pictures as $picture) {
                                                                    // ✅ Only process if class="lazy-load"
                                                                    $class = $picture->getAttribute('class');
                                                                    if (strpos($class, 'lazy-load') === false) {
                                                                        continue;
                                                                    }

                                                                    $imgTag = null;
                                                                    $dataSrc = null;

                                                                    // Look for <source> and get data-srcset
                                                                    foreach ($picture->childNodes as $child) {
                                                                        if ($child->nodeName === 'source' && $child->hasAttribute('data-srcset')) {
                                                                            $dataSrc = $child->getAttribute('data-srcset');
                                                                        } elseif ($child->nodeName === 'img') {
                                                                            $imgTag = $child;
                                                                        }
                                                                    }

                                                                    // Replace <img src> if valid data-srcset exists
                                                                    if ($imgTag && $dataSrc) {
                                                                        $imgTag->setAttribute('src', $dataSrc);
                                                                    }
                                                                }

                                                                // Save the updated HTML
                                                                $updated = $doc->saveHTML();
                                                                file_put_contents($file, $updated);

                                                               // echo "Image links are updated.\n";
                                                                ?>
                                                                <div class="alert alert-success">
                                                                    Image links are updated 
                                                                </div>
                                                                <a href="uploads/featurereel-updated.html" class="btn btn-primary" download>
                                                                Download File
                                                                </a>
                                                                <?php


                                                             endif; 
                                                             ?>
                                                            

                                                        </div>
                                                    </div>

                                                    <p class="mt-3 text-muted small">Allowed types: html. Max size: 1MB.</p>
                                                </div>
                                            </div>
                                        </div>
                                        </body>
                                        </html>




                                    

                                </div>
                            </div>
                        </div>

                     

                        <!-- Pie Chart -->
                       
                    </div>

                    

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include 'footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?php include 'logout.php'; ?>
    <!-- End Logout Modal-->

   


<!-- Modal Search-->
<?php //include 'searchmodal.php'; ?>
<!-- End Modal Search-->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>



    <!-- Business script-->
    <script type="text/javascript" src="business/business.js"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>


     <!-- Page level plugins -->
     <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>




    
</body>




</html>