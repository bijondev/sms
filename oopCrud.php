<?php
class oopCrud{
    
    
 private $host="localhost";
 private $user="root";
 private $db="db_smsgateway";
 private $pass="";
   
 
// private $host="infoedu.ipagemysql.com";
// private $user="sms_panal";
// private $db="sms_port";
// private $pass="MJA_562443";
// private $conn;

 public function __construct(){

 $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db,$this->user,$this->pass);
 $timezone = "Asia/Dhaka";
if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
 }
 public function base_url(){
$url="http://localhost/link-sea/";
return $url;
 }
   public function logincheck($username,$password){

    $sql="SELECT * FROM _user where _email=? and _password=? and _status=?";
    $q = $this->conn->prepare($sql) or die("ERROR: " . implode(":", $this->conn->errorInfo()));
    $q->execute(array($username, md5($password), 'E'));
    $total = $q->rowCount();
    return $total;
 }
   public function getData($username){

    $sql="SELECT * FROM _user where _email=?";
    $q = $this->conn->prepare($sql) or die("ERROR: " . implode(":", $this->conn->errorInfo()));
    $q->execute(array($username));
    $r = $q->fetch(PDO::FETCH_ASSOC);
    $data['user_id']=$r['_id'];
    $data['name']=$r['_name'];
    $data['email']=$r['_email'];
    $data['company']=$r['_company'];
    $data['usertype']=$r['_usertype'];
    $data['address']=$r['_address'];
    return $data;
 }

  public function showDatacatagory($table){
 $sql="SELECT * FROM $table order by _name asc ";
 $q = $this->conn->query($sql) or die("failed!");
 while($r = $q->fetch(PDO::FETCH_ASSOC)){
 $data[]=$r;
 }
 return $data;
 }
 
 public function showData($table, $order, $s, $t){

 $sql="SELECT * FROM $table order by $order DESC LIMIT $s , $t";
 $q = $this->conn->prepare($sql) or die("ERROR: " . implode(":", $this->conn->errorInfo()));
 $q->execute();

 while($r = $q->fetch(PDO::FETCH_ASSOC)){
 $data[]=$r;
 }
 return $data;
 }
 
  public function showBalance($table, $id){

 $sql="SELECT * FROM $table where _user_id=? order by _id desc";
 $q = $this->conn->prepare($sql) or die("ERROR: " . implode(":", $this->conn->errorInfo()));
 $q->execute(array($id));

 while($r = $q->fetch(PDO::FETCH_ASSOC)){
 $data[]=$r;
 }
 return $data;
 }
public function showByWhere($table, $field, $id){
 $sql="SELECT * FROM $table where  $field=? order by _id DESC";
 $q = $this->conn->prepare($sql) or die("ERROR: " . implode(":", $this->conn->errorInfo()));
 //echo $id;
 $q->execute(array($id));
 while($r = $q->fetch(PDO::FETCH_ASSOC)){
 $data[]=$r;
 }
 return isset($data)? $data :NULL;
}

public function checkSMS(){
 $sql="SELECT * FROM _sms where _status=? LIMIT 0 , 10";
 $q = $this->conn->prepare($sql) or die("ERROR: " . implode(":", $this->conn->errorInfo()));
 //echo $id;
 $q->execute(array("Pending"));
 while($r = $q->fetch(PDO::FETCH_ASSOC)){
 $data[]=$r;
 }
 return $data;
}

