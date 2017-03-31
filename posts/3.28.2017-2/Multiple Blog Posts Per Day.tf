Like I said in my last post, I wanted to add in the option to make multiple posts per day. I just didn't think I'd have time to do it the same day! 

My first thought was to do something like:
~~~
posts/
├── 3.20.2017
│   └── First Post.tf
├── 3.24.2017
│   └── Blog Hosting.tf
├── 3.28.2017
│   └── Blog Source Code.tf
│   └── Multiple Blog Posts Per Day.tf
~~~

Unix doesn't keep a file creation date (accessible with PHP that I could find) so I was left with using the last modified date to sort inside a single directory. If I went back and edited a post for a spelling mistake or any other reason, this would throw off the correct sort order. I decided to use multiple *"date"* directories and increment a number for each "same day" post:

~~~
posts/
├── 3.20.2017
│   └── First Post.tf
├── 3.24.2017
│   └── Blog Hosting.tf
├── 3.28.2017
│   └── Blog Source Code.tf
└── 3.28.2017-2
    └── Multiple Blog Posts Per Day.tf
~~~

Notice that **"-2"** for the *Multiple Blog Posts Per Day* directory? We use that number to add to the *base*  number given by [strtotime](http://php.net/manual/en/function.strtotime.php) so our newest posts always sort correctly.

~~~php
array(4) { [1490659202]=> string(11) "3.28.2017-2" [1490659200]=> string(9) "3.28.2017" [1490313600]=> string(9) "3.24.2017" [1489968000]=> string(9) "3.20.2017" }
~~~

See how **3.28.2017-2** is two seconds after **3.28.2017** in the array? We do this in the [get_files() function](https://github.com/tfryman/tylerfryman.com/blob/master/index.php#L98):
~~~php

		if(strpos($str_time,"-"))  //multi dates
			$files[strtotime(substr($str_time,0,strpos($str_time,"-")))+abs(substr($str_time, strpos($str_time,"-")))] = $fileinfo->getFilename(); //if dir has "-" (meaning multi date post) then we add it to the base time of that date to matain sorting order
		else
			$files[strtotime($str_time)] = $fileinfo->getFilename();
		}
		
		return $files;
}
~~~
The abs() function gets rid of the "-" returned from our substr, I could have also used a sub_replace(), but abs() just seemed cleaner.

*Updated 3/31/2017:* The orginal code didn't strip out the "-2" from the dir name and thus returned the wrong timestamp. This was solved with a substr() inside the if()'s TRUE statement above.