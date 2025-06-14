<?php

namespace DerrickSmith\HaloApi\Traits;

use Exception;

trait Agents
{
    public function getAgents(array $array = []): array|object
    {
        $endpoint = $this->host . '/api/Agent';
        return $this->exec('GET', $endpoint, $array);
    }

    /**
     * @throws Exception
     */
    public function getAgent(array $array = []): array|object
    {
        if (empty($array['id'])) {
            throw new Exception("Missing 'id' parameter.");
        }
        $endpoint = $this->host . '/api/Agent/'.$array['id'];
        unset($array['id']);
        return $this->exec('GET', $endpoint, $array);
    }

    public function getAgentSelf(): array|object
    {
        $endpoint = $this->host . '/api/Agent/me';
        return $this->exec('GET', $endpoint);
    }

    public function postAgent(array $array = []): array|object
    {
        $endpoint = $this->host . '/api/Agent';
        return $this->exec('POST', $endpoint, $array);
    }

    /**
     * @throws Exception
     */
    public function deleteAgent(array $array = []): array|object
    {
        if (empty($array['id'])) {
            throw new Exception("Missing 'id' parameter.");
        }
        $endpoint = $this->host . '/api/Agent/'.$array['id'];
        unset($array['id']);
        return $this->exec('DELETE', $endpoint, $array);
    }
}