public function getMask($_user_id){
     $sql="SELECT _mask FROM _user where _id=? LIMIT 0 , 1";
 $q = $this->conn->prepare($sql) or die("ERROR: " . implode(":", $this->conn->errorInfo()));
 //echo $id;
 $q->execute(array($_user_id));
$r = $q->fetch(PDO::FETCH_ASSOC);
$mask=$r['_mask'];
 return $mask;
}
  public function showDataPaging($table, $order, $cid, $s, $limit){

 $sql="SELECT * FROM $table where _catagory='$cid' order by $order DESC LIMIT $s , $limit";
 $q = $this->conn->query($sql) or die("failed!");

 while($r = $q->fetch(PDO::FETCH_ASSOC)){
 $data[]=$r;
 }
 return $data;
 }

 function countrow($query, $condition){
        $query = "SELECT * FROM {$query} {$condition}";
        
        $del = $this->conn->prepare($query);
            $del->execute();
            $total = $del->rowCount();
            return $total;
 }
 function pagination($query){        
    	$query = "SELECT * FROM {$query} where _catagory=$cat";
        
        $del = $this->conn->prepare($query);
            $del->execute();
            $total = $del->rowCount();

    	//$total = $row['num'];
        $adjacents = "2"; 

            $limit = 20;                                 //how many items to show per page
    $page = $_GET['page'];

    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
		
    	$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    	
    $total_pages = $total;
    


    if($page) 
        $start = ($page - 1) * $limit;          //first item to display on this page
    else
        $start = 0;                             //if no page var is given, set start to 0
    
    if ($page == 0) $page = 1;                  //if no page var is given, default to 1.
    $prev = $page - 1;                          //previous page is page - 1
    $next = $page + 1;                          //next page is page + 1
    $lastpage = ceil($total_pages/$limit);      //lastpage is = total pages / items per page, rounded up.
    $lpm1 = $lastpage - 1;                      //last page minus 1
    
    /* 
        Now we apply our rules and draw the pagination object. 
        We're actually saving the code to a variable in case we want to draw it more than once.
    */
    $pagination = "";
    if($lastpage > 1)
    {   
        echo $pagination .= "<div class=\"pagination\"><ul>";
        //previous button
        if ($page > 1) 
            $pagination.= "<li><a href=\"$targetpage?page=$prev\"><< previous</a></li>";
        else
            $pagination.= "<li class='disabled'><a href='#'><< previous</a></li>"; 
        
        //pages 
        if ($lastpage < 7 + ($adjacents * 2))   //not enough pages to bother breaking it up
        {   
            for ($counter = 1; $counter <= $lastpage; $counter++)
            {
                if ($counter == $page)
                    $pagination.= "<li class='active'><a href='#'>$counter</a></li>";
                else
                    $pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";                 
            }
        }
        elseif($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
        {
            //close to beginning; only hide later pages
            if($page < 1 + ($adjacents * 2))        
            {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                {
                    if ($counter == $page)
                        $pagination.= "<li class='active'>$counter</li>";
                    else
                        $pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";                 
                }
                $pagination.= "...";
                $pagination.= "<li><a href=\"$targetpage?page=$lpm1\">$lpm1</a></li>";
                $pagination.= "<li><a href=\"$targetpage?page=$lastpage\">$lastpage</a></li>";       
            }
            //in middle; hide some front and some back
            elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
            {
                $pagination.= "<li><a href=\"$targetpage?page=1\">1</a></li>";
                $pagination.= "<li><a href=\"$targetpage?page=2\">2</a></li>";
                $pagination.= "...";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                {
                    if ($counter == $page)
                        $pagination.= "<li class='active'>$counter</li>";
                    else
                        $pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";                 
                }
                $pagination.= "...";
                $pagination.= "<li><a href=\"$targetpage?page=$lpm1\">$lpm1</a></li>";
                $pagination.= "<li><a href=\"$targetpage?page=$lastpage\">$lastpage</a></li>";       
            }
            //close to end; only hide early pages
            else
            {
                $pagination.= "<li><a href=\"$targetpage?page=1\">1</a></li>";
                $pagination.= "<li><a href=\"$targetpage?page=2\">2</a></li>";
                $pagination.= "...";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                {
                    if ($counter == $page)
                        $pagination.= "<li class='active'><a href='#'>$counter</a></li>";
                    else
                        $pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";                 
                }
            }
        }
        
        //next button
        if ($page < $counter - 1) 
            $pagination.= "<li><a href=\"$targetpage?page=$next\">next >></a></li>";
        else
            $pagination.= "<li class='disabled'><a href='#'>next >></a></li>";
        $pagination.= "</ul></div>\n";       
    }
    
    
        return $pagination;
    } 

 public function getById($id,$table){

 $sql="SELECT * FROM $table WHERE _id = :id";
 $q = $this->conn->prepare($sql);
 $q->execute(array(':id'=>$id));
 $data = $q->fetch(PDO::FETCH_ASSOC);
 return $data;
 }

  public function getByUniqueId($id,$table){

 $sql="SELECT * FROM $table WHERE _uniquecode = :id";
 $q = $this->conn->prepare($sql);
 $q->execute(array(':id'=>$id));
 $data = $q->fetch(PDO::FETCH_ASSOC);
 return $data;
 }
 public function UpdateUser($hiden_id, $username, $email, $company, $address, $usertype, $status){
  //echo $hiden_id;
    $sql = "UPDATE _user
             SET _name=:name,
                _email=:email, 
                _company=:company, 
                _address=:address, 
                _usertype=:usertype, 
                _status=:status
             WHERE _id=:id";
             $q = $this->conn->prepare($sql) or die("ERROR: " . implode(":", $this->conn->errorInfo()));
             $q->execute(array(
                      ':name'=>$username,
                    ':email'=>$email,
                    ':company'=>$company,
                    ':address'=>$address,
                    ':usertype'=>$usertype,
                    ':status'=>$status,
                    ':id'=>$hiden_id
                    ));
             return true;
 }
 public function update($id,$name,$email,$mobile,$address,$table){

$sql = "UPDATE $table
 SET name=:name,email=:email,mobile=:mobile,address=:address
 WHERE id=:id";
 $q = $this->conn->prepare($sql);
 $q->execute(array(':id'=>$id,':name'=>$name,
':email'=>$email,':mobile'=>$mobile,':address'=>$address));
 return true;

 }

  public function updatelink($id,$visit,$table){
      $sql = "UPDATE $table
       SET _visit=:visit
       WHERE _uniquecode=:id";
       $q = $this->conn->prepare($sql);
       $q->execute(array(':id'=>$id,':visit'=>$visit));
       return true;
 }
 
  public function updateSMS($id,$Status){

    echo $Status;
      $sql = "UPDATE _sms
       SET _status=:status
       WHERE _id=:id";
       $q = $this->conn->prepare($sql);
       $q->execute(array(
        ':id'=>$id,
        ':status'=>$Status
        ));
 return true;

 }
 public function insertUser($username, $email, $password1, $company, $address, $usertype, $status, $ip, $mac, $uniqueid, $date){

 $sql = "INSERT INTO _user 
 (`_id`, `_name`, `_email`, `_password`, `_address`, `_company`, `_usertype`, `_status`, `_ip`, `_mac`, `_create_at`, `_update_at`, `uniqueid`)   
values( :id, :name, :email, :password, :address, :company, :usertype, :status, :ip, :mac, :create_at, :update_at, :uniqueid)";
 $q = $this->conn->prepare($sql);

 $q->execute(array(
  ':id'=>NULL,
 ':name'=>$username,
 ':email'=>$email,
':password'=>md5($password1),
':address'=>$address,
':company'=>$company,
':usertype'=>$usertype,
':status'=>$status,
':ip'=>$ip,
':mac'=>$mac,
':create_at'=>$date,
':update_at'=>$date,
':uniqueid'=>$uniqueid
)) or die(print_r($q->errorInfo()));
//print_r($q);
 return true;
 }

 public function insertBalance($hiden_id, $totaltaka, $smsrate, $totalsms){

$date= date("Y-m-d H:i:s");
 $sql = "INSERT INTO `_sms_balance` (`_id`, `_user_id`, `_taka`, `_sms_count`, `_sms_rate`, `create_at`, `update_at`) 
 VALUES (:id, :user_id, :taka, :sms_count, :sms_rate, :create_at, :update_at);";
 $q = $this->conn->prepare($sql);

 $q->execute(array(
  ':id'=>NULL,
 ':user_id'=>$hiden_id,
 ':taka'=>$totaltaka,
':sms_count'=>$totalsms,
':sms_rate'=>$smsrate,
':create_at'=>$date,
':update_at'=>$date
)) or die(print_r($q->errorInfo()));
//print_r($q);
 return true;
 }

public function balancecheck($userid){
        $query = "SELECT MAX(totaltaka) AS totaltaka, MAX(totalexp) AS totalexp  FROM (
                SELECT SUM(`_taka`) AS totaltaka, 0 AS totalexp FROM `_sms_balance` b where _user_id=?
                UNION
                SELECT 0 AS totaltaka, SUM(`_sms_rate`) AS totalexp FROM `_sms` where _user_id=? GROUP BY _user_id
                ) AS t";
        
        $del = $this->conn->prepare($query);
            $del->execute(array($userid, $userid));
            $r = $del->fetch(PDO::FETCH_ASSOC);
            $totaltaka=$r['totaltaka'];
            $totalexp=$r['totalexp'];
            $balance=$totaltaka-$totalexp;
            return $balance;
}

