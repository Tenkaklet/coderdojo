
<?php
    require_once '../app/helpers/components.php';

    $component = new Component;
    $popularProducts = $component->productList($data["products"]["response"]["result"][0]);
    $slideshow = $component->slideshow($data['slideshow']["response"]["result"][0]);

    $mainContent = [
        //'include' => "slideshow.tpl.php",
        'data' => [
            'slideshow' => $slideshow,
            'popularProducts' => $popularProducts
        ]
    ];

    
    require_once '../app/helpers/template/wrapper.tpl.php';
?>