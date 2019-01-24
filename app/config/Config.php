<?php 

class Config
{ 

    // array of error messages 
    public static $messages = [
	    'repeated_request' => 'The same request was made less than 5 minutes ago. The previous response results are shown.',
        'no_http' => 'Http scheme is not valid. Please enter http or https.',
        'not_valid_url' => 'Not a valid URL format. Please enter proper url.',
        'not_valid_element' => 'HTML element is not valid. Please enter proper HTML element',
         'curl_error' => 'Please enter another URL or try later.',
         'http_error' => 'Please enter another URL or try later.',
         'dom_error' => 'Issue with HTML page. Please enter another URL or try later',
         'db_error' => 'The service is unavailble. Please contact Site Administrator.',
	];

    // array of parameters 
    public static $params = [
        'standard_html5' => true,
    ];
}