<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title class="blog-title"><?= get_settings()->blog_title; ?> - <?= isset($tabTitle) ? $tabTitle : 'New Page Title'; ?></title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/backend/vendors/images/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="/backend/vendors/images/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="/backend/vendors/images/favicon-16x16.png" />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/backend/vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="/backend/vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="/backend/vendors/styles/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="/extra-assets/ijaboCropTool/ijaboCropTool.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/viewerjs@latest/dist/viewer.min.css">
    <?= $this->renderSection('stylesheets'); ?>
    <style>
        .swal2-popup {
            font-size: .87em;
        }
    </style>
</head>

<body class="header-white sidebar-light">
    <?php include('inc/header.php'); ?>
    <?php include('inc/left-sidebar.php'); ?>
    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div>
                    <?php $this->renderSection('content'); ?>
                </div>
            </div>
            <?php include('inc/footer.php'); ?>
        </div>
    </div>


    <!-- js -->
    <script src="/backend/vendors/scripts/core.js"></script>
    <script src="/backend/vendors/scripts/script.min.js"></script>
    <script src="/backend/vendors/scripts/process.js"></script>
    <script src="/backend/vendors/scripts/layout-settings.js"></script>
    <script src="/extra-assets/ijaboCropTool/ijaboCropTool.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/viewerjs@latest/dist/viewer.min.js"></script>

    <?= $this->renderSection('scripts'); ?>
</body>

</html>