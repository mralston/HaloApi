<?php

namespace DerrickSmith\HaloApi\Traits;

use Exception;

trait Opportunities
{
    public function getOpportunities(array $array = []): array|object
    {
        $endpoint = $this->host . '/api/Opportunities';
        return $this->exec('GET', $endpoint, $array);
    }

    /**
     * @throws Exception
     */
    public function getOpportunity(array $array = []): array|object
    {
        if (empty($array['id'])) {
            throw new Exception("Missing 'id' parameter.");
        }
        $endpoint = $this->host . '/api/Opportunities/'.$array['id'];
        unset($array['id']);
        return $this->exec('GET', $endpoint, $array);
    }

    public function postOpportunity(array $array = []): array|object
    {
        $endpoint = $this->host . '/api/Opportunities';
        return $this->exec('POST', $endpoint, $array);
    }

    /**
     * @throws Exception
     */
    public function deleteOpportunity(array $array = []): array|object
    {
        if (empty($array['id'])) {
            throw new Exception("Missing 'id' parameter.");
        }
        $endpoint = $this->host . '/api/Opportunities/'.$array['id'];
        unset($array['id']);
        return $this->exec('DELETE', $endpoint, $array);
    }
}
