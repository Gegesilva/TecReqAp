<?php
  header('Content-type: text/html; charset=utf-8');
  include_once("config.php");

  /* dados login */
  session_start();
  include "conexaoSQL.php";
  $login = $_SESSION["login"];
  $senha = $_SESSION["password"];
      $sql="SELECT 
              TB01066_USUARIO Usuario,
              TB01066_SENHA Senha,
              TB01066_TIPO Tipo
            FROM 
              TB01066
            WHERE 
            TB01066_USUARIO = '$login'
            AND TB01066_SENHA = '$senha'";
  $stmt= sqlsrv_query($conn,$sql);
    while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
      $usuario = $row['Usuario'];
      $senha = $row['Senha'];
      $tipo = $row['Tipo'];
    }
    if($usuario != NULL){

    }else { 
      echo"<script>window.alert('É necessário fazer login!')</script>";
      echo "<script>location.href='$Url/login.php'</script>"; 
    } 


  $numreq = $_POST['numreq'];
?>
<!doctype html>
<html lang="en">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

      <title>DATABIT</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
      <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/cover/">
      <link  rel ="folha de estilo" href ="css/bootstrap-multiselect.css" type =" text/css ">
      <link rel="stylesheet" href="css/styleProd.css">
      <link rel="stylesheet" href="css/style.css">

      <!-- Bootstrap core CSS -->
      <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

      <!-- Custom styles for this template -->
      <link href="cover.css" rel="stylesheet">
      <script>
        html{
          overflow-y: auto;
        }
      </script>
    </head>

  <body class="text-center capa">


      <br>
      <!-- Tabela para consulta -->
          <div class="card overflow-auto div-detal" style="margin-left: 2%; margin-right: 2%; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px; border-radius: 20px;">
            <div class="card-header cab-detal" style="background-color: #DCDCDC; justify-content: space-between;">
                <h3>Requisição <?php /* echo $numos;  */?></h3>
                <input type='submit' class='btnFechar' type='submit' name='contrato' onClick="window.location.reload()" value="X" >
            </div>
             
                  <?php
                      $cod = $_GET['cod'];
                      include_once("conexaoSQL.php");
                      $sql = "
                      SELECT DISTINCT
                          TB02021_CODIGO Req,
                          FORMAT(TB02022_DTCAD, 'dd/MM/yyyy hh:mm:ss') DtAbert,
                          TB02021_CODEMP+' - '+TB01007_NOME Empresa,
                          TB02021_CONTRATO Contrato,
                          TB02021_CODCLI+' - '+TB01008_NOME  Cliente,
                          TB02096_CODMOTO+' - '+TB01077_NOME Motorista,
                          TB02021_STATUS+' - '+TB01021_NOME Status,
                          CONCAT(TB02176_NOME, ' - ', TB02176_END,', ', TB02176_NUM) SiteEndereco,
                          STRING_AGG(CONCAT(CAST(TB02022_QTPROD AS INT),'x ',TB01010_NOME), ' + ') Produtos,
                          (SELECT TOP 1 CAST(TB02130_OBS AS VARCHAR(MAX)) FROM TB02130 WHERE TB02130_CODIGO = TB02021_CODIGO AND TB02130_STATUS = TB02021_STATUS ORDER BY TB02130_DATA DESC) obs
                     FROM TB02021
						              LEFT JOIN TB02022 ON TB02022_CODIGO = TB02021_CODIGO
                          LEFT JOIN TB01008 ON TB01008_CODIGO = TB02021_CODCLI
                          LEFT JOIN TB01010 ON TB01010_CODIGO = TB02022_PRODUTO
						              LEFT JOIN TB02096 ON TB02096_CODIGO = TB02021_CODIGO
                          LEFT JOIN TB01007 ON TB01007_CODIGO = TB02021_CODEMP
                          LEFT JOIN TB01077 ON TB01077_CODIGO = TB02096_CODMOTO
                          LEFT JOIN TB01002 ON TB01002_CODIGO = TB01010_GRUPO
                          LEFT JOIN TB01021 ON TB01021_CODIGO = TB02021_STATUS
                          LEFT JOIN TB02176 ON TB02176_CODIGO = TB02021_CODSITE
                      WHERE TB02021_CODIGO = '$numreq'

                      GROUP BY 
                        TB02021_CODIGO ,
                        TB02022_DTCAD, 
                        TB02021_CODEMP,
                        TB01007_NOME,
                        TB02021_CONTRATO,
                        TB02021_CODCLI,
                        TB01008_NOME,
                        TB02096_CODMOTO,
                        TB01077_NOME,
                        TB02021_STATUS,
                        TB01021_NOME,
                        TB02176_NOME,
                        TB02176_END,
                        TB02176_NUM,
                        CAST(TB02021_OBS AS VARCHAR(MAX))
                        
                      ";
                    $stmt = sqlsrv_query($conn, $sql);
                      
                      if($stmt === false)
                      {
                        die (print_r(sqlsrv_errors(), true));
                      }
                      
                    ?>   
                    
                    <table class="table table-borderless " style="font-size: 16px; margin-left: auto; text-align: left; padding: 10rem;">           
                    <?php
                    $tabela = "";

                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
                    {
                          $tabela .= "<tbody><tr>";
                            $tabela .= "<td><label class='labOS'><b>Requisição:</b></label><br>
                                            <div class='divOS'>$row[Req]</div>
                                        </td>";
                            $tabela .= "<td><label class='labOS'><b>Contrato:</b></label><br>
                                          <div class='divOS'>$row[Contrato]</div>
                                        </td>";
                            $tabela .= "<td><label class='labOS'><b>End:</b></label><br>
                                          <div class='divOS'>$row[SiteEndereco]</div>
                                      </td>";
                          $tabela .= "</tr>";


                          $tabela .= "<tr>";
                            $tabela .= "<td><label class='labOS'><b>Status:</b></label><br>
                                        <div class='divOS'>$row[Status]</div>
                                      </td>";
                            $tabela .= "<td><label class='labOS'><b>Produtos:</b></label><br>
                                        <div class='divOS'>$row[Produtos]</div>
                                      </td>";
                            $tabela .= "<td><label class='labOS'><b>Obs:</b></label><br>
                                          <div class='divOS'>$row[obs]</div>
                                        </td>";
                          $tabela .= "</tr>";


                          $tabela .= "<tr>";
                          $tabela .= "<td><label class='labOS'><b>Nome Cliente:</b></label><br>
                                            <div class='divOS'>$row[Cliente]</div>
                                          </td>";
                            $tabela .= "<td><label class='labOS'><b>Técnico:</b></label><br>
                                          <div class='divOS'>$row[Motorista]</div>
                                        </td>";
                            $tabela .= "</tr>";
                            $tabela .= "<tr>";
                            
                          $tabela .= "</tr>";
                          $tabela .= "<tr>";
                        
                          $tabela .= "</tr></tbody>";
                    }
                      $tabela .= "</table>";
                      print($tabela);
                    ?>  
                </div>
               </div>            
              </div>
            <script src="js/jQuery/jquery-3.5.1.min.js" charset="utf-8"></script>
            <script type ="text/javascript" src ="js/bootstrap-multiselect.js" ></script>
            <script src="js/script.js" charset="utf-8"></script>
            <script>
              $(document).ready(function() {
               /*  $('#contrato').multiselect(); */
              })
            </script>
   </body>
</html>