public function totalbalanec($userid){
        $query = "SELECT SUM(`_taka`) AS totaltaka FROM `_sms_balance` b where _user_id=?  GROUP BY _user_id";
        
        $del = $this->conn->prepare($query);
            $del->execute(array($userid));
            $r = $del->fetch(PDO::FETCH_ASSOC);
            $totaltaka=$r['totaltaka'];
            return $totaltaka;
}

public function smsrate($userid){
        $query = "select * FROM _sms_balance where _user_id=? order by _id desc limit 1";
        
        $del = $this->conn->prepare($query);
            $del->execute(array($userid));
            $r = $del->fetch(PDO::FETCH_ASSOC);
            $rate=$r['_sms_rate'];
            return $rate;
}

public function SMSBalance($userid){
        $query = "SELECT MAX(totalsms) AS totalsms, MAX(totalsend) AS totalsend  FROM (
                SELECT SUM(`_sms_count`) AS totalsms, 0 AS totalsend FROM `_sms_balance` b WHERE _user_id=?
                UNION
                SELECT 0 AS totalsms, COUNT(`_mobile_no`) AS totalsend FROM `_sms` WHERE _user_id=?
                ) AS t";
        
        $del = $this->conn->prepare($query);
            $del->execute(array($userid,$userid));
            $r = $del->fetch(PDO::FETCH_ASSOC);
            $totalsms=$r['totalsms'];
            $totalsend=$r['totalsend'];
            return $totalsms-$totalsend;
}


 public function insertSIngelSMS($user_id, $mobile_no, $body, $smsrate){
$macaddress=$this->getMac()."no mac";
$date= date("Y-m-d H:i:s");
 $sql = "INSERT INTO `_sms` (`_id`, `_user_id`, `_mobile_no`, `_body`, `_sms_rate`, `_create_at`, `_update_at`, `_ip`, `_mac`, `_status`) 
 VALUES (:id, :user_id, :mobile_no, :body, :smsrate, :create_at, :update_at, :ip, :mac, :ststus)";
 $q = $this->conn->prepare($sql);
  //echo $user_id;
 $q->execute(array(
  ':id'=>NULL,
 ':user_id'=>$user_id,
 ':mobile_no'=>$mobile_no,
':body'=>$body,
':smsrate'=>$smsrate,
':create_at'=>$date,
':update_at'=>$date,
':ip'=>$_SERVER["REMOTE_ADDR"],
':mac'=>$macaddress,
':ststus'=>"Pending"
)) or die(print_r($q->errorInfo()));
//print_r($q);
 return true;
 }

 public function deleteData($id,$table){
 $sql="DELETE FROM $table WHERE _id=:id";
 $q = $this->conn->prepare($sql) or die("ERROR: " . implode(":", $this->conn->errorInfo()));
  echo $id;
 $q->execute(array(':id'=>$id));
 return true;
 }



