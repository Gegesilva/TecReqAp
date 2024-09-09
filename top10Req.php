<?php
  header('Content-type: text/html; charset=utf-8');
  include_once("config.php");

  /* VALIDA USUARIO */
  session_start();
     include "conexaoSQL.php";
     $login = $_SESSION["login"];
     $senha = $_SESSION["password"];

	 $serie = $_POST['serie'];
	

         $sql="SELECT 
					TB01066_USUARIO Usuario,
					TB01066_SENHA Senha
				FROM 
					TB01066
				WHERE 
					TB01066_USUARIO = '$login'
					AND TB01066_SENHA = '$senha'";
     $stmt= sqlsrv_query($conn,$sql);
       while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
         $usuario = $row['Usuario'];
         $senha = $row['Senha'];
       }
       if($usuario != NULL){
   
       }else { 
         echo"<script>window.alert('É necessário fazer login!')</script>";
         echo "<script>location.href='$Url/login.php'</script>"; 
       } 	  
	   
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

   <!-- <div class="navbar-collapse" style="background-color: #DCDCDC; width: auto; height: 130px; margin-left: 2%; margin-right: 2%; margin-top: 2%; border-radius: 20px;">
     <img src="media/logo-maqlarem.png" width="150" height="120" style="margin-left: 8px; border-radius: 20px;"  class="d-inline-block align-top" alt="">
        <div class="cover-container d-flex h-100 p-3 mx-auto flex-column container-button">
          <header class="masthead mb-auto">
            <div class="inner">
            </div>
          </header> -->
          
         <!--  <div style="height: 30px; line-height: 10px; font-size: 8px;">&nbsp;</div>
            <main role="main" class="main-filtros" style="width: 90%">
              <h2 class="masthead-brand"></h2>
            </main>
          </div> 
      </div>-->

      <br>
      <!-- Tabela para consulta -->
          <div class="card overflow-auto div-detal" style="margin-left: 2%; margin-right: 2%; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px; border-radius: 20px;">
            <div class="card-header cab-detal" style="background-color: #DCDCDC; justify-content: space-between;">
                <h3>Top 10 OS  <?php /* echo $numos; */ ?></h3>
                <input type='submit' class='btnFechar' type='submit' name='contrato' onClick="window.location.reload()" value="X" >
            </div>
             
                  <?php
                      $cod = $_GET['cod'];
                      include_once("conexaoSQL.php");
                      $sql = "
                              SELECT TOP 10
                                    ISNULL(FORMAT(TB02122_DTFECHA, 'dd/MM/yyyy'), 'NÃO FINALIZADA') DataOs,
                                    FORMAT(TB02122_DATA, 'dd/MM/yyyy') DataAbertura,
                                    TB02122_CODIGO CodOs,
                                    TB02122_CONTADOR Contador,
                                    TB02122_RESONSAVEL ClienteLoc,
                                    TB02122_CODTEC CodTec,
                                    TB01024_NOME NomeTec,
                                    TB01048_NOME Defeito,
                                    TB02122_OBS Reparo,
                                    TB02115_NOME Motivo,
                                    TB02122_NUMSERIE


                                  FROM TB02122
                                    LEFT JOIN TB02116 ON TB02116_CODIGO = TB02122_CODIGO
                                    LEFT JOIN TB01048 ON TB01048_CODIGO = TB02116_DEFEITO
                                    LEFT JOIN TB01024 ON TB01024_CODIGO = TB02122_CODTEC
                                    LEFT JOIN TB02115 ON TB02115_CODIGO = TB02122_NUMOS
                                WHERE 
                                TB02122_NUMSERIE = '$serie' AND 
                                TB02122_DTFECHA IS NOT NULL

                                ORDER BY TB02122_DTFECHA DESC
                        
                      ";
                    $stmt = sqlsrv_query($conn, $sql);
                      
                      if($stmt === false)
                      {
                        die (print_r(sqlsrv_errors(), true));
                      }
                      
                    ?>   
                    
                    <table class="table table-border" style="font-size: 16px; margin-left: auto; text-align: left;">           
                    <thead>
							<tr>
								<th scope="col" style="width:;">Numero OS</th>
								<th scope="col" style="width:;">Data Abertura</th>
								<th scope="col" style="width:;">Data Fechamento</th>
								<th scope="col" style="width:;">Contador</th>                                   
								<th scope="col" style="width:;">Cliente no local</th>                                                                  
								<th scope="col" style="width:;">Técnico</th>                                                                  
								<th scope="col" style="width:;">Motivo</th>                                                                  
								<th scope="col" style="width:;">Defeito</th>                                                                  
								<th scope="col" style="width:;">Reparo realizado</th>                                                                                                                                   
							</tr>
						</thead>
				<?php
				$tabela = "";
				while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
				{
				$tabela .= "<tr>";
				$tabela .= "<td>".$row['CodOs']."</td>";
				$tabela .= "<td>".$row['DataAbertura']."</td>";
				$tabela .= "<td>".$row['DataOs']."</td>";
				$tabela .= "<td>".$row['Contador']."</td>";
				$tabela .= "<td>".$row['ClienteLoc']."</td>";
				$tabela .= "<td>".$row['NomeTec']."</td>";
				$tabela .= "<td>".$row['Motivo']."</td>";
				$tabela .= "<td>".$row['Defeito']."</td>";
				$tabela .= "<td>".$row['Reparo']."</td>";
				$tabela .= "</tr>";
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
