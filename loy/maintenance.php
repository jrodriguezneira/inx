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

    <title>Maintenance</title>

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
                        <h1 class="h3 mb-0 text-gray-800"><b>Maintenance</b> </h1>
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
                                    <h6 class="m-0 font-weight-bold text-primary">Maintenance</h6>
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

                                
                                            <form method="POST" action="maintenance.php" enctype="multipart/form-data">

                                            <div>

                                            <span>Upload a File:</span>

                                            <input type="file" name="uploadedFile" />

                                            <br><br>

                                            </div>

                                            <input type="submit" class="btn btn-primary"  name="uploadBtn" value="Upload the File" />

                                            </form>

                                            </body>

                                            </html>


                                            <?php


                                            $message = ''; 

                                            if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload the File')

                                            {

                                            if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK)

                                            {

                                            // uploaded file details

                                            $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];

                                            $fileName = $_FILES['uploadedFile']['name'];

                                            $fileSize = $_FILES['uploadedFile']['size'];

                                            $fileType = $_FILES['uploadedFile']['type'];

                                            $fileNameCmps = explode(".", $fileName);

                                            $fileExtension = strtolower(end($fileNameCmps));

                                            // removing extra spaces

                                            $newFileName = "master-file" . '.' . $fileExtension;

                                            // file extensions allowed

                                            $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xlsx', 'doc');

                                            if (in_array($fileExtension, $allowedfileExtensions))

                                            {

                                            // directory where file will be moved

                                            $uploadFileDir = "files/"; //. $_FILES['uploadedFile']['name'];

                                            $dest_path = $uploadFileDir . $newFileName;

                                            echo $dest_path;

                                            if(move_uploaded_file($fileTmpPath, $dest_path)) 

                                            {

                                                $message = 'File uploaded successfully.';

                                            }

                                            else 

                                            {

                                                $message = 'An error occurred while uploading the file to the destination directory. Ensure that the web server has access to write in the path directory.';

                                            }

                                            }

                                            else

                                            {

                                            $message = 'Upload failed as the file type is not acceptable. The allowed file types are:' . implode(',', $allowedfileExtensions);

                                            }

                                            }

                                            else

                                            {

                                            $message = 'Error occurred while uploading the file.<br>';

                                            $message .= 'Error:' . $_FILES['uploadedFile']['error'];

                                            }

                                            }

                                            echo $message;


                                            //header("Location: index.php");


                                            ?>

                                            <a href="new-pricing.php?x=update"> Update master RRP </a>

                                            <?php
                                            //Export productc to excel file
                                            if(isset($_GET['x'])){           
                                            // include 'file-master-to-db.php'; 
                                            // build_table_sales(build_excel_data("../files/master-file.xlsx"),"../files/master-file.xlsx");
                                            }
                                            // obtain_VPP();
                                            // echo "New VPP has been updated";
                                            // create_new_pricing();
                                            // echo "New pricing has been created";
                                            ?>




                                



                                    

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