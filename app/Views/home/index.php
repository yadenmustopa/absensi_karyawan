<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="descrition" content="Aplikasi sederhana memanage data karyawan"> 
    <meta name="author" content="Yaden Mustopa">

    <!-- Fonts and CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Mono">
    <link rel="icon" href="<?= base_url(); ?>/assets/images/icon.ico" type="image/png">

    <title>Absensi Karyawan</title>

    <style>
        :root {
            --primary-custom : #7b03f3;
        }
    </style>

    <script>
        window.config = {
            base_url : <?= base_url();?>
        }
    </script>
</head>
<body>
    <header>
        <!-- Fixed navbar -->
        <nav class="navbar main-navbar navbar-expand-md navbar-dark fixed-top bg-primary">
            <a class="navbar-brand" href="<?= base_url(); ?>">
                <img src="<?= base_url(); ?>/assets/images/logo.png" class="mr-1"/>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url(); ?>">HOME</a>
                    </li>

                </ul>
            </div>
        </nav>
    </header>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>