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

<br>
    <div class="title text-center">
        <p style="font-size: 24px; font-weight: bold;">กรุณากรองข้อมูลแถวและหลักเป็นตัวเลข</p>

        <hr>

        <form class="text-center" method="post" action="cc.php">
            <div class="form-group w-200 center-block">
                <label class="sr-only" for="inputRow">จำนวนแถว (N)</label>
                <div class="input-group">
                    <div class="input-group-addon">จำนวนแถว (N)</div>
                    <input type="number" class="form-control" id="inputRow" name="row" placeholder="ใส่เป็นตัวเลข">
                </div>
            </div>

            <div class="form-group w-200 center-block">
                <label class="sr-only" for="inputColumn">จำนวนหลัก (M)</label>
                <div class="input-group">
                    <div class="input-group-addon">จำนวนหลัก (M)</div>
                    <input type="number" class="form-control" id="inputColumn" name="column" placeholder="ใส่เป็นตัวเลข">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">ตกลง</button>
        </form>
    </div>

</body>
</html>
