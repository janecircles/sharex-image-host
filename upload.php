<?php
$secret_key = "changethis"; //Set this as your secret key, to prevent others uploading to your server.
$sharexdir = "i/"; //This is your file dir, also the link..
$domain_url = 'https://example.com';
$lengthofstring = 5; //Length of the file name
 
$safe_types = ["jpg", "jpeg", "png", "gif", "gifv", "exe"];
 
function RandomString($length) {
    $keys = array_merge(range(0,9), range('a', 'z'));
 
    for($i=0; $i < $length; $i++) {
        $key .= $keys[mt_rand(0, count($keys) - 1)];
    }
    return $key;
}
 
if(isset($_POST['secret']))
{
    if($_POST['secret'] == $secret_key)
    {
        $filename = RandomString($lengthofstring);
        $target_file = $_FILES["sharex"]["name"];
        $fileType = pathinfo($target_file, PATHINFO_EXTENSION);
        //not sure how save that is, but you can use this instead:
        //$fileType = strtolower(end(explode(".", $target_file)));
        if (in_array($fileType, $safe_types))
        {
            if (move_uploaded_file($_FILES["sharex"]["tmp_name"], $sharexdir.$filename.'.'.$fileType))
            {
                echo $domain_url.$sharexdir.$filename.'.'.$fileType;
            }
            else
            {
               echo 'File upload failed - CHMOD/Folder doesn\'t exist?';
            }
        }  
    }
    else
    {
        echo 'Invalid Secret Key';
    }
}
else
{
    echo 'No post data recieved';
}
