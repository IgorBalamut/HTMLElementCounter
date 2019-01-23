<?php 

require_once 'app/controller/ValidateElement.php';
require_once 'app/model/DBConnection.php';
require_once 'app/model/Domain.php';
require_once 'app/model/Element.php';
require_once 'app/model/Url.php';
require_once 'app/model/Statistic.php';
require_once 'app/model/Request.php';
require_once 'app/config/Config.php';

class ControllerCounter
{
    public $input_url;
    public $input_element;
    public $domain_name;
    public $duration_mls;
    public $request_time;
    public $output_count;

    public $flag_new;

    public $htmlDoc;
    public $info;
    public $dom;

    public $result = array('status' => 'success');
    public $resultError = array('status' => 'error');

    /**
     * Counter whole process   
     * 
     * @return void
     */
    public function Counter()
    {	
        // get input data 
        $this->Request();

        // validate input URL 
        $this->ValidateUrl($this->input_url);    
     
        // validate input element 
        $this->ValidateElement();

        // curl session,validate URL,get HTML document 
        $this->CurlSession();

        // if it's a new request then add to DB
        if($this->flag_new) {

            // get domain name from input URL
            $this->GetDomain();

            // create DOM for HTML document
	        $this->CreateDom();

            // count input elements 
            $this->CountElement();

            // save data into database
            $this->SaveRequestData();
        } else {

           // get previous request data 
           $this->GetRequestData();
        }

        // prepare data for response
        $this->OutputData();

        // get statistic from database
        $this->GetStatisticData();

        // send response to AJAX index.php
        $this->Response();
	}

    /**
     * Get data from AJAX post request   
     * 
     * @return void
     */
    public function Request()
    {
        if(isset($_POST['input_url'])) {
            $this->input_url = $_POST['input_url'];
        } else {
            $this->input_url = '';
        }

        if(isset($_POST['input_element'])) {
            $this->input_element = $_POST['input_element'];
        } else {
            $this->input_element = '';
        }
    }

	/**
     * Get data for test mode    
     * 
     * @return void
     */ 
    public function RequestTest()
    {
        $this->input_url = 'http://google.com';	
        $this->input_element = 'li';
    }

    /**
     * Send response data     
     * 
     * @return void
     */ 
    public function Response()
    {
        echo json_encode($this->result);
        exit();
    }

    /**
     * Send error response message     
     * 
     * @return void
     */ 
    public function ResponseError()
    {
        echo json_encode($this->resultError);
        exit();
    }

    /**
     * Validate Url with Parser      
     * 
     * @return void
     */ 
    public function ValidateUrl($url)
    {
        if (filter_var($url,FILTER_VALIDATE_URL,FILTER_FLAG_HOST_REQUIRED) === False){
            $this->resultError['Error'] = Config::$messages['not_valid_url'];
            $this->ResponseError();
        } else {
            $pars = parse_url($url);
            if($pars['scheme'] !== 'http' and
                $pars['scheme'] !== 'https') {
                $this->resultError['Error'] = Config::$messages['no_http'];
                $this->ResponseError();
            }
        } 
    }

    /**
     * Validate Element using HTTP5 element array      
     * 
     * @return void
     */ 
    public function ValidateElement()
    {
        if(!ValidateElement::do($this->input_element)) {
	        $this->resultError['Error'] = '<' . $this->input_element . '> ' . Config::$messages['not_valid_element']; 
		    $this->ResponseError(); 
        }
    }

    /**
     * Initialization of Curl session. Checking wether URL is a new Url      
     * 
     * @return void
     */  
    public function CurlInit($url)
    {
        // create connection
        $conn = DBConnection::DBConnect();

        if(Request::LastRequestId($conn,$url,$this->input_element) === 0){ 
            // init curl
            $c = curl_init($url);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);

            //current time 
             $this->request_time = date("Y-m-d H:i:s", time());

            // exec curl
            $this->htmlDoc = curl_exec($c); 

            // exit on error
            if (curl_error($c)) {
                $this->resultError['Error'] = curl_error($c) . '. ' . Config::$messages['curl_error'];
                $this->ResponseError();
            }

            // get info 
            $this->info = curl_getinfo($c);

            // close session
           curl_close($c);

        } else {
            $this->flag_new = false;
        }

