<?php
// 下载
  function download(){
      $name = basename($download['picture']);
      $dir = dirname($download['picture']);
      $file_dir = "./upload/news/image/".$dir.'/';

      if (!file_exists($file_dir.$name)){
        header("Content-type: text/html; charset=utf-8");
        echo "找不到文件";
        exit;
      }
      else {
        $file = fopen($file_dir.$name,"r");
        Header("Content-type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        Header("Accept-Length: ".filesize($file_dir . $name));
        Header("Content-Disposition: attachment; filename=".$name);
        echo fread($file, filesize($file_dir.$name));
        fclose($file);
        $this->success('donwload');
      }
  }



?>