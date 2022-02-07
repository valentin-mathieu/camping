<?php

    class Admin {

        public function CheckAdmin () {
            

            if (!isset($_SESSION['login']) || $_SESSION['admin'] =='0') {
                header('Location: compte.php');
            }
        }
    }
?>