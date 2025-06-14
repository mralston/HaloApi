<?php

namespace DerrickSmith\HaloApi\Traits;

use Exception;

trait KbArticles
{
    public function getKbArticles(array $array = []): array|object
    {
        $endpoint = $this->host . '/api/KBArticle';
        return $this->exec('GET', $endpoint, $array);
    }

    /**
     * @throws Exception
     */
    public function getKbArticle(array $array = []): array|object
    {
        if (empty($array['id'])) {
            throw new Exception("Missing 'id' parameter.");
        }
        $endpoint = $this->host . '/api/KBArticle/'.$array['id'];
        unset($array['id']);
        return $this->exec('GET', $endpoint, $array);
    }

    public function postKbArticle(array $array = []): array|object
    {
        $endpoint = $this->host . '/api/KBArticle';
        return $this->exec('POST', $endpoint, $array);
    }

    /**
     * @throws Exception
     */
    public function deleteKbArticle(array $array = []): array|object
    {
        if (empty($array['id'])) {
            throw new Exception("Missing 'id' parameter.");
        }
        $endpoint = $this->host . '/api/KBArticle/'.$array['id'];
        unset($array['id']);
        return $this->exec('DELETE', $endpoint, $array);
    }
}
