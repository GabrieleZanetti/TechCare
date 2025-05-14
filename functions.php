<?php
    require_once ("Classes/Database.php");
    
    function getDB()
    {
        $db = Database::getInstance();
        return $db;
    }

    function openSession()
    {
        if(!isset($_SESSION))
            session_start();
    }

    function relocator($url,$mex)
    {
        if($mex==null){
            header("location:".$url);
            exit();
        }
        else{
            $m = urlencode($mex);
            header("location:".$url."?err=".$m);  
            exit();
        } 
    }

    function exist($type,$index)
    {
        return isset($type[$index]) && !empty($type[$index]);
    }

    function authGuard($page,$mex): void
    {   
        !exist($_SESSION,"Auth") ? relocator($page,$mex):null;
    }

    function logout()
    {
        relocator("logout.php",null);
    }

    function isMobile($userAgent) 
    {
        return preg_match( '/android|iphone|ipad|ipod|blackberry|windows phone/i', $userAgent);
    }

    function fileHandler()
    {
        $ris = [null,null];    //0 = stato del processo 1 = path

        if (isset($_FILES["avatar"]) && $_FILES["avatar"]["error"] == 0) 
        {
            $nome = $_FILES["avatar"]["name"];
            $cartellaTemp = $_FILES["avatar"]["tmp_name"];
            
            //Estensione del file controllo se va bene
            $estensione = strtolower(pathinfo($nome, PATHINFO_EXTENSION));
            $consentite = ["jpg", "jpeg", "png", "gif", "mp4", "avi", "mov"];

            if (in_array($estensione,$consentite)) 
            {
                $cartella = "img/";
                if (!is_dir($cartella))
                    mkdir($cartella, 0777, true);

                //Percorso del file definitvo (Img/nomefile)
                $path = $cartella.basename($nome);

                //Sposto il file dalla cartella temporanea a quella definitiva se tutto va bene 
                $ris[0] = move_uploaded_file($cartellaTemp, $path);
                $ris[1] = $path;

                return $ris;
            }
        }

        return $ris;
    }

?>