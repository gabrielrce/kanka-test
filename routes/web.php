<?php

use Illuminate\Support\Facades\Route;

//1st part: Decide which view to load based on a/b rand var
//2nd part: Encode a/b var as an array and console.log output for demonstration purpose only
//3rd part: Decide whether the web page is freshly loaded or refrshed

$pageRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && ($_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0' ||  $_SERVER['HTTP_CACHE_CONTROL'] == 'no-cache');
if ($pageRefreshed == 0) {
    $aB = rand(0, 1);
    if ($aB === 1) {
        $aB = "B";
        setcookie("TestCookie", $aB);
        Route::view('/', 'welcomeB');
    } else {
        $aB = "A";
        setcookie("TestCookie", $aB);
        Route::view('/', 'welcomeA');
    }
} else {
    Route::view('/', 'welcome' .  $_COOKIE["TestCookie"]);
}

$jsvar = json_encode(array("a/b var" => $_COOKIE["TestCookie"]));
echo '<script>
console.log(' . $jsvar . ');
</script>';
