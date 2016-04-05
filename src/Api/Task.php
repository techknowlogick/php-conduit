<?php

namespace Techknowlogick\Phabricator\Api;

class Task extends Api{
    public function query($params = array()){
        return $this->client->request('maniphest.query', "POST", $params);
    }
    public function info($params = array()){
        return $this->client->request('maniphest.info', "POST", $params);
    }
    public function update($params = array()){
        return $this->client->request('maniphest.update', "POST", $params);
    }
}