<?php

namespace Derricksmith\Haloapi\Traits;

use Exception;

trait Actions
{
    public function getActions(array $array = []): array|object
    {
        $endpoint = $this->host . '/api/actions';
        return $this->exec('GET', $endpoint, $array);
    }

    /**
     * @throws Exception
     */
    public function getAction(array $array = []): array|object
    {
        if (empty($array['id'])) {
            throw new Exception("Missing 'id' parameter.");
        }
        $endpoint = $this->host . '/api/actions';
        return $this->exec('GET', $endpoint, $array);
    }

    public function postActions(array $array = []): array|object
    {
        $endpoint = $this->host . '/api/actions';
        return $this->exec('POST', $endpoint, $array);
    }

    /**
     * @throws Exception
     */
    public function deleteActions(array $array = []): array|object
    {
        if (empty($array['id'])) {
            throw new Exception("Missing 'id' parameter.");
        }
        $endpoint = $this->host . '/api/actions/'.$array['id'];
        unset($array['id']);
        return $this->exec('DELETE', $endpoint, $array);
    }
}
