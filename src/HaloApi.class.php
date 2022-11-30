<?php

namespace DerrickSmith\HaloApi;

/** 
* HaloApi
* 
* HaloApi is a PHP Wrapper for the HaloITSM API. This class supports all endpoints and methods available in the API.
* 
* Example class usage: 
* 	$haloApi = new HaloApi(array
*		'client_id' => '<your client id>', 
*		'client_secret' => '<your client secret>', 
*		'grant_type' => '<your grant type>',
*		'scope' => '<your scope>',
*		'host' => '<your Halo ITSM base URL>', 
*		'verifypeer' => true
*	);
*
*	$haloApi->getTickets($params);
*
*
*
* 
* @package HaloApi 
* @author Derrick Smith
* @version $Revision: 1.0 $ 
* @access public 
* @see http://www.github.com/derricksmith/haloapi
*/

class HaloApi {
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

	/** 
	* __construct
	*
	* Instanciates the class.  Retreives the access token and stores as $access_token class variable.
	* 
	* @param array
	*
	* @return null
	* @access public 
	*/
	public function __construct($params) {
		$params = func_get_args();

        if(!empty($params)){
            foreach($params[0] as $key => $property) {
				if(property_exists($this, $key)) {
                    $this->{$key} = $property;
				}
			}
		}
		
		$result = $this->initSession();
		
		$this->access_token = $result['data']->access_token;
		$this->refresh_token = $result['data']->refresh_token;
		$this->expires_in = $result['data']->expires_in;
		$this->token_type = $result['data']->token_type;
		$this->last_result = $result;
	}

    
	/** 
	* exec
	*
	* Executes the http call using Curl.  Accepts GET, POST, DELETE
	* 
	* @param string $method
	* @param string $endpoint
	* @param array 	$array
	*
	* @return null
	* @access private
	*/
    private function exec($method, $endpoint, $array = array()) {
        $curl = curl_init();
		
		$headers = array(
			($endpoint !== $this->host . '/auth/token' ? 'Authorization: Bearer '.$this->access_token : null)
		);

        switch($method) {
            case 'GET':
                if(!empty($array)) {
                    $endpoint .= "?".http_build_query($array);
                }
                break;

            case 'POST':
				if(!empty($array)) {
					curl_setopt($curl, CURLOPT_POST, TRUE);
					if ($endpoint == $this->host . '/auth/token'){
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

        if($endpoint !== $this->host . '/auth/token' && $this->access_token == ''){
            throw new Exception("Failed: No Session Token");
			return false;
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_HEADER, TRUE);
		curl_setopt($curl, CURLOPT_PORT , 443);

        if ($this->verifypeer === FALSE || $this->verifypeer == 0){
		    curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		    curl_setopt ($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        } else {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
        }
        // Exec
        $response = curl_exec($curl);
		
		if ($endpoint !== $this->host . '/auth/token'){
			echo $endpoint;
			echo "\n";
			print_r($response);
		}
		
        $info = curl_getinfo($curl);
		
        curl_close($curl);

        // Data
        $header = trim(substr($response, 0, $info['header_size']));
        $body = substr($response, $info['header_size']);
		$this->last_result = json_decode($body);
		
        return array('status' => $info['http_code'], 'header' => $header, 'data' => json_decode($body));
    }
	
	/** 
	* initSession
	*
	* Retrieves the authentication token
	*
	* @return array
	* @access private
	*/
	private function initSession() {
		$endpoint = $this->host . '/auth/token';
		$array = array(
			'client_id' => $this->client_id,
			'client_secret' => $this->client_secret,
			'grant_type' => $this->grant_type,
			'scope' => $this->scope
		);
        return $this->exec('POST', $endpoint, $array);
	}
	
	
	//////////////////////////////////////////////////////////////////////////////////////
	// Actions
	//////////////////////////////////////////////////////////////////////////////////////
	
	public function getActions($array = array()) {
		$endpoint = $this->host . '/api/actions';
        return $this->exec('GET',$endpoint, $array);
	}
	
	public function getAction($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/actions';
        return $this->exec('GET',$endpoint, $array);
	}
	
	public function postActions($array = array()) {
		$endpoint = $this->host . '/api/actions';
		return $this->exec('POST',$endpoint, $array);
	}
	
	public function deleteActions($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/actions/'.$array['id'];
        unset($array['id']);
		return $this->exec('DELETE',$endpoint, $array);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////
	// Agents
	//////////////////////////////////////////////////////////////////////////////////////
	
	public function getAgents($array = array()) {
		$endpoint = $this->host . '/api/Agent';
        return $this->exec('GET',$endpoint, $array);
	}
	
	public function getAgent($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Agent/'.$array['id'];
        unset($array['id']);
		return $this->exec('GET',$endpoint, $array);
	}
	
	public function getAgentSelf() {
		$endpoint = $this->host . '/api/Agent/me';
        return $this->exec('GET',$endpoint, $array);
	}
	
	public function postAgent($array = array()) {
		$endpoint = $this->host . '/api/Agent';
		return $this->exec('POST',$endpoint, $array);
	}
	
	public function deleteAgent($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Agent/'.$array['id'];
        unset($array['id']);
		return $this->exec('DELETE',$endpoint, $array);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////
	// Appointments
	//////////////////////////////////////////////////////////////////////////////////////
	
	public function getAppointments($array = array()) {
		$endpoint = $this->host . '/api/Appointment';
        return $this->exec('GET',$endpoint, $array);
	}
	
	public function getAppointment($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Appointment/'.$array['id'];
        unset($array['id']);
		return $this->exec('GET',$endpoint, $array);
	}
	
	public function postAppointment($array = array()) {
		$endpoint = $this->host . '/api/Appointment';
		return $this->exec('POST',$endpoint, $array);
	}
	
	public function deleteAppointment($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Appointment/'.$array['id'];
        unset($array['id']);
		return $this->exec('DELETE',$endpoint, $array);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////
	// Assets
	//////////////////////////////////////////////////////////////////////////////////////
	
	public function getAssets($array = array()) {
		$endpoint = $this->host . '/api/Asset';
        return $this->exec('GET',$endpoint, $array);
	}
	
	public function getAsset($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Asset/'.$array['id'];
        unset($array['id']);
		return $this->exec('GET',$endpoint, $array);
	}
	
	public function postAsset($array = array()) {
		$endpoint = $this->host . '/api/Asset';
		return $this->exec('POST',$endpoint, $array);
	}
	
	public function deleteAsset($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Asset/'.$array['id'];
        unset($array['id']);
		return $this->exec('DELETE',$endpoint, $array);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////
	// Attachments
	//////////////////////////////////////////////////////////////////////////////////////
	
	public function getAttachments($array = array()) {
		$endpoint = $this->host . '/api/Attachment';
        return $this->exec('GET',$endpoint, $array);
	}
	
	public function getAttachment($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Attachment/'.$array['id'];
        unset($array['id']);
		return $this->exec('GET',$endpoint, $array);
	}
	
	public function postAttachment($array = array()) {
		$endpoint = $this->host . '/api/Attachment';
		return $this->exec('POST',$endpoint, $array);
	}
	
	public function deleteAttachment($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Attachment/'.$array['id'];
        unset($array['id']);
		return $this->exec('DELETE',$endpoint, $array);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////
	// Clients
	//////////////////////////////////////////////////////////////////////////////////////
	
	public function getClients($array = array()) {
		$endpoint = $this->host . '/api/Client';
        return $this->exec('GET',$endpoint, $array);
	}
	
	public function getClient($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Client/'.$array['id'];
        unset($array['id']);
		return $this->exec('GET',$endpoint, $array);
	}
	
	public function postClient($array = array()) {
		$endpoint = $this->host . '/api/Client';
		return $this->exec('POST',$endpoint, $array);
	}
	
	public function deleteClient($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Client/'.$array['id'];
        unset($array['id']);
		return $this->exec('DELETE',$endpoint, $array);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////
	// Contacts
	//////////////////////////////////////////////////////////////////////////////////////
	
	public function getContracts($array = array()) {
		$endpoint = $this->host . '/api/Contract';
        return $this->exec('GET',$endpoint, $array);
	}
	
	public function getContract($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Contract/'.$array['id'];
        unset($array['id']);
		return $this->exec('GET',$endpoint, $array);
	}
	
	public function postContract($array = array()) {
		$endpoint = $this->host . '/api/Contract';
		return $this->exec('POST',$endpoint, $array);
	}
	
	public function deleteContract($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Contract/'.$array['id'];
        unset($array['id']);
		return $this->exec('DELETE',$endpoint, $array);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////
	// Invoices
	//////////////////////////////////////////////////////////////////////////////////////
	
	public function getInvoices($array = array()) {
		$endpoint = $this->host . '/api/Contract';
        return $this->exec('GET',$endpoint, $array);
	}
	
	public function getInvoice($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Invoice/'.$array['id'];
        unset($array['id']);
		return $this->exec('GET',$endpoint, $array);
	}
	
	public function postInvoice($array = array()) {
		$endpoint = $this->host . '/api/Invoice';
		return $this->exec('POST',$endpoint, $array);
	}
	
	public function deleteInvoice($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Invoice/'.$array['id'];
        unset($array['id']);
		return $this->exec('DELETE',$endpoint, $array);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////
	// Items
	//////////////////////////////////////////////////////////////////////////////////////
	
	public function getItems($array = array()) {
		$endpoint = $this->host . '/api/Item';
        return $this->exec('GET',$endpoint, $array);
	}
	
	public function getItem($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Item/'.$array['id'];
        unset($array['id']);
		return $this->exec('GET',$endpoint, $array);
	}
	
	public function postItem($array = array()) {
		$endpoint = $this->host . '/api/Item';
		return $this->exec('POST',$endpoint, $array);
	}
	
	public function deleteItem($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Item/'.$array['id'];
        unset($array['id']);
		return $this->exec('DELETE',$endpoint, $array);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////
	// KB Articles
	//////////////////////////////////////////////////////////////////////////////////////
	
	public function getKbArticles($array = array()) {
		$endpoint = $this->host . '/api/KBArticle';
        return $this->exec('GET',$endpoint, $array);
	}
	
	public function getKbArticle($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/KBArticle/'.$array['id'];
        unset($array['id']);
		return $this->exec('GET',$endpoint, $array);
	}
	
	public function postKbArticle($array = array()) {
		$endpoint = $this->host . '/api/KBArticle';
		return $this->exec('POST',$endpoint, $array);
	}
	
	public function deleteKbArticle($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/KBArticle/'.$array['id'];
        unset($array['id']);
		return $this->exec('DELETE',$endpoint, $array);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////
	// Opportunities
	//////////////////////////////////////////////////////////////////////////////////////
	
	public function getOpportunities($array = array()) {
		$endpoint = $this->host . '/api/Opportunities';
        return $this->exec('GET',$endpoint, $array);
	}
	
	public function getOpportunity($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Opportunities/'.$array['id'];
        unset($array['id']);
		return $this->exec('GET',$endpoint, $array);
	}
	
	public function postOpportunity($array = array()) {
		$endpoint = $this->host . '/api/Opportunities';
		return $this->exec('POST',$endpoint, $array);
	}
	
	public function deleteOpportunity($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Opportunities/'.$array['id'];
        unset($array['id']);
		return $this->exec('DELETE',$endpoint, $array);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////
	// Projects
	//////////////////////////////////////////////////////////////////////////////////////
	
	public function getProjects($array = array()) {
		$endpoint = $this->host . '/api/Projects';
        return $this->exec('GET',$endpoint, $array);
	}
	
	public function getProject($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Projects/'.$array['id'];
        unset($array['id']);
		return $this->exec('GET',$endpoint, $array);
	}
	
	public function postProject($array = array()) {
		$endpoint = $this->host . '/api/Projects';
		return $this->exec('POST',$endpoint, $array);
	}
	
	public function deleteProject($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Projects/'.$array['id'];
        unset($array['id']);
		return $this->exec('DELETE',$endpoint, $array);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////
	// Quotes
	//////////////////////////////////////////////////////////////////////////////////////
	
	public function getQuotes($array = array()) {
		$endpoint = $this->host . '/api/Quotation';
        return $this->exec('GET',$endpoint, $array);
	}
	
	public function getQuote($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Quotation/'.$array['id'];
        unset($array['id']);
		return $this->exec('GET',$endpoint, $array);
	}
	
	public function postQuote($array = array()) {
		$endpoint = $this->host . '/api/Quotation';
		return $this->exec('POST',$endpoint, $array);
	}
	
	public function deleteQuote($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Quotation/'.$array['id'];
        unset($array['id']);
		return $this->exec('DELETE',$endpoint, $array);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////
	// Reports
	//////////////////////////////////////////////////////////////////////////////////////
	
	public function getReports($array = array()) {
		$endpoint = $this->host . '/api/Report';
        return $this->exec('GET',$endpoint, $array);
	}
	
	public function getReport($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Report/'.$array['id'];
        unset($array['id']);
		return $this->exec('GET',$endpoint, $array);
	}
	
	public function postReport($array = array()) {
		$endpoint = $this->host . '/api/Report';
		return $this->exec('POST',$endpoint, $array);
	}
	
	public function deleteReport($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Report/'.$array['id'];
        unset($array['id']);
		return $this->exec('DELETE',$endpoint, $array);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////
	// Sites
	//////////////////////////////////////////////////////////////////////////////////////
	
	public function getSites($array = array()) {
		$endpoint = $this->host . '/api/Site';
        return $this->exec('GET',$endpoint, $array);
	}
	
	public function getSite($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Site/'.$array['id'];
        unset($array['id']);
		return $this->exec('GET',$endpoint, $array);
	}
	
	public function postSite($array = array()) {
		$endpoint = $this->host . '/api/Site';
		return $this->exec('POST',$endpoint, $array);
	}
	
	public function deleteSite($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Site/'.$array['id'];
        unset($array['id']);
		return $this->exec('DELETE',$endpoint, $array);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////
	// Statusus
	//////////////////////////////////////////////////////////////////////////////////////
	
	public function getStatuses($array = array()) {
		$endpoint = $this->host . '/api/Status';
        return $this->exec('GET',$endpoint, $array);
	}
	
	public function getStatus($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Status/'.$array['id'];
        unset($array['id']);
		return $this->exec('GET',$endpoint, $array);
	}
	
	public function postStatus($array = array()) {
		$endpoint = $this->host . '/api/Status';
		return $this->exec('POST',$endpoint, $array);
	}
	
	public function deleteStatus($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Status/'.$array['id'];
        unset($array['id']);
		return $this->exec('DELETE',$endpoint, $array);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////
	// Suppliers
	//////////////////////////////////////////////////////////////////////////////////////
	
	public function getSuppliers($array = array()) {
		$endpoint = $this->host . '/api/Supplier';
        return $this->exec('GET',$endpoint, $array);
	}
	
	public function getSupplier($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Supplier/'.$array['id'];
        unset($array['id']);
		return $this->exec('GET',$endpoint, $array);
	}
	
	public function postSupplier($array = array()) {
		$endpoint = $this->host . '/api/Supplier';
		return $this->exec('POST',$endpoint, $array);
	}
	
	public function deleteSupplier($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Supplier/'.$array['id'];
        unset($array['id']);
		return $this->exec('DELETE',$endpoint, $array);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////
	// Teams
	//////////////////////////////////////////////////////////////////////////////////////
	
	public function getTeams($array = array()) {
		$endpoint = $this->host . '/api/Team';
        return $this->exec('GET',$endpoint, $array);
	}
	
	public function getTeam($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Team/'.$array['id'];
        unset($array['id']);
		return $this->exec('GET',$endpoint, $array);
	}
	
	public function postTeam($array = array()) {
		$endpoint = $this->host . '/api/Team';
		return $this->exec('POST',$endpoint, $array);
	}
	
	public function deleteTeam($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Team/'.$array['id'];
        unset($array['id']);
		return $this->exec('DELETE',$endpoint, $array);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////
	// Types
	//////////////////////////////////////////////////////////////////////////////////////
	
	public function getTicketTypes($array = array()) {
		$endpoint = $this->host . '/api/TicketType';
        return $this->exec('GET',$endpoint, $array);
	}
	
	public function getTicketType($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/TicketType/'.$array['id'];
        unset($array['id']);
		return $this->exec('GET',$endpoint, $array);
	}
	
	public function postTicketType($array = array()) {
		$endpoint = $this->host . '/api/TicketType';
		return $this->exec('POST',$endpoint, $array);
	}
	
	public function deleteTicketType($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/TicketType/'.$array['id'];
        unset($array['id']);
		return $this->exec('DELETE',$endpoint, $array);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////
	// Tickets
	//////////////////////////////////////////////////////////////////////////////////////
	
	public function getTickets($array = array()) {
		$endpoint = $this->host . '/api/Tickets';
        return $this->exec('GET',$endpoint, $array);
	}
	
	public function getTicket($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Tickets/'.$array['id'];
        unset($array['id']);
		return $this->exec('GET',$endpoint, $array);
	}
	
	public function postTicket($array = array()) {
		$endpoint = $this->host . '/api/Tickets';
		return $this->exec('POST',$endpoint, $array);
	}
	
	public function deleteTicket($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Tickets/'.$array['id'];
        unset($array['id']);
		return $this->exec('DELETE',$endpoint, $array);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////
	// Users
	//////////////////////////////////////////////////////////////////////////////////////
	
	public function getUsers($array = array()) {
		$endpoint = $this->host . '/api/Users';
        return $this->exec('GET',$endpoint, $array);
	}
	
	public function getUser($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Users/'.$array['id'];
        unset($array['id']);
		return $this->exec('GET',$endpoint, $array);
	}
	
	public function postUser($array = array()) {
		$endpoint = $this->host . '/api/Users';
		return $this->exec('POST',$endpoint, $array);
	}
	
	public function deleteUser($array = array()) {
		if(!isset($array['id']) || empty($array['id'])){
			throw new Exception("Missing 'id' parameter.");
			return false;
		}
		$endpoint = $this->host . '/api/Users/'.$array['id'];
        unset($array['id']);
		return $this->exec('DELETE',$endpoint, $array);
	}
}

