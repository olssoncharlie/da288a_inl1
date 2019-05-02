<?php
    require 'vendor/autoload.php';
    
    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;

    $client = new GuzzleHttp\Client();
    $log = new Logger('default');

    $unicorns = $_GET["unicorn-id"];
    try {
        $res = $client->request('GET', 'http://unicorns.idioti.se', [
            'id' => [$id],
            'headers' => ['Accept' => 'application/json']
        ]);

        $result =  json_decode((string) $res->getBody(), true);   
        
        // Log access
        $log->pushHandler(new StreamHandler(__DIR__.'/log.log', Logger::INFO));
        $log->addInfo('Requested info about all unicorns'); 
    } catch (\Throwable $th) {
        //throw $th;
        return "<h2 id='error-text'> Något gick fel i hämtningen av alla enhörningar.. </h2>";
    }

?>

<h2> Alla enhörningar </h2>
    <ol class="list-group">
        <?php foreach ($result as $key => $item) {
            // API returned empty objects, only render if the unicorn has a name length
            if (strlen($item['name']) > 1) {
                echo("
                <form action='#' method='get'>
                    <li class='list-group-item'> $item[id]: $item[name]
                        <input type='hidden' value='$item[id]' name='unicorn-id' />
                        <button type='submit' id='unicorn-id' value='searchUnicorn' name='findUnicorn' class='btn btn-secondary btn-sm read-more'> Läs mer </button>
                    </li>
                </form>");
            }}; 
        ?> 
    </ol>
</form>
