<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">

	<title>HTML Element Counter</title>
	<meta name="description" content="Project">
	<meta name="author" content="Igor B">

	<!-- Google Fonts  -->
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<!-- <link href="https://fonts.googleapis.com/css?family=Roboto:500" rel="stylesheet"> -->
	<!-- Fonts Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

	<link rel="stylesheet" href="css/styles.css"> 

</head>

<body>

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
		<div class="counter-text">Input your data</div>
		<form id="input_form" method="post" action="counter.php">
		 	URL (it should start from http:// or https://, max 255 characters):
		 	<br>
		  	<input type="text" name="input_url" value="https://www.google.com" required pattern="^(http|https):\/\/(.*)" maxlength="255">
		  	<br>
		 	Element (it should be valid HTML5 tag, max 10 characters):
		 	<br>
			<input type="text" name="input_element" value="a" required pattern="^[a-zA-Z]+$" maxlength="10">
		  	<br><br>
		  	<input type="submit" value="Submit">
	</form> 
	</div>
</section>

<section id="result">
	<div class="result-container">
		<div class="result-title">Request results</div>

	<div class="result-text">
	<p>URL  <span class="output_url">__</span> fetched on <span class="output_time">__</span>, took <span class="output_period">__</span> msec.</p>
    <p>Element <<span class="output_element">__</span>> appeared <span class="output_count">__</span> times in page.</p>
	</div>
    <br/>
    <div class="result-title">General Statistics</div>

    <p><span class="stat_count_url">__</span> different URLs from <span class="output_domain">__</span> have been fetched.</p>
    <p>Average fetch time from <span class="output_domain">__</span> during the last 24 hours hours is <span class="stat_average_time">__</span> msec.</p>
    <p>There was a total of <span class="stat_element_domain">__</span> <<span class="output_element">__</span>> elements from <span class="output_domain">__</span>.</p>
    <p>Total of <span class="stat_total_element">__</span> <<span class="output_element">__</span>> elements counted in all requests ever made.</p>

</div>
</div>
</section>
<!-- end of counter section -->

<!-- about section -->
<section id="about">
	<div class="about-container">
		<div class="about-title">About the Service</div>
</section>	
<!-- end of about section -->

<!-- footer -->
<footer id="footer">
<p>HTML Element Counter</p>
<footer>
<!-- end of footer -->

<!-- jQuery Core 3.3.1 -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous">
 </script>
 
<script src="js/scripts.js"></script>

</body>
</html>