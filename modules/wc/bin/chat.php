<?php
define( '_VALID_SSTARS_', 1 );
require_once "../../../config.php";
$c="<html>\n";
$c.="<head>\n";
$c.="<link rel='stylesheet' href='".$wb."css/css.css' type='text/css'>\n";
$c.="<title>".$title."</title>\n";
$c.="<meta http-equiv='refresh' content='60'>\n";
$c.="<body>\n";

require_once $GLOBALS['dr']."classes/form/create_form.php";

require_once $GLOBALS['dr']."modules/wc/classes/chat_id.php";
require_once $GLOBALS['dr']."modules/wc/functions/browse/browse_chat.php";

if (ISSET($_POST['message'])) {
	$ci=new ChatID;
	$ci->SetVariable("message",$_POST['message']);
	$ci->Add();
}
//$c.="Welcome to the chat";
$form=new CreateForm;
$form->SetCredentials("chat.php","post","chat");
//$form->Header("nuvola/32x32/apps/kcmdf.png","Fixtures");
$form->Input("","message","","","","","10");
//$form->Submit("Save","FormSubmit");
$c.=$form->DrawForm();

$c.=BrowseChat();

echo $c;

?>