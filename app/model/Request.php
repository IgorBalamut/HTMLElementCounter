<?php 
class Request { 
	private $_conn;

	public $id;
	public $url_id;
	public $domain_id;
	public $element_id;
	public $request_time;
	public $duration_mls;
	public $count_elm;

	public $url_name;
	public $domain_name;
	public $element_name;

	public function __construct($conn) {
		$this->_conn = $conn;
	}

	public static function All($conn) {
		$sql = "SELECT id,url_id,domain_id,element_id,request_time,duration_mls,count_elm FROM tbRequest";
		$result = $conn->query($sql);
		return $result;
	}

	public static function LastRequestId($conn,$url_name,$element_name) {

		$sql = sprintf("
			SELECT MAX( tbRequest.id ) 
			FROM tbRequest
			JOIN tbUrl url ON url_id = url.id
			JOIN tbElement elm ON element_id = elm.id
			WHERE url.name = ? AND elm.name = ?
			AND request_time > DATE_SUB( NOW( ),INTERVAL 5 MINUTE)
			");
		
		// prepare and bind
		$stmt = $conn->prepare($sql);

		$stmt->bind_param("ss", $url_name,$element_name);
		$stmt->execute();

		if (!$stmt->execute()) {
			exit($stmt->error);
	    } else {
   			$stmt->bind_result($id);
    		$stmt->fetch();
	    }
	    
		$stmt->close();

    	return $id === null ? 0 : $id;

	}

	// find request by id, return object 
	public static function find($conn,$id) {

		$sql = sprintf(
		"select r.id,url_id,domain_id,element_id,request_time,duration_mls,count_elm, 
		u.name as url_name,
		d.name as domain_name,
		e.name as element_name 
		from tbRequest r 
		join tbUrl u on url_id = u.id
		join tbDomain d on domain_id = d.id
		join tbElement e on element_id = e.id
		where r.id = ?"
		);

		// prepare and bind
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("i",$id);
		$stmt->execute();

		if (!$stmt->execute()) {
			exit($stmt->error);
	    } else {
   			$stmt->bind_result($id,$url_id,$domain_id,
   				$element_id,$request_time,$duration_mls,$count_elm,$url_name,$domain_name,$element_name);
    		$stmt->fetch();

    		if(isset($id)) {
	    		$request = new Request($conn);
	    		$request->id = $id;
	    		$request->url_id = $url_id;
	    		$request->domain_id = $domain_id;
  				$request->element_id = $element_id;
  				$request->request_time = $request_time;
  				$request->duration_mls = $duration_mls;
 				$request->count_elm = $count_elm; 
 				$request->url_name = $url_name;
 				$request->domain_name = $domain_name;
 				$request->element_name = $element_name;  
	    	} else {
	    		$request = null;
	    	}
	    }
	    return $request;

	}

	//insert a new request 
	public function save() {

	     	// prepare and bind
			$stmt = $this->_conn->prepare(sprintf("INSERT INTO tbRequest(url_id,domain_id,element_id,request_time,duration_mls,count_elm) VALUES (?,?,?,?,?,?)"));
			$stmt->bind_param("iiisii", $url_id,$domain_id,$element_id,$request_time,$duration_mls,$count_elm);
			$url_id = $this->url_id;
			$domain_id = $this->domain_id;
			$element_id = $this->element_id;
			$request_time = $this->request_time;
			$duration_mls = $this->duration_mls;
			$count_elm = $this->count_elm;

			if (!$stmt->execute()) {
				exit($stmt->error);
	    	}
	    	$stmt->close();
	}
}