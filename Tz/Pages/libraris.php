<?php


if (!function_exists('ifndf_add_logout')) {

    function ifndf_add_logout($phone = true)
    {
        if ($phone) {
            if (isset($_COOKIE['username'])) {
                return "<a href=\"index.php?logout=true\" id='nav'>خروج از حساب</a>";
            } else {
                return "";
            }
        } else {
            if (isset($_COOKIE['username'])) {
                return "<a href=\"index.php?logout=true\" id='logout'>خروج از حساب</a>";
            } else {
                return "";
            }
        }
    }
}

if (!function_exists('getRandString')) {


    function getRandString($array)
    {
        $rindex = array_rand($array, 15);
        $str = "";
        foreach ($rindex as $key) {
            $str = $str . $array[$key];
        }
        return $str;
    }
}

if (!function_exists('getAllChars')) {
    function getAllChars()
    {
        $lowercase = range("a", "z");
        $uppercase = range("A", "Z");
        $number = range("0", "9");
        $allchars = array_merge($lowercase, $uppercase, $number);
        return $allchars;
    }
}



if (!function_exists('reload')) {
    function reload($path)
    {
        $questions1 = JsonIntoQ($path);
        if ($questions1 != -1) {
            echo "<form action='MakingQestions.php' method='post'>";
            echo "<table>";
            echo "  <tr style='background-color:black;color:white'>";
            echo "    <td> ID </td> <td> QUESTION </td><td>PID</td><td> DELETE</td>";
            echo "  </tr>";
            for ($i = 0; $i < count($questions1); $i++) {
                if ($questions1[$i] != null) {
                    echo "<tr><td style='background-color:black;color:white'>$i</td>";
                    echo "<td><strong><b>" . $questions1[$i]['q'] . "</b></strong></td><td>" . $questions1[$i]['id'] . "</td>";
                    echo "<td><input type='button' selected='false' style='background-color:rgb(210,210,210)' id=\"{$questions1[$i]["id"]}\" name='delete' class='delete' value='delete' onclick='addlist(\"{$questions1[$i]["id"]}\")'></td>";
                }
            }
            echo "</table>";
            echo "<input type='submit' name='Doing' id='list' value='اعمال تغییرات'>";
            echo "<input type='text' name='del' id='del' readonly style='display:none'>";
            echo "</form>";
        }
    }
}


if (!function_exists('FILTER_VALIDATE_NAME')) {
    function FILTER_VALIDATE_NAME()
    {
        return array_merge(range('a', 'z'), range('A', 'Z'), range('0', '9'));
    }
}

if (!function_exists('filter_name')) {
    function filter_name($string, $chars)
    {
        foreach ($string as $i) {
            if (!in_array($i, $chars)) {
                return false;
            }
        }
        return true;
    }
}


if (!function_exists('render_code_into_id')) {
    function render_code_into_id($code, $Chars, $render_separator)
    {
        $newstr = "";
        foreach (mb_str_split($code) as $i) {
            if (in_array($i, $Chars)) {
                $newstr = $newstr . $i;
            } else {
                $newstr = $newstr . $render_separator;
            }
        }
        return $newstr;
    }
}

if (!class_exists('Captcha')) {
    class Captcha
    {
        private $captcha_list = array(
            [
                'Captcha-1.png',
                '233890'
            ],
            [
                'Captcha-2.png',
                'a90111'
            ],
            [
                'Captcha-3.png',
                '908291'
            ],
            [
                'Captcha-4.png',
                'alocat3'
            ]
        );
        private $captcha_adr = "../IMG/";
        private $cpr1 = 'API/RoUnDCaPtChA.rcf';  // make a RoUnDCaPtChA.rcf file and enter path
        private $cpr2 = '../API/RoUnDCaPtChA.rcf'; // make a RoUnDCaPtChA.rcf file and enter path

        private $round = 0;

        private $captcha_active = '';
        private $captcha_active_inval = '';
        private $style = false;
        public $alert_message = '';
        public $id = "capcha_id";


        public function captcha_set_style($style){
            $this->style = $style;
        }
        public function captcha_del_style(){
            $this->style = false;
        }
        public function get_cpr1()
        {
            return $this->cpr1;
        }

        public function get_cpr2()
        {
            return $this->cpr2;
        }
        public function negativ_round($round,$max,$queue){
            if($round <= 0){
                return $max;
            }
            else{
                return $round-$queue;
            }
            
        }
        public function captcha_manager($cpr,$queue = 1)
        {
            $this->round = file_get_contents($cpr);
            $max = count($this->captcha_list)-1;
            if($this->round < $max){
                $this->round++;
            }
            else{
                $this->round = 0;
            }
            $round = $this->negativ_round(
                $this->round,
                $max,
                $queue
            );
            
            $this->captcha_active = $this->captcha_list[$this->round][0];
            $this->captcha_active_inval = $this->captcha_list[$round][1];
            $file = fopen($cpr, 'w');
            fwrite($file, $this->round);
            return $this->captcha_list[$this->round];
        }
        public function echo_captcha($cpr,$queue = 1)
        {
            $src = $this->captcha_adr . $this->captcha_manager($cpr,$queue)[0];
            $style = !$this->style ? "":"style='{$this->style}'";
            echo "<img src=\"$src\" alt=\"captcha\" id=\"{$this->id}\" $style>";
        }
        public function check_captcha($header, $inputc, $ifcorrect, $useheader)
        {
            if ($ifcorrect) {
                if ($inputc == $this->captcha_active_inval) {
                    if ($useheader) {

                        header($header,true,303);
                        echo "<error>{$this->alert_message}</error>";
                        
                    }
                    else{
                        echo "<script>alert('{$this->alert_message}');</script>";
                    }
                    exit();
                    
                }
            }
            if (!$ifcorrect) {
                if ($inputc != $this->captcha_active_inval) {
                    if ($useheader) {

                        header($header,true,303);
                        echo "<error>{$this->alert_message}</error>";
                    }
                    else{
                        echo "<script>alert('{$this->alert_message}');</script>";
                        
                    }
                    exit();
                    
                }
            }
        }
    }
}
