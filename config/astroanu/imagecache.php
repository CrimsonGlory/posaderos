<?php

return 	array(
	'paths' => array(
        'input' => '../storage/app/assets',
        'output' => '../storage/app/imagecache'
    ),
    'imagedriver' => 'imagick',
    'imagepath' => 'images',
    'defaults' => array(
        'thumbwidth' => 80,
        'thumbheight' => 80,
        'jpgquality' => 80
    ),
);
