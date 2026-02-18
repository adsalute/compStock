<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>IT SUPPORT</title>

    <meta name="description" content="" />
    <style>
    .upload-box {
        border: 2px dashed #d6d6d6;
        border-radius: 15px;
        padding: 40px;
        text-align: center;
        background: #f9fafb;
        cursor: pointer;
    }

    .upload-box:hover {
        background: #f1f3f5;
    }

    .preview-img {
        max-width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 10px;
    }
    </style>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />
    <?php require_once "component/laysout/header.php"; ?>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <?php require_once "component/laysout/sidebar.php"; ?>

            <!-- Layout container -->
            <div class="layout-page">
                <?php require_once "component/laysout/navbar.php"; ?>

<div class="container mt-5">
                <div class="card shadow-sm">
                    <div class="card-body">

                        <h5 class="text-center mb-4">Add New Asset</h5>

                        <form action="save_asset.php" method="post" enctype="multipart/form-data">

                            <!-- Upload Photo -->
                            <h6>Upload Photo</h6>

                            <label class="upload-box w-100">
                                <div id="uploadText">
                                    <p class="mb-2 fw-bold">No photo uploaded</p>
                                    <small class="text-muted">Tap to take a photo or upload</small><br><br>
                                    <span class="btn btn-secondary btn-sm">Take Photo</span>
                                </div>

                                <img id="preview" class="preview-img d-none">

                                <input type="file" name="photo" accept="image/*" capture="environment" hidden>
                            </label>

                            <!-- General Info -->
                            <h6 class="mt-4">General Info</h6>

                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="asset_name" class="form-control" placeholder="Enter asset name"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Serial No</label>
                                <input type="text" name="serial_no" class="form-control"
                                    placeholder="Enter serial number">
                            </div>

                            <button class="btn btn-primary w-100">Save Asset</button>

                        </form>
                    </div>
                </div>
            </div>


            </div>
            <!-- / Layout page -->

            
        </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <?php require_once "component/laysout/jsload.php"; ?>

    <script>
    const fileInput = document.querySelector('input[type="file"]');
    const preview = document.getElementById('preview');
    const uploadText = document.getElementById('uploadText');

    fileInput.addEventListener("change", function() {
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function() {
                preview.src = reader.result;
                preview.classList.remove("d-none");
                uploadText.classList.add("d-none");
            }

            reader.readAsDataURL(file);
        }
    });
    </script>
</body>

</html>