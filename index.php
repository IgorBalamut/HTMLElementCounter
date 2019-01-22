<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">

	<title>HTML Element Counter</title>
	<meta name="description" content="Project">
	<meta name="author" content="Igor B">

	<link rel="shortcut icon" type="image/x-icon" href="images/html5.png">
	<!-- Google Fonts  -->
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<!-- <link href="https://fonts.googleapis.com/css?family=Roboto:500" rel="stylesheet"> -->
	<!-- Fonts Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

	<link rel="stylesheet" href="css/styles.css"> 

</head>

<body>
<!-- modal -->
<div id="modal" class="modal">
	<div class="modal-content">
		<div class="modal-header">
			<span class="close-btn">&times;</span>
			<h3>Warning Message</h3>
		</div>
		<div class="modal-body">
			<p id="modal-text">It is a modal</p>
		</div>
		<div class="modal-footer">
			
		</div>
	</div>
</div>
<!-- end of modal -->

<!-- nav -->
<nav>
	<ul>
		<li>
			<a href="#" class="logo">
				<i class="fab fa-html5 i1"></i>
				HTML Element Counter
				<i class="fab fa-html5 i2"></i>
			</a>
		</li>
		<li class="item">
			<a href="#">Home</a>
		</li>
		<li class="item">
			<a href="#counter">Service</a>
		</li>
		<li class="item">
			<a href="#about">About</a>
		</li>
	</ul>

</nav>
<!-- end of nav -->

<!-- banner -->
<header id="banner">
	<div class="banner-title">
		<div class="banner-text">Element Counter</div>
		<div class="banner-underline"></div>
		<div class="banner-btn">
			<a href="#counter" type="button">Start now</a>
		</div>
	</div>
</header>
<!-- end of banner -->

<!-- counter section -->
<section id="counter">
	<div class="counter-container">
		<h1 class="counter-title">Input your data</h1>
		<form id="input_form" method="post" action="counter.php">
		 	URL should start from http:// or https://, maximum 255 characters
		  	<input type="text" name="input_url" 
			placeholder="Enter web page URL"
		  	required pattern="^(http|https):\/\/(.*)" maxlength="255">
		 	Element should be valid HTML5 element, maximum 10 characters
			<input type="text" name="input_element" 
			placeholder="Enter HTML element"
			required pattern="^[a-zA-Z]+$" maxlength="10">
		  	<input type="submit" value="Submit Request">
		  	
	</form> 
	</div>
</section>

<section id="result">
	<div class="result-container">
		<div class="result-title">Request results</div>

	<div class="result-text">
	<p>URL  <span class="output_url correct"></span> fetched on <span class="output_time correct"></span>, took <span class="output_period"></span> msec.</p>
    <p>Element <span class="output_element"></span> appeared <span class="output_count"></span> times in the page.</p>
	 </div>	

    <div class="result-title">General Statistics</div>

    <div class="result-text">
    <p><span class="stat_count_url"></span> different URLs from <span class="output_domain"></span> have been fetched.</p>
    <p>Average fetch time from <span class="output_domain"></span> during the last 24 hours hours is <span class="stat_average_time"></span> msec.</p>
    <p>There was a total of <span class="stat_element_domain"></span> <span class="output_element"></span> elements from <span class="output_domain"></span>.</p>
    <p>Total of <span class="stat_total_element"></span> <span class="output_element"></span> elements counted in all requests ever made.</p>
    </div>

</div>
</div>
</section>
<!-- end of counter section -->

<!-- about section -->
<section id="about">
	<div class="about-container">
		<div class="about-title">About the HTML Element Counter
		</div>
		<div class="about-text">
		<p>Element HTML Counter allows to count HTML tags on web page. The following points should be considered:</p>
		<ul>
		<li>URL should be entered with ‘http’ or ‘https’ scheme part.</li>
		<li>Element should be standard HTML5 tags.</li>
		<li>Only valid URLs from Curl response are saved.</li>
		<li>Original URLs are saved for statistic.</li>
		<li>If original URLs are similar, and differs only http/https parts, they considered as different items anyway, though can return the same HTML page.</li>
		</ul>
		</div>
</section>	
<!-- end of about section -->

<!-- footer -->
<footer id="footer">
<p>2019 &copy; HTML Element Counter</p>
</footer>
<!-- end of footer -->
<!-- jQuery Core 3.3.1 -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous">
 </script>
 
<script src="js/scripts.js"></script>

</body>
</html>