/***************************SEO***************************************************/
function _fun_title($page, $slug){
    if($page=="linkdetais"){
        $event_id = $slug;
        $sql = "select ve._title
                            from _vw_link ve where ve._uniquecode='$event_id'";
        $q = $this->conn->prepare($sql);
        $q->execute();
        $result = $q->fetch();
        return preg_replace('@[/\\\]@', '',$result["_title"]);
        //return $sql;
    }
}
function _fun_desc($page, $slug){

    if($page=="linkdetais"){
        $event_id = $slug;
        $sql = "select ve._discription
                            from _vw_link ve where ve._uniquecode='$event_id'";
        $q = $this->conn->prepare($sql);
        $q->execute();
        $result = $q->fetch();
        $discription=str_replace(array('@[/\\\]@<br>','<br />'), '',$result["_discription"]);
        return preg_replace('@[/\\\]@', '', $discription);
    } 
}

function _fun_keyword($page, $slug){

    if($page=="linkdetais"){
        $event_id = $slug;
        $sql = "select ve._discription
                            from _vw_link ve where ve._uniquecode='$event_id'";
        $q = $this->conn->prepare($sql);
        $q->execute();
        $result = $q->fetch();
        $discription=str_replace(array('@[/\\\]@<br>','<br />'), '',$result["_discription"]);
        
        $words = $this->extractCommonWords($discription);
return implode(',', array_keys($words));
    } 
}


