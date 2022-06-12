<?php


$esBuilderAutoLoad = function ($currentDir){
    foreach(scandir($currentDir) as $dir)
    {
        if(preg_match("#^\.$|^\.\.$|\.php#", $dir)) continue;
        foreach(scandir($currentDir."/$dir/") as $file)
        {
            if(preg_match("#^\.$|^\.\.$#", $file)) continue;
            include $currentDir."/$dir/$file";
        }
    }
};