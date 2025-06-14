<?php

namespace DerrickSmith\HaloApi;

use Derricksmith\Haloapi\Traits\Actions;
use DerrickSmith\HaloApi\Traits\Agents;
use DerrickSmith\HaloApi\Traits\Appointments;
use DerrickSmith\HaloApi\Traits\Assets;
use DerrickSmith\HaloApi\Traits\Attachments;
use DerrickSmith\HaloApi\Traits\Clients;
use DerrickSmith\HaloApi\Traits\Contacts;
use DerrickSmith\HaloApi\Traits\Invoices;
use DerrickSmith\HaloApi\Traits\Items;
use DerrickSmith\HaloApi\Traits\KbArticles;
use DerrickSmith\HaloApi\Traits\Opportunities;
use DerrickSmith\HaloApi\Traits\Projects;
use DerrickSmith\HaloApi\Traits\Quotes;
use DerrickSmith\HaloApi\Traits\Reports;
use DerrickSmith\HaloApi\Traits\Sites;
use DerrickSmith\HaloApi\Traits\Statuses;
use DerrickSmith\HaloApi\Traits\Suppliers;
use DerrickSmith\HaloApi\Traits\Teams;
use DerrickSmith\HaloApi\Traits\Tickets;
use DerrickSmith\HaloApi\Traits\TicketTypes;
use DerrickSmith\HaloApi\Traits\Users;
use Exception;

/**
* HaloApi
*
* HaloApi is a PHP Wrapper for the HaloITSM API. This class supports all endpoints and methods available in the API.
*
* Example class usage:
*     $haloApi = new HaloApi(array
*        'client_id' => '<your client id>',
*        'client_secret' => '<your client secret>',
*        'grant_type' => '<your grant type>',
*        'scope' => '<your scope>',
*        'host' => '<your Halo ITSM base URL>',
*        'verifypeer' => true
*    );
*
*    $haloApi->getTickets($params);
*
* @package HaloApi
* @author Derrick Smith
* @version $Revision: 1.0 $
* @access public
* @see http://www.github.com/derricksmith/haloapi
*/

class HaloApi
{
    use Actions;
    use Agents;
    use Appointments;
    use Assets;
    use Attachments;
    use Clients;
    use Contacts;
    use Invoices;
    use Items;
    use KbArticles;
    use Opportunities;
    use Projects;
    use Quotes;
    use Reports;
    use Sites;
    use Statuses;
    use Suppliers;
    use Teams;
    use TicketTypes;
    use Tickets;
    use Users;

    private $grant_type;

    private $client_id;

    private $client_secret;

    private $scope;

    private $host;

    private $verifypeer;

    private $token_type;

    private $expires_in;

    private $access_token;

    private $refresh_token;

    public $last_result;

    public bool $return_object = false;

    /**
    * Instantiates the class. Retrieves the access token and stores as $access_token class variable.
    *
    * @param array $params
    *
    * @return null
    * @access public
    */
    public function __construct(...$params)
    {
        $params = func_get_args();

        if (!empty($params)) {
            foreach ($params[0] as $key => $property) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $property;
                }
            }
        }

        $result = $this->initSession();

        $this->access_token = ($this->return_object ? $result : $result['data'])->access_token;
        $this->refresh_token = ($this->return_object ? $result : $result['data'])->refresh_token;
        $this->expires_in = ($this->return_object ? $result : $result['data'])->expires_in;
        $this->token_type = ($this->return_object ? $result : $result['data'])->token_type;
        $this->last_result = $result;
    }


    /**
     * Executes the http call using Curl.  Accepts GET, POST, DELETE
     *
     * @param string $method
     * @param string $endpoint
     * @param array $array
     *
     * @return null
     * @access private
     * @throws Exception
     */
    private function exec(string $method, string $endpoint, array $array = []): array|object
    {
        $curl = curl_init();

        $headers = array(
            ($endpoint !== $this->host . '/auth/token' ? 'Authorization: Bearer '.$this->access_token : null)
        );

        switch ($method) {
            case 'GET':
                if (!empty($array)) {
                    $endpoint .= "?".http_build_query($array);
                }
                break;

            case 'POST':
                if (!empty($array)) {
                    curl_setopt($curl, CURLOPT_POST, true);
                    if ($endpoint == $this->host . '/auth/token') {
                        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
                        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($array));
                    } else {
                        $headers[] = 'Content-Type: application/json';
                        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($array));
                    }
                }
                break;

            case 'PUT':
            case 'DELETE':
            default:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($method)); // method
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($array)); // body
        }

        if ($endpoint !== $this->host . '/auth/token' && $this->access_token == '') {
            throw new Exception("Failed: No Session Token");
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_PORT, 443);

        if ($this->verifypeer === false || $this->verifypeer === 0) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        } else {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        }
        // Exec
        $response = curl_exec($curl);

        $info = curl_getinfo($curl);

        curl_close($curl);

        // Data
        $header = trim(substr($response, 0, $info['header_size']));
        $body = substr($response, $info['header_size']);
        $this->last_result = json_decode($body);

        if ($this->return_object) {
            return $this->last_result;
        }

        return [
            'status' => $info['http_code'],
            'header' => $header,
            'data' => $this->last_result,
        ];
    }

    /**
     * Retrieves the authentication token
     *
     * @return array
     * @access private
     * @throws
    */
    private function initSession(): array|object
    {
        $endpoint = $this->host . '/auth/token';
        $array = array(
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'grant_type' => $this->grant_type,
            'scope' => $this->scope
        );
        return $this->exec('POST', $endpoint, $array);
    }
}
