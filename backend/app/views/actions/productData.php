<?php
    require_once '../app/helpers/components.php';

    $component = new Component;
    $productData = $component->productDataModal($data);

    echo $productData;
?>