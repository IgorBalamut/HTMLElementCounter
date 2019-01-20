<!doctype html>

<html lang="en">
<head>
	<meta charset="utf-8">

	<title>HTML Element Counter</title>
	<meta name="description" content="Project">
	<meta name="author" content="Igor B">

	<link rel="stylesheet" href="css/styles.css"> 

</head>

<body>

	<h2>HTML Element Counter</h2>

	<form id="input_form" method="post" action="counter.php">
		<fieldset>
	   		<legend>Input data:</legend>
		 	URL (it should start from http:// or https://, max 255 characters):
		 	<br>
		  	<input type="text" name="input_url" value="https://www.google.com" required pattern="^(http|https):\/\/(.*)" maxlength="255">
		  	<br>
		 	Element (it should be valid HTML5 tag, max 10 characters):
		 	<br>
			<input type="text" name="input_element" value="a" required pattern="^[a-zA-Z]+$" maxlength="10">
		  	<br><br>
		  	<input type="submit" value="Submit">
		</fieldset>
	</form> 

	<h3>Request results</h3>
	<p>URL  <span class="output_url">__</span> fetched on <span class="output_time">__</span>, took <span class="output_period">__</span> msec.</p>
    <p>Element <<span class="output_element">__</span>> appeared <span class="output_count">__</span> times in page.</p>

    <h3>General Statistics</h3>

    <p><span class="stat_count_url">__</span> different URLs from <span class="output_domain">__</span> have been fetched.</p>
    <p>Average fetch time from <span class="output_domain">__</span> during the last 24 hours hours is <span class="stat_average_time">__</span> msec.</p>
    <p>There was a total of <span class="stat_element_domain">__</span> <<span class="output_element">__</span>> elements from <span class="output_domain">__</span>.</p>
    <p>Total of <span class="stat_total_element">__</span> <<span class="output_element">__</span>> elements counted in all requests ever made.</p>

<!-- jQuery Core 3.3.1 -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous">
 </script>
 
<script src="js/scripts.js"></script>

</body>
</html>