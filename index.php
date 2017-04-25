<?php 

ob_start();

$API_KEY = 'توکن';
##------------------------------##
define('API_KEY',$API_KEY);
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
 function sendmessage($chat_id, $text, $model){
	bot('sendMessage',[
	'chat_id'=>$chat_id,
	'text'=>$text,
	'parse_mode'=>$mode
	]);
	}
	function sendaction($chat_id, $action){
	bot('sendchataction',[
	'chat_id'=>$chat_id,
	'action'=>$action
	]);
	}
	function Forward($KojaShe,$AzKoja,$KodomMSG)
{
    bot('ForwardMessage',[
        'chat_id'=>$KojaShe,
        'from_chat_id'=>$AzKoja,
        'message_id'=>$KodomMSG
    ]);
}
	function save($filename,$TXTdata)
{
    $myfile = fopen($filename, "w") or die("Unable to open file!");
    fwrite($myfile, "$TXTdata");
    fclose($myfile);
}
	//====================ᵗᶦᵏᵃᵖᵖ======================//
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$chat_id = $message->chat->id;
$from_id = $message->from->id;
$text = $message->text;
$ADMIN = 304840620;
$ali = file_get_contents("data/".$from_id."/ali.txt");
$mtn = file_get_contents("data/".$from_id."/mtn.txt");
//====================ᵗᶦᵏᵃᵖᵖ======================//
if(preg_match('/^\/([Ss]tart)/',$text)){
 if (!file_exists("data/$from_id/ali.txt")) {
        mkdir("data/$from_id");
        save("data/$from_id/ali.txt","no");
          $myfile2 = fopen("data/users.txt", "a") or die("Unable to open file!");
        fwrite($myfile2, "$from_id\n");
        fclose($myfile2);
    }
sendaction($chat_id, typing);
        bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' =>"مرحبا بك في بوت تغيير الاسم
ان طريقة استخدامي سهلة جدا,كل ما عليك هو ارسال كلمة /setname لظبط الاسم الافتراضي
ثم ارسال ملفات و سأقوم بتغيير الاسم تلقائيا",
                'parse_mode'=>$mode,
      'reply_markup'=>json_encode([
            'inline_keyboard'=>[
              [
              ['text'=>"المطور",'url'=>"http://telegram.me/TH3_Developer"],['text'=>"تابع جديدنا",'url'=>"http://telegram.me/Aleppo_Team"]
              ]
              ]
        ])
            ]);
        }

//====================ᵗᶦᵏᵃᵖᵖ======================//
elseif($text == '/de'){
sendaction($chat_id, typing);
        bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' =>"تم الانشاء بواسطة : 
@TH3_Developer
تابع جديدنا : 
@Aleppo_Team",
            ]);
        }
//====================ᵗᶦᵏᵃᵖᵖ======================//
elseif($text == "/panel" && $from_id == $ADMIN){
sendaction($chat_id, typing);
        bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' =>"مرحبا بك ايها المشرف في قائمة الادراة",
                'parse_mode'=>'html',
      'reply_markup'=>json_encode([
            'keyboard'=>[
              [
              ['text'=>"احصائيات"],['text'=>"البث"]
              ],
              ],'resize_keyboard'=>true
        ])
            ]);
        }
elseif($text == "آمار" && $from_id == $ADMIN){
	sendaction($chat_id,'typing');
    $user = file_get_contents("data/users.txt");
    $member_id = explode("\n",$user);
    $member_count = count($member_id) -1;
	sendmessage($chat_id , " احصائيات المستخدم : $member_count" , "html");
}
elseif($text == "البث" && $from_id == $ADMIN){
    save("data/$from_id/ali.txt","bc");
	sendaction($chat_id,'typing');
	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"لارسال رسالة في شكل نص :",
    'parse_mode'=>'html',
    'reply_markup'=>json_encode([
      'keyboard'=>[
	  [['text'=>'/panel']],
      ],'resize_keyboard'=>true])
  ]);
}
elseif($ali == "bc" && $from_id == $ADMIN){
    save("data/$from_id/ali.txt","no");
	SendAction($chat_id,'typing');
	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم ارسال الرسالة",
  ]);
	$all_member = fopen( "data/users.txt", "r");
		while( !feof( $all_member)) {
 			$user = fgets( $all_member);
			SendMessage($user,$text,"html");
		}
}
//====================ᵗᶦᵏᵃᵖᵖ======================//
elseif($text == '/setname'){
    save("data/$from_id/ali.txt","ali");
	sendaction($chat_id,'typing');
	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"حسنا،يا عزيزي، هل ترغب في تغيير اسم الملف إلى ما تريد
لا ننسى تنسيق الملف الصحيح
اختر إلى هذه الأشكال:
APK، mp3، mp4،ogg ........
مثلا
tikapp.apk",
  ]);
}
elseif($ali == "ali"){
    save("data/$from_id/ali.txt","create bot13");
    save("data/$from_id/mtn.txt",$text);
	sendaction($chat_id,'typing');
	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"الرجاء ارسال الملف",
  ]);
}
elseif(isset($message->document)){
$document = $message->document;
$file = $document->file_id;
      $get = bot('getfile',['file_id'=>$file]);
      $patch = $get->result->file_path;
      file_put_contents("$mtn",file_get_contents('https://api.telegram.org/file/bot'.$API_KEY.'/'.$patch));
sendaction($chat_id,'typing');
		bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"Please wait \n ًانتظر قليلا",
  ]);
sendaction($chat_id,'upload_document');
bot('senddocument',[
    'chat_id'=>$chat_id,
    'document'=>new CURLFile("$mtn"),
  ]);
}

				?>
