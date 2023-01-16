<?php

namespace WebLogin\LaravelWhmServices\Commands;

use Exception;
use Illuminate\Console\Command;


class Restart extends Command
{

    protected $signature = 'whm-services:restart {service}';
    protected $description = 'Restart a WHM service';


    public function handle()
    {
        $host = config('whm-services.host');
        $port = config('whm-services.port');
        $apiToken = config('whm-services.api_token');

        $service = $this->argument('service');

        $response = file_get_contents(
            "{$host}:{$port}/json-api/restartservice?api.version=1&service={$service}",
            false,
            stream_context_create([
                'http' => [
                    'header' => "Authorization: whm root:{$apiToken}\r\n",
                ],
            ])
        );

        $json = json_decode($response, true);

        if ($json['metadata']['reason'] !== 'OK') {
            throw new Exception("[{$service}] service restart failed, reason : {$json['metadata']['reason']}");
        }

        $this->output->text($json['metadata']['output']['raw']);
    }

}