function extractCommonWords($string){
      $stopWords = array('i','a','about','an','and','are','as','at','be','by','com','de','en','for','from','how','in','is','it','la','of','on','or','that','the','this','to','was','what','when','where','who','will','with','und','the','www');
   
      $string = preg_replace('/\s\s+/i', '', $string); // replace whitespace
      $string = trim($string); // trim the string
      $string = preg_replace('/[^a-zA-Z0-9 -]/', '', $string); // only take alphanumerical characters, but keep the spaces and dashes too…
      $string = strtolower($string); // make it lowercase
   
      preg_match_all('/\b.*?\b/i', $string, $matchWords);
      $matchWords = $matchWords[0];
      
      foreach ( $matchWords as $key=>$item ) {
          if ( $item == '' || in_array(strtolower($item), $stopWords) || strlen($item) <= 3 ) {
              unset($matchWords[$key]);
          }
      }   
      $wordCountArr = array();
      if ( is_array($matchWords) ) {
          foreach ( $matchWords as $key => $val ) {
              $val = strtolower($val);
              if ( isset($wordCountArr[$val]) ) {
                  $wordCountArr[$val]++;
              } else {
                  $wordCountArr[$val] = 1;
              }
          }
      }
      arsort($wordCountArr);
      $wordCountArr = array_slice($wordCountArr, 0, 10);
      return $wordCountArr;
}
function toAscii($str, $replace=array(), $delimiter='-') {
  if( !empty($replace) ) {
    $str = str_replace((array)$replace, ' ', $str);
  }
 
  $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
  $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
  $clean = strtolower(trim($clean, '-'));
  $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
 
  return $clean;
}

function getMac(){
exec("ipconfig /all", $output);
foreach($output as $line){
if (preg_match("/(.*)Physical Address(.*)/", $line)){
$mac = $line;
$mac = str_replace("Physical Address. . . . . . . . . :","",$mac);
}
}
return $mac;
}

function sendsms($pno, $smsbody,$mask){
$username     = urlencode('infoedu');
$password = urlencode('infoedu123');
//$password = urlencode('infoedu123');

$timezone = "Asia/Dhaka";
if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
$dateStr = date('Y-m-d H:i:s');
$myTime = strtotime($dateStr);
$time = urlencode($myTime);
$mobileno = urlencode($pno);
$message_val  = urlencode($smsbody);
$mask  = urlencode($mask);
//http://portals.bd.airtel.com/msdpapi?REQUESTTYPE=SMSSubmitReq&USERNAME=01613772277&PASSWORD=info3338&MOBILENO=01734977842&MESSAGE=test&TYPE=0&ORIGIN_ADDR=e-edu.info
//$str= "?Name=".$name_val."&Password=".$password_val."&Message=".$message_val;
//$str="?username=".$username."&password=".$password."&time=".$time."&mobileno=".$mobileno."&msg_body=".$message_val;
//print $str;

$str="&USERNAME=01613772277&PASSWORD=info3338&MOBILENO=".$mobileno."&MESSAGE=".$message_val."&TYPE=0&ORIGIN_ADDR=$mask";
 $ch=curl_init();
 //curl_setopt($ch,CURLOPT_URL,'http://muthophone.com/projects/pa/sms_hit/index/'.$str);

 $r=curl_setopt($ch,CURLOPT_URL,'http://portals.bd.airtel.com/msdpapi?REQUESTTYPE=SMSSubmitReq&'.$str);
 $r.=curl_exec($ch);
 curl_close($ch);
 return $r;
}

}
?>
