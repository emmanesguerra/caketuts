<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_FILES['upload']['name'])) 
{
    $file = $_FILES['upload']['tmp_name'];
    $file_name = $_FILES['upload']['name'];
    $file_name_array = explode(".", $file_name);
    $extension = end($file_name_array);
    $new_image_name = rand() . '.' . $extension;
    chmod('upload', 0777);
    $allowed_extension = array("jpg", "gif", "png");
    if(in_array($extension, $allowed_extension))
    {
        move_uploaded_file($file, 'upload/' . $new_image_name);
        $function_numer = $_GET['CKEditorFuncNum'];
        $url = '/upload/' . $new_image_name;
        $message = '';
        echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_numer, '$url', '$message')</script>";
    }
}