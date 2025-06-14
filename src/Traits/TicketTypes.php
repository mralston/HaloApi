<?php

namespace DerrickSmith\HaloApi\Traits;

use Exception;

trait TicketTypes
{
    public function getTicketTypes(array $array = []): array|object
    {
        $endpoint = $this->host . '/api/TicketType';
        return $this->exec('GET', $endpoint, $array);
    }

    /**
     * @throws Exception
     */
    public function getTicketType(array $array = []): array|object
    {
        if (empty($array['id'])) {
            throw new Exception("Missing 'id' parameter.");
        }
        $endpoint = $this->host . '/api/TicketType/'.$array['id'];
        unset($array['id']);
        return $this->exec('GET', $endpoint, $array);
    }

    public function postTicketType(array $array = []): array|object
    {
        $endpoint = $this->host . '/api/TicketType';
        return $this->exec('POST', $endpoint, $array);
    }

    /**
     * @throws Exception
     */
    public function deleteTicketType(array $array = []): array|object
    {
        if (empty($array['id'])) {
            throw new Exception("Missing 'id' parameter.");
        }
        $endpoint = $this->host . '/api/TicketType/'.$array['id'];
        unset($array['id']);
        return $this->exec('DELETE', $endpoint, $array);
    }
}
