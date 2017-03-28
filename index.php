<?php
/*
Copyright 2017 Tyler Fryman - TylerFryman.com

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

include "includes/Parsedown.php";
$Parsedown = new Parsedown();

$files = array();
$path = "posts/";
$dir = new DirectoryIterator($path);
?>

<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tyler Fryman</title>
<style>
	body{
		margin:1em auto;
		max-width:40em;
		padding:0 .01em;
		font:1.2em/1.62 sans-serif;
	}
	article {
		
		
	}
	h1.logo { 
		text-align: center;
		line-height:1.0;	
		font-size: 35pt;
		text-decoration: underline;
		}
	h1,h2,h3 {
		line-height:0;
	}
	@media print{
		body{
			max-width:none
		}
	}
</style>
<link rel="stylesheet" href="style/prism.css" data-noprefix />
<script src="style/prism.js"></script>
<body>

<article>
	<header>
		<h1 class="logo">Tyler Fryman</h1>
	</header>
</article>
<main>
<?php
foreach ($dir as $fileinfo) {
	if (is_dir($fileinfo->getFilename())) continue;
	
	$str_time = str_replace(".", "/", $fileinfo->getFilename());
	if(strpos($str_time,"-"))  //multi dates
		$files[strtotime($str_time)+abs(substr($str_time, strpos($str_time,"-")))] = $fileinfo->getFilename(); //if dir has "-" (meaning multi date post) then we add it to the base time of that date to matain sorting order
	else
		$files[strtotime($str_time)] = $fileinfo->getFilename();
	}

//krsort will sort in reverse order
	krsort($files);

foreach($files as $date => $file){
		$getfile = array_slice(scandir($path.$file), 2); //removes "." ".." dirs from scandir
		if(!empty($getfile)) { 
		$filename = $getfile[0];
		$name = str_replace(".tf", "", $filename);
	
?>

<article>
		<h2><?php echo $name;?> </h2>
	<p>
<?php
echo "<small>".date("F j, Y",$date)."</small>"; 
echo $Parsedown->text(file_get_contents($path.$file."/".$filename));
?>

</article>
<hr>
<?php 
	} //array not empty

	} //foreach loop

echo "<article><small>Page created in " . round(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"],4) . " seconds.</small></article>";

echo "</main></body></html>";


//
//	 Misc. Funcitons
//

 ?>

