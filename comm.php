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

  // 全角转半角
  /**
   *  将一个字串中含有全角的数字字符、字母、空格或'%+-()'字符转换为相应半角字符
   *
   * @access  public
   * @param   string       $str         待转换字串
   *
   * @return  string       $str         处理后字串
   */
  function make_semiangle($str)
  {
      $arr = array('０' => '0', '１' => '1', '２' => '2', '３' => '3', '４' => '4',
                   '５' => '5', '６' => '6', '７' => '7', '８' => '8', '９' => '9',
                   'Ａ' => 'A', 'Ｂ' => 'B', 'Ｃ' => 'C', 'Ｄ' => 'D', 'Ｅ' => 'E',
                   'Ｆ' => 'F', 'Ｇ' => 'G', 'Ｈ' => 'H', 'Ｉ' => 'I', 'Ｊ' => 'J',
                   'Ｋ' => 'K', 'Ｌ' => 'L', 'Ｍ' => 'M', 'Ｎ' => 'N', 'Ｏ' => 'O',
                   'Ｐ' => 'P', 'Ｑ' => 'Q', 'Ｒ' => 'R', 'Ｓ' => 'S', 'Ｔ' => 'T',
                   'Ｕ' => 'U', 'Ｖ' => 'V', 'Ｗ' => 'W', 'Ｘ' => 'X', 'Ｙ' => 'Y',
                   'Ｚ' => 'Z', 'ａ' => 'a', 'ｂ' => 'b', 'ｃ' => 'c', 'ｄ' => 'd',
                   'ｅ' => 'e', 'ｆ' => 'f', 'ｇ' => 'g', 'ｈ' => 'h', 'ｉ' => 'i',
                   'ｊ' => 'j', 'ｋ' => 'k', 'ｌ' => 'l', 'ｍ' => 'm', 'ｎ' => 'n',
                   'ｏ' => 'o', 'ｐ' => 'p', 'ｑ' => 'q', 'ｒ' => 'r', 'ｓ' => 's',
                   'ｔ' => 't', 'ｕ' => 'u', 'ｖ' => 'v', 'ｗ' => 'w', 'ｘ' => 'x',
                   'ｙ' => 'y', 'ｚ' => 'z',
                   '（' => '(', '）' => ')', '［' => '[', '］' => ']', '【' => '[',
                   '】' => ']', '〖' => '[', '〗' => ']', '「' => '[', '」' => ']',
                   '『' => '[', '』' => ']', '｛' => '{', '｝' => '}', '《' => '<',
                   '》' => '>',
                   '％' => '%', '＋' => '+', '—' => '-', '－' => '-', '～' => '-',
                   '：' => ':', '。' => '.', '、' => ',', '，' => '.', '、' => '.',
                   '；' => ',', '？' => '?', '！' => '!', '…' => '-', '‖' => '|',
                   '＂' => '"', '＇' => '`', '｀' => '`', '｜' => '|', '〃' => '"',
                   '　' => ' ');
      return strtr($str, $arr);
  }
  /**
   * 检查是否为一个合法的时间格式
   *
   * @param   string  $time
   * @return  void
   */
  function is_time($time)
  {
      $pattern = '/[\d]{4}-[\d]{1,2}-[\d]{1,2}\s[\d]{1,2}:[\d]{1,2}:[\d]{1,2}/';

      return preg_match($pattern, $time);
  }
  /**
   * 验证输入的邮件地址是否合法
   *
   * @param   string      $email      需要验证的邮件地址
   *
   * @return bool
   */
  function is_email($user_email)
  {
      $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,5}\$/i";
      if (strpos($user_email, '@') !== false && strpos($user_email, '.') !== false)
      {
          if (preg_match($chars, $user_email))
          {
              return true;
          }
          else
          {
              return false;
          }
      }
      else
      {
          return false;
      }
  }

  /**
   * 获得用户的真实IP地址
   *
   * @return  string
   */
  function real_ip()
  {
      static $realip = NULL;

      if ($realip !== NULL)
      {
          return $realip;
      }

      if (isset($_SERVER))
      {
          if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
          {
              $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

              /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
              foreach ($arr AS $ip)
              {
                  $ip = trim($ip);

                  if ($ip != 'unknown')
                  {
                      $realip = $ip;

                      break;
                  }
              }
          }
          elseif (isset($_SERVER['HTTP_CLIENT_IP']))
          {
              $realip = $_SERVER['HTTP_CLIENT_IP'];
          }
          else
          {
              if (isset($_SERVER['REMOTE_ADDR']))
              {
                  $realip = $_SERVER['REMOTE_ADDR'];
              }
              else
              {
                  $realip = '0.0.0.0';
              }
          }
      }
      else
      {
          if (getenv('HTTP_X_FORWARDED_FOR'))
          {
              $realip = getenv('HTTP_X_FORWARDED_FOR');
          }
          elseif (getenv('HTTP_CLIENT_IP'))
          {
              $realip = getenv('HTTP_CLIENT_IP');
          }
          else
          {
              $realip = getenv('REMOTE_ADDR');
          }
      }

      preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
      $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';

      return $realip;
  }



?>