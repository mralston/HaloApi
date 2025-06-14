<?php

namespace DerrickSmith\HaloApi\Traits;

use Exception;

trait Sites
{
    public function getSites(array $array = []): array|object
    {
        $endpoint = $this->host . '/api/Site';
        return $this->exec('GET', $endpoint, $array);
    }

    /**
     * @throws Exception
     */
    public function getSite(array $array = []): array|object
    {
        if (empty($array['id'])) {
            throw new Exception("Missing 'id' parameter.");
        }
        $endpoint = $this->host . '/api/Site/'.$array['id'];
        unset($array['id']);
        return $this->exec('GET', $endpoint, $array);
    }

    public function postSite(array $array = []): array|object
    {
        $endpoint = $this->host . '/api/Site';
        return $this->exec('POST', $endpoint, $array);
    }

    /**
     * @throws Exception
     */
    public function deleteSite(array $array = []): array|object
    {
        if (empty($array['id'])) {
            throw new Exception("Missing 'id' parameter.");
        }
        $endpoint = $this->host . '/api/Site/'.$array['id'];
        unset($array['id']);
        return $this->exec('DELETE', $endpoint, $array);
    }
}
