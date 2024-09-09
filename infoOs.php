<?php
header('Content-type: text/html; charset=utf-8');
include_once ("config.php");

/* dados login */
session_start();
include "conexaoSQL.php";
$login = $_SESSION["login"];
$senha = $_SESSION["password"];
$sql =
  "SELECT 
      TB01066_USUARIO Usuario,
      TB01066_SENHA Senha,
      TB01066_TIPO Tipo
    FROM 
      TB01066
    WHERE 
    TB01066_USUARIO = '$login'
    AND TB01066_SENHA = '$senha'";
$stmt = sqlsrv_query($conn, $sql);
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  $usuario = $row['Usuario'];
  $senha = $row['Senha'];
  $tipo = $row['Tipo'];
}
if ($usuario != NULL) {

} else {
  echo "<script>window.alert('É necessário fazer login!')</script>";
  echo "<script>location.href='$Url/login.php'</script>";
}


$numos = $_POST['numos'];
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

  <title>MAQLAREM</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
    crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
    integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
  <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/cover/">
  <link rel="folha de estilo" href="css/bootstrap-multiselect.css" type=" text/css ">
  <link rel="stylesheet" href="css/styleProd.css">
  <link rel="stylesheet" href="css/style.css">

  <!-- Bootstrap core CSS -->
  <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="cover.css" rel="stylesheet">
  <script>
        html{
      overflow - y: auto;
    }
  </script>
</head>

<body class="text-center capa">
  <br>
  <!-- Tabela para consulta -->
  <div class="card overflow-auto div-detal"
    style="margin-left: 2%; margin-right: 2%; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px; border-radius: 20px;">
    <div class="card-header cab-detal" style="background-color: #DCDCDC; justify-content: space-between;">
      <h3>Ordem de Serviço <?php /* echo $numos;  */ ?></h3>
      <input type='submit' class='btnFechar' type='submit' name='contrato' onClick="window.location.reload()" value="X">
    </div>

    <?php
    $cod = $_GET['cod'];
    include_once ("conexaoSQL.php");
