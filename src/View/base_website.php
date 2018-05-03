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

    <!-- bootstrap -->
    <link rel="stylesheet" type="text/css" href="/src/public/css/bootstrap.min.css">

    <!-- personal css -->
    <link rel="stylesheet" type="text/css" href="/src/public/css/style.css">

</head>

<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/menu.php';  ?>
<div class="error-triggerer">
    <i class="fa fa-exclamation-circle"></i>
    <p>Erreur</p>
</div>
<div class="success-triggerer">
    <i class="fa fa-check-circle"></i>
    <p>Success</p>
</div>
    <?= $template_page_content ?>
<!-- jquery -->
<script src="/src/public/js/jquery-3.3.1.min.js"></script>

<!-- bootstrap script -->
<script src="/src/public/js/bootstrap.min.js"></script>

<!-- font awesome cdn -->
<script src="https://use.fontawesome.com/e97ca15392.js"></script>

<!-- personnal script -->
<script src="/src/public/js/ajax.js"></script>
<script src="/src/public/js/main.js"></script>

</body>

</html>