        // close connection
        $conn->close();
    }

    /**
     * Curl session to get HTML page       
     * 
     * @return void
     */ 
    public function CurlSession()
    {
        // set flag new url 
        $this->flag_new = true;

        // int curl session 
        $this->CurlInit($this->input_url);

        if($this->info['http_code'] === 301)  {
            $this->input_url = $this->info['redirect_url'];
            $this->CurlInit($this->input_url);
        }

        // if new url add proceed with save
        if($this->flag_new) {
            if($this->info['http_code'] === 200) {
                $this->duration_mls = round($this->info['total_time'] * 1000);
            } else {
                $this->resultError['Error'] = 'not correct url, '.'http_code: ' . $this->info['http_code'];
                $this->ResponseError();
            }
        }
    }

    /**
     * Create DOM model for HTML page       
    * 
    * @return void
    */
    public function CreateDom()
    { 
        // create new DOMDocument
        $this->dom = new \DOMDocument('1.0', 'UTF-8');
        // set error level
        $internalErrors = libxml_use_internal_errors(true);
        // load HTML
        $this->dom->loadHTML($this->htmlDoc);
        // Restore error level
        libxml_use_internal_errors($internalErrors);
    }

    /**
     * Get domain name, it removed www tag
     * 
     * @return void
     */
    public function GetDomain()
    {
        $this->domain_name = str_ireplace('www.', '',
        parse_url($this->input_url, PHP_URL_HOST));
    }

 	/**
     * Count elements in DOM 
     * 
     * @return void
     */
    public function CountElement()
    { 
        $this->output_count = 0;
        foreach($this->dom->getElementsByTagName($this->input_element) as $element) {
            $this->output_count++;
        }	
    }
	
    /**
     * Save request data in database 
     * 
     * @return void
     */
    public function SaveRequestData()
    { 
        // create connection
        $conn = DBConnection::DBConnect();

        // store domain, if it is a new domain
        $domain = new Domain($conn);
        $domain->name = $this->domain_name;
        $domain->save();

        // store element, if it is a new element
        $element = new Element($conn);
        $element->name = $this->input_element;
        $element->save();

        // store URL, if it is a new URL
        $url = new Url($conn); 
        $url->name = $this->input_url;
        $url->save();

        // store request
        if($domain->id !== 0 and $element->id !== 0 and $url->id !== 0) {

            $request = new Request($conn);
            
            $request->domain_id = $domain->id;
            $request->element_id = $element->id;
            $request->url_id = $url->id;
            $request->request_time =  $this->request_time;
            $request->duration_mls = $this->duration_mls;
            $request->count_elm = $this->output_count;

            $request->save();

        } else {

            $this->resultError['Error'] = 'System issue';
            $this->ResponseError();	
        }
        // close connection
        $conn->close();
    }

    /**
     * Get results of previuos request 
     * 
     * @return void
     */
    public function GetRequestData()
    {
        // create connection
        $conn = DBConnection::DBConnect();

        // get id of previuos request
        $id = Request::LastRequestId($conn,$this->input_url,$this->input_element);
        // getrequest
        $request = Request::find($conn,$id);

        $this->domain_name = $request->domain_name;
        $this->output_count = $request->count_elm;
        $this->request_time = $request->request_time;
        $this->duration_mls = $request->duration_mls;

        // close connection
        $conn->close();
    }

    /**
     * Prepare output data 
     * 
     * @return void
     */
    public function OutputData()
    {

        $this->result['output_url'] = $this->input_url; 
        $this->result['output_element'] = '<' . $this->input_element . '>' ;
        $this->result['output_domain'] = $this->domain_name;
        $this->result['output_count'] = $this->output_count;
        $this->result['output_time'] = $this->request_time;
        $this->result['output_duration'] = $this->duration_mls;

        if($this->flag_new) {
            $this->result['output_previous'] = '';
        } else {
            $this->result['output_previous'] = 
            Config::$messages['repeated_request'];
            $this->flag_new = true;
        }
    }

    /**
     * Prepare output data 
     * 
     * @return void
     */
    public function GetStatisticData()
    { 
        // create connection
        $conn = DBConnection::DBConnect();

        // find domain and get object  
        $domain = Domain::find($conn,$this->domain_name);

        // count url per domain 
        if(isset($domain)) {
            $this->result['stat_count_url'] = Statistic::CountUrlDomain($conn,$domain->id);
        } else {
            $this->result['stat_count_url'] = '';
        }

        // count average response time per domain
        if(isset($domain)) {
            $this->result['stat_average_time'] = Statistic::AverageTimeDomain($conn,$domain->id);
        } else {
            $this->result['stat_average_time'] = '';
        } 

        // get element object
        $element = Element::find($conn,$this->input_element);

        // count the element per domain
        if(isset($domain) and isset($element)) {
            $this->result['stat_element_domain'] = Statistic::TotalElementDomain($conn,$domain->id,$element->id);
        } else {
            $this->result['stat_element_domain'] = '';
        }

        // conunt total the elements
        if(isset($element)) {
            $this->result['stat_total_element'] = Statistic::TotalCountElement($conn,$element->id);
        } else {
            $this->result['stat_total_element'] = '';
        }

        // close connection
        $conn->close();
    }
}