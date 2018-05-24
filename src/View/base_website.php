<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 10.04.2018
 * Time: 05:29
 */
?>
<!DOCTYPE html>
<html>

<head>
    <!-- meta charset -->
    <meta charset="utf-8">

    <!-- viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- title -->
    <title><?= $title ?></title>

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css?family=Questrial|Raleway|Asap+Condensed" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Barlow+Semi+Condensed|Pavanam" rel="stylesheet">
    <!-- bootstrap -->
    <link rel="stylesheet" type="text/css" href="/src/public/css/bootstrap.min.css">

    <!-- personal css -->
    <link rel="stylesheet" type="text/css" href="/src/public/css/style.css">

</head>

<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/menu.php';  ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/header.php'; ?>
<div class="modal fade" id="modal-triggerer" tabindex="-1" role="dialog" aria-labelledby="modal-triggerer-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-triggerer-title">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                This is the event triggerer!
            </div>
        </div>
    </div>
</div>
<?= $template_page_content ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/footer.php'; ?>
<!-- jquery -->
<script src="/src/public/js/jquery-3.3.1.min.js"></script>

<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=x4qs0xygpeomyfpnfq0c4k5r4won9rcc7egvxs1ejbg5mxqg"></script>
<!-- bootstrap script -->
<script src="/src/public/js/bootstrap.min.js"></script>

<!-- font awesome cdn -->
<script src="https://use.fontawesome.com/e97ca15392.js"></script>

<script src="https://unpkg.com/scrollreveal/dist/scrollreveal.min.js"></script>

<!-- personnal script -->
<script src="/src/public/js/ajax.js"></script>
<script src="/src/public/js/main.js"></script>

</body>

</html>
