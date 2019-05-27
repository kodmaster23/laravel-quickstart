<?php
/**
 * Created for Kodmaster23.
 * User: Thiago Traczykowski
 */

namespace Kodmaster23\LaravelQuickStart\Services;


use GuzzleHttp\Client;

class RestClient
{

    /**
     * @var string
     */
    private $url;
    /**
     * @var string
     */
    private $method;
    /**
     * @var array
     */
    private $headers;
    /**
     * @var array
     */
    private $data;

    public function __construct(
        string $url,
        string $method = 'GET',
        array $headers = [],
        array $data = []
    )
    {
        $this->client = $client = new Client();
        $this->bootstrap($url, $method, $headers);
        $this->setData($data);
    }

    public function bootstrap(
        string $url,
        string $method = 'GET',
        array $headers = []
    )
    {
        $this->url = $url;
        $this->method = $method;
        $this->headers = $headers;

    }

    public function setData(array $data = [])
    {
        $this->data = $data;
    }

    public function send()
    {
        $response = $this->client->request($this->method,$this->url,
            [
                'headers' =>  $this->headers,
                'body' => json_encode($this->data)
            ]);

        return json_decode($response->getBody()->getContents());
    }

}
