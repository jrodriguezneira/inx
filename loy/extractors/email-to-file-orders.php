<?php

//echo "hola";

$server = '{imap.gmail.com:993/imap/ssl/novalidate-cert}orders';
$username = 'topoagorax@gmail.com';
$password = 'zuzkovzhgtdmoqdc';
$imap = imap_open($server, $username, $password) or die("imap connection error");

$message_count = imap_num_msg($imap);
//$message_count = $message_count ;
//echo $message_count. "\n";

for ($m = $message_count; $m <= $message_count; ++$m){
  //  for ($m = 988; $m <= 1032; ++$m){
   
        $header = imap_header($imap, $m);
        //print_r($header);

        $email[$m]['from'] = $header->from[0]->mailbox.'@'.$header->from[0]->host;
        $email[$m]['fromaddress'] = $header->from[0]->personal; 
        $email[$m]['to'] = $header->to[0]->mailbox;
        $email[$m]['subject'] = $header->subject;
        $email[$m]['message_id'] = $header->message_id;
        $email[$m]['date'] = $header->udate;

        $from = $email[$m]['fromaddress'];
        $from_email = $email[$m]['from'];
        $to = $email[$m]['to'];
        $subject = $email[$m]['subject'];

        $structure = imap_fetchstructure($imap, $m);

        $attachments = array();
        if(isset($structure->parts) && count($structure->parts)) {

            for($i = 0; $i < count($structure->parts); $i++) {

                $attachments[$i] = array(
                    'is_attachment' => false,
                    'filename' => '',
                    'name' => '',
                    'attachment' => ''
                );

                if($structure->parts[$i]->ifdparameters) {
                    foreach($structure->parts[$i]->dparameters as $object) {
                        if(strtolower($object->attribute) == 'filename') {
                            $attachments[$i]['is_attachment'] = true;
                            $attachments[$i]['filename'] = $object->value;
                        }
                    }
                }

                if($structure->parts[$i]->ifparameters) {
                    foreach($structure->parts[$i]->parameters as $object) {
                        if(strtolower($object->attribute) == 'name') {
                            $attachments[$i]['is_attachment'] = true;
                            $attachments[$i]['name'] = $object->value;
                        }
                    }
                }

                if($attachments[$i]['is_attachment']) {
                    $attachments[$i]['attachment'] = imap_fetchbody($imap, $m, $i+1);
                    if($structure->parts[$i]->encoding == 3) { // 3 = BASE64
                        $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                    }
                    elseif($structure->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
                        $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                    }
                }
            }
        }
        //$dir="public_html/inx/loy/excel/";
        foreach ($attachments as $key => $attachment) {
            $name = $attachment['name'];
            $contents = $attachment['attachment'];
            file_put_contents("/home2/stagierv/sales/".$name, $contents);


        }
	echo "Email downloaded";
    //echo $name. "\n";
}


imap_close($imap);


?>
