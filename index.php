<?php
/*
Copyright 2017 Tyler Fryman - TylerFryman.com

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
include_once("includes/Parsedown.php");
$Parsedown = new Parsedown();

$files = array();
$path = "posts/";
?>

<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tyler Fryman</title>
<link rel="icon" type="image/png" href="images/favicon.ico">
<link rel="stylesheet" href="/style/style.css" data-noprefix />
<link rel="stylesheet" href="/style/prism.css" data-noprefix />
<body>
<article>
	<header>
		<h1 class="logo">Tyler Fryman</h1>
	</header>
</article>
<main>
<?php
if(substr($_SERVER['REQUEST_URI'],-1,1) == "/") 
	$_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'],1,-1); //remove leading & trailing slash
else
	$_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'],1); //remove leading slash

//Sanity Check Data
	if(empty($_SERVER['REQUEST_URI']) OR $_SERVER['REQUEST_URI'] == "/" OR $_SERVER['REQUEST_URI'] == "/index.php")  //whole blog
		$files = get_files($path);
	else { // single blog post
		$post = explode("/",$_SERVER['REQUEST_URI']);
		if($post[0] != "post" or count($post) <> 2)  //not a valid dir for single post
			$files = get_files($path); //get all blog posts
		else { 
				$filepath = rsearch('posts/', str_replace("-"," ",$post[1]).".tf");
				if($filepath) { //its a valid and real blog post
					$str_time = str_replace(array(".","posts/"), array("/",""), $filepath->getPath()); //change date dir to a valid timestamp
					$files[strtotime((strpos($str_time,"-") === FALSE ? $str_time : substr($str_time,0,strpos($str_time,"-"))))]  = $filepath->getPath(); //only get dir chars up to "-" for multi date blog posts
				}		
			else
				$files[] = get_files($path); //get all blog posts
		}
	}	

//krsort will sort in reverse order
	krsort($files);

foreach($files as $date => $file){
			if(substr($file,0,5) == "posts") $path = "";
			$getfile = array_slice(scandir($path.$file), 2); //removes "." ".." dirs from scandir
			if(!empty($getfile)) { 
				$filename = $getfile[0];
				$name = str_replace(".tf", "", $filename);
	
?>

<article>
	<header>
		<h2><?php echo "<a href=\"post/".str_replace(" ","-",$name)."\">$name</a>";?> </h2>
	</header>
	<p>
<?php
echo "<small>".date("F j, Y",$date)."</small>"; 
echo $Parsedown->text(file_get_contents($path.$file."/".$filename));
?>

</article>
<hr><br>
<?php 
	} //array not empty

	} //foreach loop

echo "<article><small>Page created in " . round(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"],4) . " seconds.</small></article>";

echo "</main></body><script src="/style/prism.js"></script>";

include_once("includes/analyticstracking.php");

echo </html>";


//
//	 Misc. Funcitons
//

function get_files($path) {
$dir = new DirectoryIterator($path);
	foreach ($dir as $fileinfo) {
		if (is_dir($fileinfo->getFilename())) continue;
	
		$str_time = str_replace(".", "/", $fileinfo->getFilename());
		if(strpos($str_time,"-"))  //multi dates
			$files[strtotime(substr($str_time,0,strpos($str_time,"-")))+abs(substr($str_time, strpos($str_time,"-")))] = $fileinfo->getFilename(); //if dir has "-" (meaning multi date post) then we add it to the base time of that date to matain sorting order
		else
			$files[strtotime($str_time)] = $fileinfo->getFilename();
		}
		
		return $files;
}

function rsearch($folder, $pattern) {
// http://stackoverflow.com/a/36912410
// Sadee - 04/28/16
   $iti = new RecursiveDirectoryIterator($folder);
    foreach(new RecursiveIteratorIterator($iti) as $file){
         if(strpos($file , $pattern) !== false){
            return $file;
         }
    }
    return false;
}
 ?>

