<?php
class View{
    public function show($vista, $data=null){;
        include(VIEW_PATH . 'templates/header.php');
        include(VIEW_PATH . $vista . '-view.php');
        include(VIEW_PATH . 'templates/footer.php');
    }
}