<?php


$vars = array();
           if(isset($_POST)) {
               $vars['post'] = print_r($_POST,true);
           }
           if(isset($_GET)){
               $vars['get'] = print_r($_GET,true);
           }

           mail('juans@allytech.com','DEBUG IPN',print_r($vars,true));