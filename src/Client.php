<?php

namespace Techknowlogick\Phabricator;

class Client {

	var $client = "php-conduit",
        $client_version = "0.0.1",
        $url = null,
        $auth_token = null,
        $port = 443,

        $proxy = null,

        $apis = array(); // hold api obj references

    public function __construct($url, $auth_token, $options = array())
    {
        $this->url = $url;
        $this->auth_token = $auth_token;
        if(!empty($options['proxy'])) $this->proxy = $options['proxy'];
        if(!empty($options['port'])) $this->port = $options['port'];
        if(!empty($options['user_agent'])) $this->user_agent = $options['user_agent'];
    }

    public function api($name)
    {
        if (!isset($this->apis[$name])) {
            switch ($name) {
                case "user":
                case "users":
                	$api = new Api\User($this);
                	break;
                case "task":
                case "tasks":
                    $api = new Api\Task($this);
                    break;
                default:
                    throw new \InvalidArgumentException();
            }

            $this->apis[$name] = $api;
        }

        return $this->apis[$name];
    }

    public function request($path, $method = 'GET', $data = array())
    {

		$curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url."/api/".$path);
        curl_setopt($curl, CURLOPT_VERBOSE, 0);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_USERAGENT,
            !empty($this->user_agent) ? $this->user_agent : sprintf("php-curl - %s/%s",
                        $this->client, $this->client_version));

        if(!empty($this->proxy)) {
            curl_setopt($curl, CURLOPT_PROXY, $this->proxy);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        }

        curl_setopt($curl, CURLOPT_PORT , $this->port);
        curl_setopt($curl, CURLOPT_POST, 1);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $data["api.token"] = $this->auth_token;

		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));        

		$response = curl_exec($curl);

        if (curl_errno($curl)) {
            $e = new \Exception(curl_error($curl), curl_errno($curl));
            curl_close($curl);
            throw $e;
        }
        curl_close($curl);

        $json = json_decode($response, true);

   		return $json;
    }
}