<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Output ASM Method</title>

    <!-- Fonts -->
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">

</head>
<body>

<?php
include(__DIR__ . '/language.php');
include_once (__DIR__.'/process/auto_load.php');
//include_once (__DIR__.'/vendor/auto_load.php');

$supply = $_POST['supply'];
$demand = $_POST['demand'];

$process = new ProcessASM($_POST['row'], $_POST['column'], $demand, $supply, $_POST['sd']);

$show = $process->output();


?>

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
            <a class="navbar-brand" href="#">ASM Method</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Thai</a></li>
                <li><a href="#">Eng</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>


<div class="container">

    <br>
    <div class="text-center">
        <p style="font-size: 24px; font-weight: bold;"><?=$lang->getValue('output_result')?></p>

        <hr>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">

                <?php
                if (!isset($_POST['row']) && !isset($_POST['column']) && !isset($_POST['sd'])) {
                    header('location: index.php');
                }

                $row = $_POST['row'];
                $column = $_POST['column'];
                $sd = $_POST['sd'];

                $sumProduct = 0;
                $sumProductStr = '';

                // คำนวณ
                $count = 0;
                foreach ($show as $item => $value) {
                    foreach ($value as $item2 => $value2) {
                        if ($value2 !== 0) {
                            if ($count !== 0) {
                                $sumProductStr .= '+ ';
                            }
                            $count++;
                            $val = $sd[$item][$item2];
                            $sumProduct += $value2 * $val;
                            $sumProductStr .= "($value2 * $val) ";
                        }
                    }
                }


                // check row and column <= 10
                if ($row > 10 || $column > 10)
                {
                    header('location: index.php');
                }

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
                                echo '<th class="text-center active"> '.$lang->getValue('output_total'). ' = '.$sumProduct.'</th>';
                            }
                            else if ($j === ($column + 1))
                            {
                                // คอลัมน์สุดท้าย
                                echo '<th class="text-center success">Supply</th>';
                            }
                            else
                            {
                                // others
                                echo '<th class="text-center warning">D'. $j . '</th>';
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
                                // คอลัมน์สุดท้าย supply
                                echo '<th class="text-center danger">';
                                echo $supply[$i - 1];
                                echo '</th>';
                            }
                            else
                            {
                                // others
                                if ($show[$i - 1][$j - 1] > 0) {
                                    echo '<th class="text-center info">';
                                    echo '<label class="active">';
                                    echo $show[$i - 1][$j - 1];
                                    echo '</label>';
                                } else {
                                    echo '<th class="text-center">';
                                    echo $show[$i - 1][$j - 1];
                                }
                                echo '</th>';
                            }
                        }
                        // last row
                        else
                        {
                            if ($j === 0)
                            {
                                // คอลัมน์แรก
                                echo '<th class="text-center success">Demand</th>';
                            }
                            else if ($j === ($column + 1))
                            {
                                // คอลัมน์สุดท้าย
                                echo '<th class="text-center"></th>';
                            }
                            else
                            {
                                // others
                                echo '<th class="text-center danger">';
                                echo $demand[$j-1];
                                echo '</th>';
                            }
                        }
                    }
                    echo '</tr>';
                }

                ?>

            </table>
            <hr>
        </div>

    </div>

    <div class="alert alert-info" role="alert">
        <table width="100%">
            <tr>
                <td><?=$lang->getValue('output_optimal')?></td>
                <td>= &nbsp;<?=$sumProductStr?></td>
            </tr>
            <tr>
                <td></td>
                <td>= &nbsp;<?=$sumProduct?>&nbsp; บาท</td>
            </tr>
        </table>
    </div>
    <hr>


    <h4><?=$lang->getValue('output_transpostation')?></h4>

    <table class="table-hover">
        <?PHP
            foreach ($show as $item => $value) {

                foreach ($value as $item2 => $value2) {
                    if ($value2 > 0) {
                        echo '<tr>';
                        echo '<td>S<sub>'.($item + 1).'</sub> &nbsp;-->&nbsp; D<sub>'.($item2 + 1).'</sub></td>';
                        echo '<td width="40" class="text-center"> = </td>';
                        echo '<td>'.$value2.'</td>';
                        echo '</tr>';
                    }
                }

            }
        ?>
    </table>

</div>

</body>
</html>

