<?php

namespace razorbacks\digitalmeasures\rest;

use Zttp\Zttp;
use Exception;

class Api
{
    protected $baseUrl = 'https://www.digitalmeasures.com/login/service/v4';
    protected $username;
    protected $password;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function send(string $method, string $endpoint, array $data = [])
    {
        $response = Zttp::withBasicAuth($this->username, $this->password)
        ->$method($this->baseUrl.$endpoint, $data);

        if (!$response->isOk()) {
            $status = $response->status();
            $body = $response->body();

            throw new BadResponse('Response not OK:'.$status.PHP_EOL.$body, $status);
        }

        return $response->body();
    }

    public function get(string $endpoint, array $data = [])
    {
        return $this->send('GET', $endpoint, $data);
    }

    public function post(string $endpoint, array $data)
    {
        return $this->send('POST', $endpoint, $data);
    }

    public function put(string $endpoint, array $data)
    {
        return $this->send('PUT', $endpoint, $data);
    }

    public function patch(string $endpoint, array $data)
    {
        return $this->send('PATCH', $endpoint, $data);
    }

    public function delete(string $endpoint, array $data = [])
    {
        return $this->send('DELETE', $endpoint, $data);
    }
}

class BadResponse extends Exception {}
