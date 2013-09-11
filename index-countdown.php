<!DOCTYPE html>
<meta charset="UTF-8">
<html>
	<?php 
		$titleTag = "Home";
		include("includes/html-head.php"); ?>
	<body id="home">
		<?php include("includes/header.php"); ?>
		<section>
			<h2>31st March 2013 – Ultimate Easter Challenge – Part 3!</h2>

			<h3>Entries now open for 2013 – Enter your team asap – Places Limited!</h3>

			<p class="highlight">Closing date for entries is Sunday 24th March!</p>

			<div id="counter"></div>

			<blockquote>
				"Genuinely one of the most stressful days of my life" - Chris<br />
				"The most fun you can have in an ice cream van!!" - Pooks<br />
				"Amazing what people will let you do if you just ask" - Mum<br />
				"We had to get hold of a KFC badge even though it meant kidnapping one of their employees" - Mockford<br />
				"Eggciting well organised fun for all ages and all the family" - Jamie<br />
			<blockquote>

			<img src="assets/images/bunny.png" alt="" />
		</section>
	    <script>
	      $(function(){
	        var sDate = new Date(),
	        	eDate = new Date('March 24, 2013 11:59:59 pm'),
	        	cDate = (eDate.getDate() - sDate.getDate()).toString(),
	        	cHour = (eDate.getHours() - sDate.getHours()).toString(),
	        	cMin = (eDate.getMinutes() - sDate.getMinutes()).toString(),
	        	cSecs = (eDate.getSeconds() - sDate.getSeconds()).toString(),
	        	startTime = (cDate.length === 1 ? '0' + cDate : cDate) + ':' +
			        (cHour.length === 1 ? '0' + cHour : cHour) + ':' +
			        (cMin.length === 1 ? '0' + cMin : cMin) + ':' +
			        (cSecs.length === 1 ? '0' + cSecs : cSecs);

	        $('#counter').countdown({
	        	format: 'dd:hh:mm:ss',
	        	startTime: startTime,
	        	image: "assets/images/digits.png"
	        });
	      });
	    </script>
		<script src="assets/js/jquery.countdown.js"></script>
	</body>
</html>