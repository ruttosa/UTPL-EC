<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME ?></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    
    <!-- App styles -->
    <link rel="stylesheet" href="<?php echo URLROOT ?>/public/css/style.css">

</head>
<body>
    <?php require APPROOT . '/views/inc/navbar.php'; ?>
    <div class="container-fluid">

    <!-- Cargar solo para usuarios logueados para adaptarse al menú lateral -->
    <?php if(isset($_SESSION['user_id'])) : ?>
    <div class="row">
        <div class="offset-xl-2 col mt-top py-3">
    <?php endif; ?>
        