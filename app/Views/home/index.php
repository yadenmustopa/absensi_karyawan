<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="descrition" content="Aplikasi sederhana memanage data karyawan"> 
    <meta name="author" content="Yaden Mustopa">

    <!-- Fonts and CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Mono">


    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

<!-- CSS Files -->
    <link id="pagestyle" href="<?= base_url();?>/dist/soft-ui.css" rel="stylesheet" />


    <link rel="stylesheet" href="<?= base_url(); ?>/dist/home.css?_=<?= time(); ?>">
    <link rel="icon" href="<?= base_url(); ?>/assets/images/icon.ico" type="image/png">

    <title>Absensi Karyawan</title>

    <style>
        :root {
            --primary-custom : #7b03f3;
        }
    </style>

    <script>
        window.config = {
            base_url : <?= "'".base_url()."'";?>
        }
    </script>
</head>
<body id="app" class="g-sidenav-show bg-gray-100">
    

    
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- Core -->
<script src="<?= base_url()?>/dist/soft-ui.js?_=<?= time(); ?>"></script>

<script src="<?= base_url(); ?>/dist/home.js?_=<?= time(); ?>"></script>

<script>

    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = {
        damping: '0.5'
    }
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
</html>