<?php

class Cstiker_tintasController
{

    public function viewStikerImprimir()
    {
        $vista = 'view_stiker_tintas.php';
        self::Cvista($vista);
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = $_POST;
            $data_serialize = urlencode(serialize($data));
            $url = "views/view_stiker_tintas_imprimir.php?info=".$data_serialize;
            echo '<script>';
            echo 'window.open("'.$url.' ", "_blank", "width=1200,height=760");'; // Abre una nueva ventana emergente
            echo '</script>';
        } 
    }

    public function Cvista($vista = '')
    {
        if ($vista) {
            require_once("views/" . $vista);
        } else {
            require_once("views/view_stiker_tintas.php?");
        }
    }
    
}
