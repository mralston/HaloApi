<?php

namespace DerrickSmith\HaloApi\Traits;

use Exception;

trait Suppliers
{
    public function getSuppliers(array $array = []): array|object
    {
        $endpoint = $this->host . '/api/Supplier';
        return $this->exec('GET', $endpoint, $array);
    }

    /**
     * @throws Exception
     */
    public function getSupplier(array $array = []): array|object
    {
        if (empty($array['id'])) {
            throw new Exception("Missing 'id' parameter.");
        }
        $endpoint = $this->host . '/api/Supplier/'.$array['id'];
        unset($array['id']);
        return $this->exec('GET', $endpoint, $array);
    }

    public function postSupplier(array $array = []): array|object
    {
        $endpoint = $this->host . '/api/Supplier';
        return $this->exec('POST', $endpoint, $array);
    }

    /**
     * @throws Exception
     */
    public function deleteSupplier(array $array = []): array|object
    {
        if (empty($array['id'])) {
            throw new Exception("Missing 'id' parameter.");
        }
        $endpoint = $this->host . '/api/Supplier/'.$array['id'];
        unset($array['id']);
        return $this->exec('DELETE', $endpoint, $array);
    }
}
