<?php
    session_start();
    unset($_SESSION['sd'], $_SESSION['sumProduct'], $_SESSION['sumProductStr'], $_SESSION['supply'], $_SESSION['demand'], $_SESSION['output']);

include(__DIR__ . '/language.php');


if (isset($_SESSION['row']) && isset($_SESSION['column'])) {
        $row = $_SESSION['row'];
        $column = $_SESSION['column'];
    } else {

        if ((!isset($_POST['row']) || !isset($_POST['column'])) || ($_POST['row'] == '' || $_POST['column'] == '')) {
            header('location: index.php');
        }

        $row = $_POST['row'];
        $column = $_POST['column'];

        // check row and column <= 10
        if ($row > 10 || $column > 10)
        {
            header('location: index.php');
        }

        $_SESSION['row'] = $row;
        $_SESSION['column'] = $column;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?=$lang->getValue('page_cc')?></title>

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
                <li><a href="cc.php?language=th">Thai</a></li>
                <li><a href="cc.php?language=en">Eng</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>


<div class="container">

    <br>
    <div class="text-center">
        <p style="font-size: 24px; font-weight: bold;"><?=$lang->getValue('cc_text_center') ?></p>

        <hr>

        <form method="post" action="output.php">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">


                    <?php

                    // row
                    for ($i = 0; $i < $row + 2; $i++)
                    {
                        echo '<tr>';
                        // column
                        for ($j = 0; $j < $column + 2; $j++)
                        {
                            // first row
                            if($i === 0)
                            {
                                if ($j === 0)
                                {
                                    // คอลัมน์แรก
                                    echo '<th class="text-center active">#</th>';
                                }
                                else if ($j === ($column + 1))
                                {
                                    // คอลัมน์สุดท้าย
                                    echo '<th class="text-center success">'.$lang->getValue('supply').'</th>';
                                }
                                else
                                {
                                    // others
                                    echo '<th class="text-center warning">D '. $j . '</th>';
                                }
                            }
                            // others row
                            else if ($i !== 0 && $i !== ($row + 1))
                            {
                                if ($j === 0)
                                {
                                    // คอลัมน์แรก
                                    echo '<th class="text-center warning">';
                                    echo 'S' . $i;
                                    echo '</th>';
                                }
                                else if ($j === ($column + 1))
                                {
                                    // คอลัมน์สุดท้าย
                                    echo '<th class="text-center">
                                            <input type="number" class="form-control" name="supply['.($i-1).']" placeholder="Supply '.$i.'" value="0">  
                                          </th>';
                                }
                                else
                                {
                                    // others
                                    echo '<th class="text-center">
                                            <input type="number" class="form-control" name="sd['.($i-1).']['.($j-1).']" placeholder="0" value="0">
                                          </th>';
                                }
                            }
                            // last row
                            else
                            {
                                if ($j === 0)
                                {
                                    // คอลัมน์แรก
                                    echo '<th class="text-center success">'.$lang->getValue('demand').'</th>';
                                }
                                else if ($j === ($column + 1))
                                {
                                    // คอลัมน์สุดท้าย
                                    echo '<th class="text-center"></th>';
                                }
                                else
                                {
                                    // others
                                    echo '<th class="text-center">';
                                    echo '<input type="number" class="form-control" name="demand['.($j - 1).']" placeholder="Demand '.$j.'" value="0">';
                                    echo '</th>';
                                }
                            }
                        }
                        echo '</tr>';
                    }

                    ?>
                    <!-- On cells (`td` or `th`) -->
                    <!--<tr>
                        <td class="active">...</td>
                        <td class="success">...</td>
                        <td class="warning">...</td>
                        <td class="danger">...</td>
                        <td class="info">...</td>
                    </tr>-->

                </table>
            </div>
            <div class="form-group">
                <input type="hidden" name="row" value="<?php echo $row ?>">
                <input type="hidden" name="column" value="<?php echo $column ?>">

                <button type="submit" class="btn btn-primary"><?=$lang->getValue('cc_ok') ?></button>
            </div>
        </form>

    </div>
</div>

</body>
</html>
