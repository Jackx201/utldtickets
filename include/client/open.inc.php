<link rel="stylesheet" href="openstyle.css">
<script>var showtool = false;</script>


<?php
if(!defined('OSTCLIENTINC')) die('Access Denied!');
$info=array();
if($thisclient && $thisclient->isValid()) {
    $info=array('id'=>$thisclient->getId(),
                'name'=>$thisclient->getName(),
                'email'=>$thisclient->getEmail(),
                'phone'=>$thisclient->getPhoneNumber());
}

$info=($_POST && $errors)?Format::htmlchars($_POST):$info;

$form = null;
if (!$info['topicId']) {
    if (array_key_exists('topicId',$_GET) && preg_match('/^\d+$/',$_GET['topicId']) && Topic::lookup($_GET['topicId']))
        $info['topicId'] = intval($_GET['topicId']);
    else
        $info['topicId'] = $cfg->getDefaultTopicId();
}

$forms = array();
if ($info['topicId'] && ($topic=Topic::lookup($info['topicId']))) {
    foreach ($topic->getForms() as $F) {
        if (!$F->hasAnyVisibleFields())
            continue;
        if ($_POST) {
            $F = $F->instanciate();
            $F->isValidForClient();
        }
        $forms[] = $F->getForm();
    }
}

?>
<h1><?php echo __('Open a New Ticket');?></h1>
<p><?php echo __('Please fill in the form below to open a new ticket.');?></p>
<form id="ticketForm" method="post" action="open.php" enctype="multipart/form-data">
  <?php csrf_token(); ?>
  <input type="hidden" name="a" value="open">
  <table width="800" cellpadding="1" cellspacing="0" border="0">
    <tbody>
<?php
        if (!$thisclient) {
            $uform = UserForm::getUserForm()->getForm($_POST);
            if ($_POST) $uform->isValid();
            $uform->render(array('staff' => false, 'mode' => 'create'));
            
        }
        else { ?>
            <tr><td colspan="2"><hr /></td></tr>
        <tr><td><?php echo __('Email');?>:</td><td><?php
            echo $thisclient->getEmail(); ?></td></tr>
        <tr><td><?php echo __('Client'); ?>:</td><td><?php
            echo Format::htmlchars($thisclient->getName()); ?></td></tr>
        <?php } ?>
    </tbody>
    <tbody>
    <tr><td colspan="2"><hr />
        <div class="form-header" style="margin-bottom:0.5em">
        <b><?php echo __('Help Topic'); ?></b>
        </div>
    </td></tr>
    <tr>
        <td colspan="2">
            <select id="topicId" name="topicId" onchange="javascript:
                    var data = $(':input[name]', '#dynamic-form').serialize();
                    showtool = true;
                    var num = this.value;
                    console.log(num);
                    $.ajax(
                      'ajax.php/form/help-topic/' + this.value,
                      {
                        data: data,
                        dataType: 'json',
                        success: function(json) {
                          $('#dynamic-form').empty().append(json.html);
                          $(document.head).append(json.media);
                          //console.log(num);
                          if ( num == 2 ) { document.getElementById('inventario').style.display = 'block'; } else { document.getElementById('inventario').style.display = 'none'; }
                          //if ( num == 2 ) { document.getElementById('crearticket').style.display = 'none'; } else { document.getElementById('crearticket').style.display = 'inline'; }
                        }
                      });">
                <option value="" selected="selected">&mdash; <?php echo __('Select a Help Topic');?> &mdash;</option>
                <?php
                if($topics=Topic::getPublicHelpTopics()) {
                    //Seleccionar tema de ayuda
                    foreach($topics as $id =>$name) {
                        echo sprintf('<option value="%d" %s>%s</option>',
                                $id, ($info['topicId']==$id)?'selected="selected"':'', $name);
                    }
                } ?>
            </select>
            <font class="error">*&nbsp;<?php echo $errors['topicId']; ?></font>
        </td>
    </tr>
    </tbody>
    <tbody id="dynamic-form">
        <?php
        $options = array('mode' => 'create');
        foreach ($forms as $form) {
            include(CLIENTINC_DIR . 'templates/dynamic-form.tmpl.php');
        } 
        ?>
        
    </tbody>
    <tbody>
    <?php
    if($cfg && $cfg->isCaptchaEnabled() && (!$thisclient || !$thisclient->isValid())) {
        if($_POST && $errors && !$errors['captcha'])
            $errors['captcha']=__('Please re-enter the text again');
        ?>
    <tr class="captchaRow">
        <td class="required"><?php echo __('CAPTCHA Text');?>:</td>
        <td>
            <span class="captcha"><img src="captcha.php" border="0" align="left"></span>
            &nbsp;&nbsp;
            <input id="captcha" type="text" name="captcha" size="6" autocomplete="off">
            <em><?php echo __('Enter the text shown on the image.');?></em>
            <font class="error">*&nbsp;<?php echo $errors['captcha']; ?></font>
        </td>
    </tr>
    <?php
    } ?>
    <tr><td colspan=2>&nbsp;</td></tr>
    </tbody>
  </table>

