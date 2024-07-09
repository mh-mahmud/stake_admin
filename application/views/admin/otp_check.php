<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Betscore24</title> 
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="shortcut icon" href="https://i.imgur.com/QRAUqs9.png">

    <link rel="stylesheet" href="<?=base_url('assets/admin/assets/css/normalize.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/admin/assets/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url('assets/admin/assets/css/themify-icons.css')?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="<?=base_url('assets/admin/assets/css/flag-icon.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/admin/assets/css/cs-skin-elastic.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/admin/assets/css/style.css')?>">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <style>
        .bg-dark {
            background-color: #ccc !important;
        }
    </style>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
</head>
<body class="bg-dark">

<div class="sufee-login d-flex align-content-center flex-wrap">
    <div class="container">
        <div class="login-content" style="margin-top: 15%;">

            <div style="margin-bottom: 20px">
                <?php if($this->session->flashdata('msg')){ ?>
                    <div class="col-md-12 alert-success" style="padding: 15px;">
                        <?php echo $this->session->flashdata('msg'); ?>
                    </div>
                <?php } ?>

                <?php if($this->session->flashdata('error')){ ?>
                    <div class="col-md-12 alert-danger" style="padding: 15px;">
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php } ?>
            </div>

            <!--<div class="login-logo">
                <a href="index.html">
                    <img class="align-content" src="images/logo.png" alt="">
                </a>
            </div>-->
            <div class="login-form" style="border-radius:5px;padding: 60px;">
                <form method="post" action="<?php echo base_url('login/authenticate_otp'); ?>">
                    <input type="hidden" class="form-control" name="email" value="<?php echo $email; ?>">
                    <input type="hidden" class="form-control" name="password" value="<?php echo $password; ?>">
                    <input type="hidden" class="form-control" name="secret" value="<?php echo $secret; ?>">
                    <div class="form-group">
                        <label>Enter OTP</label>
                        <input name="code" type="password" class="form-control" placeholder="Give OTP Code" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>

                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>
