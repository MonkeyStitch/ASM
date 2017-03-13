<?php
    session_start();
    unset($_SESSION['row'],$_SESSION['column'],$_SESSION['sd'], $_SESSION['sumProduct'], $_SESSION['sumProductStr'], $_SESSION['supply'], $_SESSION['demand'], $_SESSION['output']);
    include(__DIR__ . '/language.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?=$lang->getValue('page_index')?></title>

    <!-- Fonts -->
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">

</head>
<body>



<nav class="navbar navbar-default">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><?=$lang->getValue('brand')?></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="index.php?language=th">Thai</a></li>
                <li><a href="index.php?language=en">Eng</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>


<br>
    <div class="title text-center">
        <p style="font-size: 24px; font-weight: bold;"><?=$lang->getValue('index_title') ?></p>

        <hr>

        <form class="text-center" method="post" action="cc.php">
            <input type="hidden" name="language" value="<?=$_GET['language']?>">

            <div class="form-group w-200 center-block">
                <label class="sr-only" for="inputRow"><?=$lang->getValue('index_row') ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><?=$lang->getValue('index_row') ?></div>
                    <input type="number" class="form-control" id="inputRow" name="row" placeholder="<?=$lang->getValue('index_pleas_number') ?>">
                </div>
            </div>

            <div class="form-group w-200 center-block">
                <label class="sr-only" for="inputColumn"><?=$lang->getValue('index_column') ?></label>
                <div class="input-group">
                    <div class="input-group-addon"><?=$lang->getValue('index_column') ?></div>
                    <input type="number" class="form-control" id="inputColumn" name="column" placeholder="<?=$lang->getValue('index_pleas_number') ?>">
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><?=$lang->getValue('index_ok') ?></button>
        </form>
    </div>


<script src="lib/jQuery/jquery.min.js"></script>
<script>
    $('a').click(function(){
        console.log('click');
        window.location.reload();
    });
</script>
</body>
</html>
