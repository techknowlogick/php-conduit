<?php

namespace Techknowlogick\Phabricator\Api;

use Techknowlogick\Phabricator\Client;

abstract class Api
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

}