<div id="inventario" style="display: none;">

  <!-- Inventario -->
<?php
$servername = "localhost";
$username = "root";
$password = "QpsT!ssNjK27";
$dbname = "almacen_utld";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Ha fallado la conexión con la base de Datos :( : " . $conn->connect_error);
}
echo "<h1 id='herramienta' >Herramientas Disponibles:</h1>";

$sql = "SELECT * FROM inventarioutl INNER JOIN catalogo ON inventarioutl.herramienta = catalogo.id INNER JOIN tipo_herramienta ON catalogo.tipo = tipo_herramienta.id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo (" <table width='800' class='bordered' cellpadding='1' cellspacing='0'>
    <tr style=''> <th></th> <th>ID</th> <th>Herramienta</th><th>Disponible</th><th>Categoría</th><th>Solicitar</th></tr>");
    while($row = $result->fetch_assoc()) {
        //echo print_r($row);
      echo "<tr'><td> <input style = 'display: none;' type='hidden' name = 'idusuario' value=".$info['id']."></td>
      <td>".$row["herramienta"]."</td>
      <td id = ".$row["descripcion"]." >".$row["descripcion"]."</td><td>".$row["qtyf"]."</td><td>".$row["tipo"]."</td><td> <input type='number' id = ".$row["herramienta"]." name='tentacles'
      min='1' max='1000' placeholder='0'> <button style='margin-top: 5px;' type='button' name = 'idherramienta' value=".$row["herramienta"].">Solicitar</button></td></tr>";
    }
    echo "</table>";
  } else {
    echo "No se encontraron herramientas";
  }
  $conn->close();
  ?>


<!-- Here -->
<div id="parentDiv"></div>
<div id="qtyparentDiv"></div>

<h1>Resumen de tu pedido:</h1>
<textarea class="area" readonly name="area" id="summary" cols="30" rows="10"></textarea>


  
  <!-- Inventario -->
  </div>

<hr/>
  <p class="buttons" style="text-align:center;">
        <input type="submit" id="crearticket" value="<?php echo __('Create Ticket');?>">
        <input type="reset" name="reset" value="<?php echo __('Reset');?>">
        <input type="button" name="cancel" value="<?php echo __('Cancel'); ?>" onclick="javascript:
            $('.richtext').each(function() {
                var redactor = $(this).data('redactor');
                if (redactor && redactor.opts.draftDelete)
                    redactor.plugin.draft.deleteDraft();
            });
            window.location.href='index.php';">
  </p>
</form>

<script>
/* Alcanzamos todos los elementos button que haya*/
var herramientas = [];
var cantidades = [];
const allButtons = document.querySelectorAll("button");

/*
  *Asignamos el listener a todos los button
  *OJO: con esto no hace falta poner la función in-line en cada button
  *como hacías al principio. Lo cual además es una mala práctica
 */
allButtons.forEach(
  function(button) {
    button.addEventListener("click", copiarDatos, false);
  }
);

// var mTextArea=document.getElementsByClassName('area')[0];

function copiarDatos() {
    
  /*
    Creamos una referencia al padre del botón
    que en este caso será el elemento tr
    Por lo general es una buena práctica crear referencias a los elementos
  */
  var theParent=event.target.parentNode.parentNode;
  /*
    *Obtenemos el valor de la herramienta
    *que está en la celda 2. Se usa el índice 1
    *porque los índices empiezan por 0
    *Según el tipo de elemento, deberá usarse textContent o value o lo que sea
  */
  var mHerramienta = theParent.cells[2].textContent;

    var idtoadd = theParent.cells[1].textContent;
    herramientas.push(idtoadd);
    console.log(herramientas);

    var input = document.createElement("input");
    var parent = document.getElementById("parentDiv");
    input.type = "hidden";
    input.name = "array[]";
    input.value = idtoadd;
    parent.appendChild(input);




  //console.log(JSON.stringify(herramientas));


  /*
    *Obtenemos el valor del input, que está en la celda 5
    *Nótese que aquí se usa children[0] porque
    *tienes varios elementos en esa celda
    *y se usa value porque es un input
  */

  var mCantidad = theParent.cells[5].children[0].value;
  var qtytoadd = theParent.cells[5].children[0].value;
  if(qtytoadd == "")
  {
    qtytoadd = 1;
  }
  cantidades.push(qtytoadd);
  console.log(cantidades);

  var qtyinput = document.createElement("input");
  var qtyparentDiv = document.getElementById("qtyparentDiv");
  qtyinput.type = "hidden";
  qtyinput.name = "qtyarray[]";
  qtyinput.value = qtytoadd;
  parent.appendChild(qtyinput);
  
  
  document.getElementsByClassName('area')[0].textContent += `${mHerramienta} \t${mCantidad}\n`;
}

</script>


