<?php 
require 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Create logger
$log = new Logger('default');

function getUnicorn()
{
    $client = new GuzzleHttp\Client();
    $searchId = $_GET['unicorn-id'];
    if (!is_numeric($searchId)) {
        return array(false, 'Var god fyll i ett nummer på en enhörning.');
    }
    
    try {
        $url = "http://unicorns.idioti.se/".(string)$searchId;
        // Search for unicorn 
        $res = $client->get($url, [
            'headers' => ['Accept' => 'application/json'],
        ]);
        return array(true, $res->getBody());

    } catch (\Throwable $th) {
        return array(false, 'Något gick fel i sökningen... Försök igen!');
    }
}


$unicornResult = getUnicorn();

// early return if the call to unicorn API gets and error
if (!$unicornResult[0]) {
    echo "<h2 id='error-text'> $unicornResult[1] </h2>";
    return;
} 

$data =  json_decode((string) $unicornResult[1], true);

// Variables for HTML rendering of the unicorn
$name = $data["name"];
$description = $data["description"];
$reportedBy = $data["reportedBy"];
$spottedWhere = $data["spottedWhere"]; #name, lon, lat
$spottedWhen = $data["spottedWhen"];
$image = $data["image"];


// Log user access
$log->pushHandler(new StreamHandler(__DIR__.'/log.log', Logger::INFO));
$log->addInfo("Requested info about $name");

?> 

<h2> <?php echo $name; ?> </h2>
<p> <?php echo $spottedWhen; ?> <img id="unicorn-image"src=<?php echo $image?> </p>
<p> <?php echo $description; ?> </p>
<p> <b> Rapporterad av: </b><?php echo $reportedBy; ?> </p>
