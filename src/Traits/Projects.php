<?php

namespace DerrickSmith\HaloApi\Traits;

use Exception;

trait Projects
{
    public function getProjects(array $array = []): array|object
    {
        $endpoint = $this->host . '/api/Projects';
        return $this->exec('GET', $endpoint, $array);
    }

    /**
     * @throws Exception
     */
    public function getProject(array $array = []): array|object
    {
        if (empty($array['id'])) {
            throw new Exception("Missing 'id' parameter.");
        }
        $endpoint = $this->host . '/api/Projects/'.$array['id'];
        unset($array['id']);
        return $this->exec('GET', $endpoint, $array);
    }

    public function postProject(array $array = []): array|object
    {
        $endpoint = $this->host . '/api/Projects';
        return $this->exec('POST', $endpoint, $array);
    }

    /**
     * @throws Exception
     */
    public function deleteProject(array $array = []): array|object
    {
        if (empty($array['id'])) {
            throw new Exception("Missing 'id' parameter.");
        }
        $endpoint = $this->host . '/api/Projects/'.$array['id'];
        unset($array['id']);
        return $this->exec('DELETE', $endpoint, $array);
    }
}
