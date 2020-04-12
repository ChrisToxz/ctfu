<?php

require_once './core/init.php';
$ctfu = new CTFU();
if(isset($_POST['url'])){
    if($ctfu->url($_POST['url'])){
        $ctfu->clean();
        $array = array(
            'success' => true,
            'url' => $_POST['url'],
            'filtered' => $ctfu->createURL()
        );

        echo json_encode($array);
    }else{
        echo json_encode(array('success' => false));
    }
}else{
    echo json_encode(array('success' => false));
}