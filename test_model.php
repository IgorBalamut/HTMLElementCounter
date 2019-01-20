<?php

require_once 'app/model/DBConnection.php';
require_once 'app/model/Domain.php';
require_once 'app/model/Element.php';
require_once 'app/model/Url.php';
require_once 'app/model/Request.php';
require_once 'app/model/Statistic.php'; 

// create connection
$conn = DBConnection::DBConnect();


// pars URL
var_dump(parse_url('http://php.net/manual/en/function.parse-url.php'));


// preg_replace('/\s+/', ' ', $sql);
// echo $sql;

// new domain
$domain = new Domain($conn);

$domain->id = 1;
$domain->name = 'test_new16.com';
$domain->save();

$domain_id = $domain->findId($conn,$domain->name);


echo '<br/>';
echo 'domain id: ' . $domain_id;
echo '<br/>';

$domain1 = Domain::find($conn,'apple.com');

if($domain1 === null) {
  echo '<br/>';
  echo 'domain1 is NULL';  
  echo '<br/><br/>';
}

if(isset($domain1)) {
echo '<br/>';
echo 'domain1: ' . $domain1->id . ' ' . $domain1->name; 
echo '<br/><br/>';
}


$result = Domain::All($conn);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " Name: " . $row["name"]. "<br>";
    }
} else {
    echo "0 results";
}

////////////////////////////////
// new Element
$element = new Element($conn);

$element->name = 'tab';
$element->save();

$element_id = $element->findId($conn,$element->name);

echo '<br>';
echo 'element id: ' . $element_id;
echo '<br>';

$element1 = Element::find($conn,'head');

if($element1 === null) {
  echo '<br/>';
  echo '$element1 is NULL';  
  echo '<br/><br/>';
}

if(isset($domain1)) {
echo '<br/>';
echo 'element1: ' . $element1->id . ' ' . $element1->name; 
echo '<br/><br/>';
}


$result = Element::All($conn);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " Name: " . $row["name"]. "<br>";
    }
} else {
    echo "0 results";
}


// new Url
$url = new Url($conn);

$url->name = 'http://localhost/project/test_model111.php';
$url->save();

$url_id = $url->findId($conn,$url->name);

echo '<br>';
echo 'url id: ' . $url_id;
echo '<br>';


$url1 = Url::find($conn,$url->name);

if($url1 === null) {
  echo '<br/>';
  echo '$url1 is NULL';  
  echo '<br/><br/>';
}

if(isset($url1)) {
echo '<br/>';
echo 'url1: ' . $url1->id . ' ' . $url1->name; 
echo '<br/><br/>';
}



$result = Url::All($conn);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " Name: " . $row["name"]. "<br>";
    }
} else {
    echo "0 results";
}


/////////
// new request
$request = new Request($conn);

$request->url_id = 16;
$request->domain_id = 1;
$request->element_id = 2;
$request->request_time =  date("Y-m-d H:i:s", time());
$request->duration_mls = 12;
$request->count_elm = 57;

$request->save();

$result = Request::All($conn);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: ".$row["id"]." "
           ."url_id: ".$row["url_id"]." "
           ."domain_id: ".$row["domain_id"]." "
           ."element_id: ".$row["element_id"]." "
           ."request_time: ".$row["request_time"]." "
           ."duration_mls: ".$row["duration_mls"]." "
            ."count_elm: ".$row["count_elm"]
           ."<br>";
    }
} else {
    echo "0 results";
}

//// Reports 

///// CountUrlDomain
$id = 1;
$count = Statistic::CountUrlDomain($conn,$id);

echo 'Count of Url on Domain ' . $count . '<br>';

///// Count Average Time 
$id = 1;
$count = Statistic::AverageTimeDomain($conn,$id);

echo 'Average Time Domain ' . $count . '<br>';

//// TotalElementDomain
$domain_id = 1;
$element_id = 1;
$count = Statistic::TotalElementDomain($conn,$domain_id,$element_id);

echo 'Total Element for Domain ' . $count . '<br>';

/////////

/// TotalCountElement
$element_id = 1;
$count = Statistic::TotalCountElement($conn,$element_id);

echo 'Total Count Element for All requests ' . $count . '<br>';

/// 
$url_name = "http://localhost/project/test_model111.php";
$elm_name = 'li'; 
$id = Request::LastRequestId($conn,$url_name,$elm_name);

echo 'Last request ID' . $id . '<br>';

$request = Request::find($conn,$id);

var_dump($request);

// close connection
$conn->close();
