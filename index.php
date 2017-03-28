<?php
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
	$files[$fileinfo->getMTime()] = $fileinfo->getFilename();
}

//krsort will sort in reverse order
	krsort($files);

foreach($files as $date => $file){
		$getfile = array_slice(scandir($path.$file), 2);
		if(!empty($getfile) && substr($file,0,3) != "DEL") {

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
//
//	 Misc. Funcitons
//
//

function format_line($rawline, $code) {
	if (strpos($rawline, '[code]') !== false) {
		echo "<pre><code class=\"php\">";
		$code = true;
	} elseif (strpos($rawline, '[/code]') !== false)  {
		echo "</pre></code>";
		$code = false;
	} else {
		if($code) 
			echo htmlspecialchars($rawline);
		else 
			echo nl2br(htmlspecialchars($rawline)); 
	}
	return $code;
}	


function read($file) {
    $fp = fopen($file, 'rb');
    while(($line = fgets($fp)) !== false)
        yield $line;
    fclose($fp);
}
 ?>

