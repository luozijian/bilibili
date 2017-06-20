<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<?php
		
	$db=new PDO("mysql:host=localhost;dbname=lwj","root","root");
	$db->query("set names 'utf8'");
	$sql="SELECT * FROM `zimu`";
	$result=$db->query($sql);
	$result->setFetchMode(PDO::FETCH_ASSOC);
	$row=$result->fetchall();
	$r=$row[0];
	print_r($r);
	$start_time='start_time';
	$end_time='end_time';
//	function reTime($time)
//	{
//		$retime=explode(":",$time);
//		
//	}
	?>
<script src="./video.php_files/jquery-1.11.3.min.js"></script>
<script>
	$(function(){
		
	console.log('hello');
	var $video = $('#v');
	var video = $video[0];
	var $subtitle = $('.subtitle');
	$video.bind('timeupdate',function(e){
		$subtitle.text(video.currentTime);
	});
	
	});

</script>
<style>
.page{
	position:relative;
	
}
.subtitle{
	position:absolute;
	background:grey;
	color: white;
	bottom:5em;
	width:100%;
}
</style>	
	
</head>
<body>
<div class="header">My Video Player</div>
<div class="page">
<video id="v" controls="true" webkit-playsinline="" playsinline="" src="mp4/Daniel Wu - on journey.mp4">
				Your browser does not support the video tag.
</video>
<div class="subtitle">subtitle</div>
</div>

<div class="footer">@copyright<div>
	
</div></div></body></html>
