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

$sql = "SELECT * FROM catalogo INNER JOIN tipo_herramienta ON catalogo.tipo = tipo_herramienta.id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo (" <table width='800' class='bordered' cellpadding='1' cellspacing='0'>
    <tr style=''><th>Herramienta</th><th>Codigo</th><th>Serie</th><th>Categoria</th></tr>");
    while($row = $result->fetch_assoc()) {
      echo "<tr'><td>".$row["descripcion"]."</td><td>".$row["codigo"]."</td><td>".$row["numserie"]."</td><td>".$row["tipo"]."</td></tr>";
    }
    echo "</table>";
  } else {
    echo "No se encontraron herramientas";
  }
  $conn->close();
  ?>
  <!-- Inventario -->







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
    <tr style=''><th>Herramienta</th><th>Disponible</th><th>Categoría</th><th>Solicitar</th></tr>");
    while($row = $result->fetch_assoc()) {
      echo "<tr'><td>".$row["descripcion"]."</td><td>".$row["qtyf"]."</td><td>".$row["tipo"]."</td><td>  <button type='Pedir'>Pedir</button> </td></tr>";
    }
    echo "</table>";
  } else {
    echo "No se encontraron herramientas";
  }
  $conn->close();
  ?>
  <!-- Inventario -->





  //PEDIDOS
    $topicid = $_POST['topicId'];
    if($topicid == 2) 
    {
                $idusuario = $_POST['idusuario'];
                $idherramienta =  $_POST['idherramienta'];
                $servername = "localhost";
                $username = "root";
                $password = "QpsT!ssNjK27";
                $dbname = "almacen_utld";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                die("Ha fallado la conexión con la base de Datos :( : " . $conn->connect_error);
                }

                $sql = "INSERT INTO peticiones (solicitante, fecha)
                VALUES ('$idusuario', NOW())";
                $result = $conn->query($sql);

                

                if ($conn->query($sql) === TRUE) {
                    die ("New record created successfully");
                  } else {
                    die ("Error: " . $sql . "<br>" . $conn->error);
                  }

                $conn->close();
    }
    // PEDIDOS









    $sql = "INSERT INTO peticiones (solicitante, fecha)
                 VALUES ('$idusuario', NOW())";
                 $result = $conn->query($sql);

                $sql1 = "INSERT INTO detalle_peticion (herramienta, qty_peticion, peticion_id)
                VALUES ('$idherramienta', '$qty', '$peticionid')";
                $result = $conn->query($sql1);




                $sql = "INSERT INTO peticiones (solicitante, fecha)
                 VALUES ('$idusuario', NOW());";
                 $result = $conn->query($sql);



                 $sql1 = "INSERT INTO detalle_peticion (herramienta, qty_peticion, peticion_id)
                 VALUES ('$idherramienta', '$qty', LAST_INSERT_ID());";
                 $result1 = $conn->query($sql1);