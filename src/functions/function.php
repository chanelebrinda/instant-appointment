<?php

function IATEN_fetch_message($name, $date, $hour, $mail_message){
    $message_array1 = explode(" " , $mail_message);
    
    foreach ($message_array1 as $key => $message) {
        switch($message){
            case "[name]" : 
                $message_array1[$key] = $name;
                break;
            case "[name]," : 
                $message_array1[$key] = $name . ",";
                break;
            case "[name]." : 
                $message_array1[$key] = $name . ".";
                break;
            case "[name];" : 
                $message_array1[$key] = $name . ";";
                break;
            case "[name]:" : 
                $message_array1[$key] = $name . ":";
                break;
            case "[name]!" : 
                $message_array1[$key] = $name . "!";
                break;
            case "[name]?" : 
                $message_array1[$key] = $name . "?";
                break;
            case "[date]":
                $message_array1[$key] = $date;
                break;
            case "[date],":
                $message_array1[$key] = $date . ",";
                break;
            case "[date].":
                $message_array1[$key] = $date . ".";
                break;
            case "[date];":
                $message_array1[$key] = $date . ";";
                break;
            case "[date]:":
                $message_array1[$key] = $date . ":";
                break;
            case "[date]!":
                $message_array1[$key] = $date . "!";
                break;
            case "[date]?":
                $message_array1[$key] = $date . "?";
                break;
            case "[hour]":
                $message_array1[$key] = $hour;
                break;
            case "[hour],":
                $message_array1[$key] = $hour  . ",";
                break;
            case "[hour].":
                $message_array1[$key] = $hour . ".";
                break;
            case "[hour];":
                $message_array1[$key] = $hour . ";";
                break;
            case "[hour]:":
                $message_array1[$key] = $hour . ":";
                break;
            case "[hour]!":
                $message_array1[$key] = $hour . "!";
                break;
            case "[hour]?":
                $message_array1[$key] = $hour . "?";
                break;
        }
    }
    $message =  implode(" ", $message_array1);
    return $message;
}
