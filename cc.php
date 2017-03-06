<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ASM Method</title>

    <!-- Fonts -->
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">

</head>
<body>

<div class="container">

    <br>
    <div class="text-center">
        <p style="font-size: 24px; font-weight: bold;">กรุณากรองข้อมูลที่กำหนด</p>

        <hr>

        <form method="post" action="output.php">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">


                    <?php

                    if (!isset($_POST['row']) && !isset($_POST['column'])) {
                        header('location: index.php');
                    }

                    $row = $_POST['row'];
                    $column = $_POST['column'];
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
                                    echo '<th class="text-center active">#</th>';
                                }
                                else if ($j === ($column + 1))
                                {
                                    // คอลัมน์สุดท้าย
                                    echo '<th class="text-center success">Supply</th>';
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

                <button type="submit" class="btn btn-primary">ตกลง</button>
            </div>
        </form>

    </div>
</div>

</body>
</html>