$sql = "SELECT 
            TB02115_CODIGO Os,
            FORMAT(TB02115_DTCAD, 'dd/MM/yyyy hh:mm:ss') DtAbert,
            TB02115_CODEMP+' - '+TB01007_NOME Empresa,
            TB02115_NUMSERIE Serie,
            TB02115_CONTRATO Contrato,
            TB02115_PRODUTO+' - '+TB01010_NOME Produto,
            TB02115_CODCLI+' - '+TB01008_NOME  Cliente,
            TB02115_CODTEC+' - '+TB01024_NOME Tecnico,
            TB01002_NOME Grupo,
            FORMAT(TB02115_DTFECHA, 'dd/MM/yyyy') DataFecha,
            CAST(TB02122_OBS AS VARCHAR(MAX)) Laudo,
            TB02122_CONDICAO+' - '+TB01055_NOME CondInterv,
            TB02115_STATUS+' - '+TB01073_NOME Status,
            TB02115_NOME Motivo,
            TB02115_LOCAL Local,
            STRING_AGG(TB02116_DEFEITO, ' + ') Defeito,
            STRING_AGG(TB01048_NOME, '/') DescDefeito,
            CONCAT(TB02176_NOME, ' - ', TB02176_END,', ', TB02176_NUM) SiteEndereco,
            STRING_AGG(CAST(TB02116_OBS AS VARCHAR(MAX)), ' - ') DefeitoItem

        FROM TB02115
            LEFT JOIN TB01008 ON TB01008_CODIGO = TB02115_CODCLI
            LEFT JOIN TB01010 ON TB01010_CODIGO = TB02115_PRODUTO
            LEFT JOIN TB01007 ON TB01007_CODIGO = TB02115_CODEMP
            LEFT JOIN TB01024 ON TB01024_CODIGO = TB02115_CODTEC
            LEFT JOIN TB01002 ON TB01002_CODIGO = TB01010_GRUPO
            LEFT JOIN TB02122 ON TB02122_NUMOS = TB02115_CODIGO
            LEFT JOIN TB01055 ON TB01055_CODIGO = TB02122_CONDICAO
            LEFT JOIN TB01073 ON TB01073_CODIGO = TB02115_STATUS
            LEFT JOIN TB02116 ON TB02116_CODIGO = TB02115_CODIGO
            LEFT JOIN TB01048 ON TB01048_CODIGO = TB02116_DEFEITO
            LEFT JOIN TB02176 ON TB02176_CODIGO = TB02115_CODSITE
        WHERE TB02115_CODIGO = '$numos'
        GROUP BY 
            TB02115_CODIGO,
            TB02115_DTCAD,
            TB02115_CODEMP,
            TB01007_NOME,
            TB02115_NUMSERIE,
            TB02115_CONTRATO,
            TB02115_PRODUTO,
            TB01010_NOME,
            TB02115_CODCLI,
            TB01008_NOME,
            TB02115_CODTEC,
            TB01024_NOME,
            TB01002_NOME,
            TB02115_DTFECHA,
            CAST(TB02122_OBS AS VARCHAR(MAX)),
            TB02122_CONDICAO,
            TB01055_NOME,
            TB02115_STATUS,
            TB01073_NOME,
            TB02115_NOME,
            TB02115_LOCAL,
            TB02176_NOME,
            TB02176_END,
            TB02176_NUM
        ";
    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
      die(print_r(sqlsrv_errors(), true));
    }

    ?>

    <table class="table table-borderless "
      style="font-size: 16px; margin-left: auto; text-align: left; padding: 10rem;">
      <?php
      $tabela = "";

      while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $tabela .= "<tbody><tr>";
        $tabela .= "<td><label class='labOS'><b>Ordem de serviço:</b></label><br>
                                            <div class='divOS'>$row[Os]</div>
                                        </td>";
        $tabela .= "<td><label class='labOS'><b>Dt Hora abertura:</b></label><br>
                                          <div class='divOS'>$row[DtAbert]</div>
                                        </td>";
        $tabela .= "<td><label class='labOS'><b>Motivo:</b></label><br>
                                          <div class='divOS'>$row[Motivo]</div>
                                        </td>";
        $tabela .= "<td><label class='labOS'><b>Defeito:</b></label><br>
                                        <div class='divOS'>$row[DescDefeito]</div>
                                      </td>";
        $tabela .= "<td><label class='labOS'><b>Obs Def:</b></label><br>
                                      <div class='divOS'>$row[DefeitoItem]</div>
                                    </td>";
        $tabela .= "</tr>";


        $tabela .= "<tr>";
        $tabela .= "<td><label class='labOS'><b>Serial:</b></label><br>
                                          <div class='divOS'>$row[Serie]</div>
                                        </td>";
        $tabela .= "<td><label class='labOS'><b>Contrato:</b></label><br>
                                          <div class='divOS'>$row[Contrato]</div>
                                        </td>";
        $tabela .= "<td><label class='labOS'><b>Produto:</b></label><br>
                                          <div class='divOS'>$row[Produto]</div>
                                        </td>";
        $tabela .= "<td><label class='labOS'><b>Status:</b></label><br>
                                        <div class='divOS'>$row[Status]</div>
                                      </td>";
        $tabela .= "<td><label class='labOS'><b>Laudo:</b></label><br>
                                      <div class='divOS'>$row[Laudo]</div>
                                    </td>";
        $tabela .= "</tr>";


        $tabela .= "<tr>";
        $tabela .= "<td><label class='labOS'><b>Nome Cliente:</b></label><br>
                                            <div class='divOS'>$row[Cliente]</div>
                                          </td>";
        $tabela .= "<td><label class='labOS'><b>Técnico:</b></label><br>
                                          <div class='divOS'>$row[Tecnico]</div>
                                        </td>";

        $tabela .= "<td><label class='labOS'><b>Local:</b></label><br>
                                          <div class='divOS'>$row[Local]</div>
                                        </td>";
        $tabela .= "<td><label class='labOS'><b>End:</b></label><br>
                                        <div class='divOS'>$row[SiteEndereco]</div>
                                      </td>";
        $tabela .= "</tr>";
        $tabela .= "<tr>";

        $tabela .= "</tr>";
        $tabela .= "<tr>";

        $tabela .= "</tr></tbody>";
      }
      $tabela .= "</table>";
      print ($tabela);
      ?>
  </div>
  </div>
  </div>
  <script src="js/jQuery/jquery-3.5.1.min.js" charset="utf-8"></script>
  <script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
  <script src="js/script.js" charset="utf-8"></script>
  <script>
    $(document).ready(function () {
      /*  $('#contrato').multiselect(); */
    })
  </script>
</body>
</html>