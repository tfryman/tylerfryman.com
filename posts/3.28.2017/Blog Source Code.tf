I've open-sourced the [PHP source code](https://github.com/tfryman/tylerfryman.com) for this blog and the posts (in markdown formatted files) to GitLab under the [MIT License](https://github.com/tfryman/tylerfryman.com/blob/master/LICENSE.md). I've not wrote PHP in years, but figured creating this blog and adding in features would be a good exercise to get back into the swing of things. 

It basically loops through all the directories in *posts/* and adds them into an array after coverting the directory name into an Unix timestamp which we reverse so we show the newest posts first:

~~~php
foreach ($dir as $fileinfo) {
	if (is_dir($fileinfo->getFilename())) continue;
	$files[strtotime(str_replace(".", "/", $fileinfo->getFilename()))] = $fileinfo->getFilename();
	}

//krsort will sort in reverse order
	krsort($files);
~~~

This gives us an array with the Unix timestamp as the key and the directory name as the value:

~~~php
array(3) { [1490659200]=> string(9) "3.28.2017" [1490313600]=> string(9) "3.24.2017" [1489968000]=> string(9) "3.20.2017" }
~~~

We then loop through each directory and verify it's not empty and display the contents of each file in Markdown using the [Better Markdown Parser](http://parsedown.org/).  I used [Prism.js](http://prismjs.com/) to do the PHP syntax highlighting.

An issue I'll need to solve in the future is that I can't have multiple blog posts inside the same *date* directory since we don't loop through the array after the array_slice and just use the first index.
~~~php
$getfile = array_slice(scandir($path.$file), 2); //removes "." ".." dirs from scandir
		if(!empty($getfile)) { 
		$filename = $getfile[0];
~~~

This is a simple change that I'll add in soon.