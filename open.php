<?php
require('client.inc.php');
define('SOURCE','Web'); //Ticket source.
$ticket = null;
$errors=array();
if ($_POST) {

    $vars = $_POST;
    $vars['deptId']=$vars['emailId']=0; //Just Making sure we don't accept crap...only topicId is expected.
    if ($thisclient) {
        $vars['uid']=$thisclient->getId();
        
    } elseif($cfg->isCaptchaEnabled()) {
        if(!$_POST['captcha'])
            $errors['captcha']=__('Enter text shown on the image');
        elseif(strcmp($_SESSION['captcha'], md5(strtoupper($_POST['captcha']))))
            $errors['captcha']=sprintf('%s - %s', __('Invalid'), __('Please try again!'));
    }

    $tform = TicketForm::objects()->one()->getForm($vars);
    $messageField = $tform->getField('message');
    $attachments = $messageField->getWidget()->getAttachments();
    if (!$errors) {
        $vars['message'] = $messageField->getClean();
        if ($messageField->isAttachmentsEnabled())
            $vars['files'] = $attachments->getFiles();
    }

    // Drop the draft.. If there are validation errors, the content
    // submitted will be displayed back to the user
    Draft::deleteForNamespace('ticket.client.'.substr(session_id(), -12));
    //Ticket::create...checks for errors..
    if(($ticket=Ticket::create($vars, $errors, SOURCE))){
        $msg=__('Support ticket request created');
        // Drop session-backed form data
        unset($_SESSION[':form-data']);
        //Logged in...simply view the newly created ticket.
        if($thisclient && $thisclient->isValid()) {
            session_regenerate_id();
            session_write_close();
            @header('Location: tickets.php?id='.$ticket->getId());

                //PEDIDOS
    $topicid = $_POST['topicId'];
    if($topicid == 2) 
    {
                $arregloherramientas = $_POST["array"];
                $arreglocantidades = $_POST["qtyarray"];
                $arraylength = count($arregloherramientas);
                $herramientas = $_POST['herramientas'];
                $qty = $_POST['qty'];
                $idusuario = $_POST['idusuario'];
                $idherramienta =  $_POST['idherramienta'];
                $servername = "localhost";
                $username = "root";
                $password = "QpsT!ssNjK27";
                $dbname = "almacen_utld";
                $idticket = $ticket->getId();
                
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                die("Ha fallado la conexión con la base de Datos :( : " . $conn->connect_error);
                }
                 $sql = "INSERT INTO peticiones (solicitante, ticket_id, fecha)
                 VALUES ('$idusuario', '$idticket' ,NOW());";
                 $result = $conn->query($sql);
                 $last_id = mysqli_insert_id($conn);

                 for($i = 0; $i < $arraylength; $i++)
                 {
                    $sql1 = "INSERT INTO detalle_peticion (herramienta, qty_peticion, peticion_id)
                    VALUES ('$arregloherramientas[$i]', '$arreglocantidades[$i]', (SELECT id FROM peticiones WHERE id = '$last_id' LIMIT 1 ));";
                    $result1 = $conn->query($sql1);

                    $sql2 = "SELECT * FROM detalle_peticion";
                    $result2 = $conn->query($sql2);  
                 }
                 $sql2 = "SELECT * FROM detalle_peticion";
                 $result2 = $conn->query($sql2);
                $conn->close();
    }
    // PEDIDOS
        } else
            $ost->getCSRF()->rotate();
    }else{
        $errors['err'] = $errors['err'] ?: sprintf('%s %s',
            __('Unable to create a ticket.'),
            __('Correct any errors below and try again.'));
    }
}
//http://200.94.145.72/soporte/scp/%%7Brecipient.ticket_link%7D

//page
$nav->setActiveNav('new');
if ($cfg->isClientLoginRequired()) {
    if ($cfg->getClientRegistrationMode() == 'disabled') {
        Http::redirect('view.php');
    }
    elseif (!$thisclient) {
        require_once 'secure.inc.php';
    }
    elseif ($thisclient->isGuest()) {
        require_once 'login.php';
        exit();
    }
}

require(CLIENTINC_DIR.'header.inc.php');
if ($ticket
    && (
        (($topic = $ticket->getTopic()) && ($page = $topic->getPage()))
        || ($page = $cfg->getThankYouPage())
    )
) {
    // Thank the user and promise speedy resolution!
    echo Format::viewableImages(
        $ticket->replaceVars(
            $page->getLocalBody()
        ),
        ['type' => 'P']
    );
}
else {
    require(CLIENTINC_DIR.'open.inc.php');
}
require(CLIENTINC_DIR.'footer.inc.php');

// https://www.py4u.net/discuss/787313

?>

