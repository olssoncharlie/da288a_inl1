<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
?>

<!doctype html>
<html>
    <head>
        <title>Enhörningar</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    </head>

<body>
    <div class="container test">
    <h1> Enhörningar</h1>
    <hr>
    <form action="#" method="get">
        <div class="form-group">
            <label for="unicorn-id">Id på enhörning </label>
            <input type="text" class="form-control" name ="unicorn-id" id="unicorn-id" placeholder="Enhörnings id...">
        </div>
        <button type="submit" name="findUnicorn" value="searchUnicorn" class="btn btn-success"> Sök enhörning </button>
        <button type="submit" name="findUnicorn" value="showAll" class="btn btn-primary"> Visa alla enhörningar </button>
    </form>

    <?php
    
        # Display a specific unicorn or all unicorns
        if(!isset($_GET["findUnicorn"])) {
            return;
        }
        $buttonValue = $_GET["findUnicorn"];
        if ($buttonValue == 'searchUnicorn') {
            $render = require_once('unicorn_info.php');
            
            return $render;
        } elseif ($buttonValue == 'showAll') {
            $render = require_once('all_unicorns.php');
            return $render;
        };
    ?>

</div>
</body>
</html>
