<?php

function esBuilderAutoLoad($currentDir){
    foreach(scandir($currentDir) as $dir)
    {
        if(preg_match("#^\.$|^\.\.$|\.php#", $dir)) continue;

        $files = scandir($currentDir."/$dir/");

        if($interfaceDirectoryIndex = array_search("_interfaces", $files)){
            foreach(scandir($currentDir."/$dir/_interfaces/") as $interfaceFile){
                if(preg_match("#^\.$|^\.\.$#", $interfaceFile)) continue;
                include $currentDir."/$dir/_interfaces/$interfaceFile";
            }
            unset($files[$interfaceDirectoryIndex]);
        }

        foreach($files as $file)
        {
            if(preg_match("#^\.$|^\.\.$#", $file)) continue;
            include $currentDir."/$dir/$file";
        }
    }
};