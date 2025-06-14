<?php

namespace DerrickSmith\HaloApi\Traits;

use Exception;

trait Reports
{
    public function getReports(array $array = []): array|object
    {
        $endpoint = $this->host . '/api/Report';
        return $this->exec('GET', $endpoint, $array);
    }

    /**
     * @throws Exception
     */
    public function getReport(array $array = []): array|object
    {
        if (empty($array['id'])) {
            throw new Exception("Missing 'id' parameter.");
        }
        $endpoint = $this->host . '/api/Report/'.$array['id'];
        unset($array['id']);
        return $this->exec('GET', $endpoint, $array);
    }

    public function postReport(array $array = []): array|object
    {
        $endpoint = $this->host . '/api/Report';
        return $this->exec('POST', $endpoint, $array);
    }

    /**
     * @throws Exception
     */
    public function deleteReport(array $array = []): array|object
    {
        if (empty($array['id'])) {
            throw new Exception("Missing 'id' parameter.");
        }
        $endpoint = $this->host . '/api/Report/'.$array['id'];
        unset($array['id']);
        return $this->exec('DELETE', $endpoint, $array);
    }
}
