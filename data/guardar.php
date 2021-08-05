<?php

if (isset($_POST['submit'])) {
 
  $resultado = [
    'error' => false,
    'mensaje' => 'El pedido de ' . $_POST['nombre'] . ' ha sido agregado con éxito' 
  ];
  
  $config = include 'config.php';

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $pizza = [
        "ingredientes"  => $_POST['ingredientes'],
        "masa"          => $_POST['masa'],
        "tamano"        => $_POST['tamano'],
        "nombre"        => $_POST['nombre'],
        "direccion"     => $_POST['direccion'],
        "telefono"      => $_POST['telefono']
      ];

      $consultaSQL = "INSERT INTO pedidos (ingredientes, masa, tamano, nombre, direccion, telefono)";
      $consultaSQL .= "values (:" . implode(", :", array_keys($pizza)) . ")";

      $sentencia = $conexion->prepare($consultaSQL);
      $sentencia->execute($pizza);


  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}