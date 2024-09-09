<?php
    header('Content-type: text/html; charset=utf-8');
	include_once ("conexaoSQL.php");
	include_once ("config.php");


  /* VALIDA USUARIO */
   session_start();

     $login = $_SESSION["login"];
     $senha = $_SESSION["password"];

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



   /* SALVA O FILTRO MOTORISTA */
	 $codMotSes2 = $_SESSION["codMotSes"];

	 if(isset($_POST["codMot"]) && $_POST["codMot"] != ''){
		 $_SESSION["codMotSes"]=$_POST["codMot"];
		 $cidade2= "";
		 $bairro2= "";
		 $estado2= "";
	 }
	 
	 $codMotPass = $_POST['codMot'];


	if(isset($codMotPass) && $codMotPass != ''){
		$codMot = $codMotPass;
	}
	
		else{
			$codMot = $codMotSes2;
		}

    if($codMotPass == '1'){
		$codMot = '';
	}

	/* SALVA O FILTRO ESTADO */
	$estadoSes2 = $_SESSION["EstadoSes"];

	if(isset($_POST["Estado"]) && $_POST["Estado"] != ''){
		$_SESSION["EstadoSes"]=$_POST["Estado"];
	}
	
	$estadoPass = $_POST['Estado'];


   if(isset($estadoPass) && $estadoPass != ''){
	   $estado = $estadoPass;
	   $nomeEstado = $estadoPass;
   }
   
   
		else if(!isset($estadoPass) || $estadoPass == ''){
			$estado = $estadoSes2;
			$nomeEstado = $estadoSes2;
		}
   

	 
	 /* SALVA O FILTRO CIDADE */
	 $cidadeSes2 = $_SESSION["CidadeSes"];

	 if(isset($_POST["Cidade"]) && $_POST["Cidade"] != ''){
		 $_SESSION["CidadeSes"]=$_POST["Cidade"];
	 }
	 
	 $cidadePass = $_POST['Cidade'];


	if(isset($cidadePass) && $cidadePass != ''){
		$cidade = $cidadePass;
		$nomeCidade = $cidadePass;
	}
	
		else if(!isset($cidadePass) || $cidadePass == ''){
			$cidade = $cidadeSes2;
			$nomeCidade = $cidadeSes2;
		}
	

	/* SALVA O FILTRO BAIRRO */
	$bairroSes2 = $_SESSION["BairroSes"];

	if(isset($_POST["Bairro"]) && $_POST["Bairro"] != ''){
		$_SESSION["BairroSes"]=$_POST["Bairro"];
	}
	
	$bairroPass = $_POST['Bairro'];


   if(isset($bairroPass) && $bairroPass != ''){
	   $bairro = $bairroPass;
   }
   
   
		else if(!isset($bairroPass) || $bairroPass == ''){
			$bairro = $bairroSes2;
		}
   


	 $req = $_POST['req'];

	 $motoristaLinha = $_POST['motoristaLinha'];

	 $motoristaTdReq = $_POST['motoristaTdReq'];

	 $reqLinha = $_POST['reqLinha'];

	 $filtroCidade = $_POST['FiltroCidade'];

	 $reqLinhaRet = $_POST['reqLinhaRet'];

	 $obs = $_POST['obs'];


	 /* VARIAVEIS E CONDICIONAIS DO FILTRO MOT */
	$codMotInput = $_POST['codMotInput'];
	$codMotPost = $codMot;
   
	if(isset($codMotPost) && $codMotPost != '1'){
	   $codMot2 = "AND TB02096_CODMOTO = '$codMotInput'";
	   $codMotInput = $codMotPost;
	}else{
	   if($codMotInput == "" || $codMotPost == '1' || $codMotPass == '1'){
		   $codMot2 = "";
		   $nomeMot = "Todos";
	   }else{
		   $codMot2 = "AND TB02096_CODMOTO = '$codMotInput'";
	   }
	} 

	 /* VARIAVEIS E CONDICIONAIS DO FILTRO ESTADO */
	 $estadoInput = $_POST['estadoInput'];
	 $estadoPost = $estado;
	
	if(isset($estadoPost) && $estadoPost != '1'){
	   $estado2 = "AND TB02176_ESTADO = '$estadoPost'";
	   $estadoInput = $estadoPost;
	}else{
	   if($estadoInput == "" || $estadoPost == '1' || $estadoPass == '1'){
		   $estado2 = "";
	   }else{
		   $estado2 = "AND TB02176_ESTADO = '$estadoInput'";
	   }
	} 



	/* VARIAVEIS E CONDICIONAIS DO FILTRO CIDADE */
	  $cidadeInput = $_POST['cidadeInput'];
	  $cidadePost = $cidade;
	 
	 if(isset($cidadePost) && $cidadePost != '1'){
		$cidade2 = "AND TB02176_CIDADE = '$cidadePost'";
		$cidadeInput = $cidadePost;
	 }else{
		if($cidadeInput == "" || $cidadePost == '1' || $cidadePass == '1'){
			$cidade2 = "";
			$nomeCidade = "Todas";
		}else{
			$cidade2 = "AND TB02176_CIDADE = '$cidadeInput'";
		}
	 } 


	 /* VARIAVEIS E CONDICIONAIS DO FILTRO BAIRRO */
	 $bairroInput = $_POST['bairroInput'];
	 $bairroPost = $bairro;
	 
	 if(isset($bairroPost) && $bairroPost != '1'){
		$bairro2 = "AND TB02176_BAIRRO = '$bairroPost'";
		$bairroInput = $bairroPost;
	 }else{
		if($bairroInput == "" || $bairroPost == '1' || $bairroPass == '1'){
			$bairro2 = "";
		}else{
			$bairro2 = "AND TB02176_BAIRRO = '$bairroInput'";
		}
	 }

	 


	 /* CONDICIONAIS PARA BOTÃO EM MASSA */
	 $cidadeBotao = $_POST['cidadeBotao'];
	 $bairroBotao = $_POST['bairroBotao'];

	 if(isset($cidadeInput) && isset($filtroCidade)){
		$btnEnvTodos = "<input type='submit' form='formTodos' class='btn btn-warning' value='Enviar Todos'/>";

		if($bairroBotao != 1){
			
			$bairro2;
			/* $estado2; */
		}

	 }else{
		$btnEnvTodos = "";
	 }


	 /* PEGA NOME MOTORISTA */
	 if(isset($codMot)){
		$sql="
			SELECT 
				TB01077_NOME NomeMot
			FROM TB01077
			WHERE TB01077_CODIGO = '$codMot'
	";
	$stmt= sqlsrv_query($conn,$sql);
	while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
		$nomeMot = $row['NomeMot'];
	}
	}else{
		/* $nomeTec = "Selecione técnico"; */
	}


	 /* LIMPAR BOTÃO ENV TODOS */
     if(isset($_POST["codMot"]) && $_POST["codMot"] != ''){
		
			$btnEnvTodos= "";
		}


    /* ENVIA REQ PARA O MOTORISTA */
	   if(isset($req)){
		/* CONFERE SE JÁ REGISTRO NO 2096*/
        $sql="
			SELECT 
				1 Existe
			FROM TB02096
			WHERE TB02096_CODIGO = '$req'
		";
		$stmt= sqlsrv_query($conn,$sql);
		while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
			$existe = $row['Existe'];
		} 


		if($existe == '1'){
			$sql = "UPDATE 
					TB02096
				SET 
					TB02096_CODMOTO = '$codMot',
					TB02096_DTSAIDA = GETDATE(),
					TB02096_CONFERIDO = '$login'
				WHERE
					TB02096_CODIGO = '$req'
			";
			$stmt= sqlsrv_query($conn,$sql);

		}else{
			$sql = "INSERT INTO TB02096
					(TB02096_CODIGO,
					TB02096_TIPO,
					TB02096_MOTORISTA,
					TB02096_CODMOTO, 
					TB02096_DTENTREGA)
					VALUES (
							'$req',
							'V',
							'$nomeMot',
							'$codMot',
							GETDATE()
							)
					";
			$stmt= sqlsrv_query($conn,$sql);
		}

		$sql = "
		
		UPDATE TB02021 
		SET 
			TB02021_STATUS = '$StatusComMot',
			TB02021_DTALT = GETDATE(),
			TB02021_OPALT = '$login'
		WHERE TB02021_CODIGO = '$req'


		INSERT INTO 
			TB02130 (
					TB02130_CODIGO,
					TB02130_USER,
					--TB02130_OBS,
					TB02130_DATA,
					TB02130_DATAEXEC,
					TB02130_STATUS,
					TB02130_TIPO,
					TB02130_NOMETEC,
					TB02130_CODCAD,
					TB02130_CODEMP,
					TB02130_NOME,
					TB02130_CODTEC
					)
					(SELECT 
					'$req',
					'$login',
					--'APP ROT REQ',
					GETDATE(), 
					GETDATE(), 
					'$StatusComMot',
					'V',
					'$nomeMot',
					TB02021_CODCLI,
					TB02021_CODEMP,
					(SELECT TB01021_NOME FROM TB01021 WHERE TB01021_CODIGO = '$StatusComMot'),
					'$codMot'
					FROM TB02021
					WHERE TB02021_CODIGO = '$req'
					AND NOT EXISTS (SELECT * FROM TB02130 WHERE TB02130_CODIGO = '$req' AND TB02130_STATUS = '$StatusComMot')
				) 

				UPDATE TB02130
				SET TB02130_CODTEC = '$codMot',
					TB02130_NOMETEC = '$nomeMot',
					TB02130_USER = '$login',
					TB02130_DATA = GETDATE(),
					TB02130_OBS = 'APP ROT REQ'
				WHERE TB02130_CODIGO = '$req'
					AND TB02130_STATUS = '$StatusComMot'
		";
	  }

	 $stmt = sqlsrv_query($conn, $sql);
 

	 /* CONDICIONAIS MUDA MOTORISTA EM LINHA */
	 if(isset($motoristaLinha)){
		$sql1 = "
			UPDATE 
				TB02096
			SET 
				TB02096_CODMOTO = '$motoristaLinha',
				TB02096_DTSAIDA = GETDATE(),
				TB02096_CONFERIDO = '$login'
			WHERE
				TB02096_CODIGO = '$reqLinha'
			";
	 }
	 $stmt = sqlsrv_query($conn, $sql1);


	 /* CONDICIONAIS MUDA TODAS OS DE UM MOTORISTA PARA OUTRO MOTORISTA */
	 if(isset($motoristaTdReq)){
		$sql1 = "
			UPDATE 
				TB02096 
			SET 
				TB02096_CODMOTO = '$motoristaTdReq',
				TB02096_DTSAIDA = GETDATE(),
				TB02096_CONFERIDO = '$login'
			WHERE
				TB02096_CODMOTO = '$codMot'
			";
	 }
	 $stmt = sqlsrv_query($conn, $sql1);



	 /* DEVOLVE PARA A ROTERIZAÇÃO */
	 if(isset($reqLinhaRet)){
		$sql1 = "
			UPDATE 
				TB02096
			SET 
				TB02096_CODMOTO = '$CodMotGeral',
				TB02096_DTSAIDA = GETDATE(),
				TB02096_CONFERIDO = '$login'
			WHERE
				TB02096_CODIGO = '$reqLinhaRet'


			UPDATE TB02021 
			SET 
				TB02021_STATUS = '$StatusRot',
				TB02021_DTALT = GETDATE(),
				TB02021_OPALT = '$login',
				TB02021_OBS = '$obs'
			WHERE TB02021_CODIGO = '$reqLinhaRet'
 

			UPDATE TB02130
			SET TB02130_CODTEC = '$codMot',
				TB02130_NOMETEC = '$nomeMot',
				TB02130_USER = '$login',
				TB02130_DATA = GETDATE(),
				TB02130_OBS = '$obs'
			WHERE TB02130_CODIGO = '$reqLinhaRet'
				AND TB02130_STATUS = '$StatusRot'

			";        
	 }
	 $stmt = sqlsrv_query($conn, $sql1);



	 /* UPDATE EM MASSA POR CIDADE/BAIRRO */
	 if($cidadeBotao != NULL && $cidadeBotao != ""){
		$sql = "
		DECLARE @CODIGO VARCHAR(6);
	
		BEGIN
		SET NOCOUNT ON 
		DECLARE CURSOR_UP_MASSA_END CURSOR FOR
	
		SELECT 
			TB02021_CODIGO
		FROM TB02021
		LEFT JOIN TB02096 ON TB02096_CODIGO = TB02021_CODIGO
		LEFT JOIN TB02176 ON TB02176_CODIGO = TB02021_CODSITE
		WHERE 
			TB02176_CIDADE = '$cidadeBotao'
			AND TB02021_STATUS IN ($StatusAguardMot)
			$bairro2
	
			OPEN CURSOR_UP_MASSA_END FETCH  CURSOR_UP_MASSA_END
			INTO @CODIGO
			WHILE @@FETCH_STATUS = 0
		BEGIN
			 IF EXISTS (SELECT * FROM TB02096 WHERE TB02096_CODIGO = @CODIGO)
			  	UPDATE 
					TB02096
				SET 
					TB02096_CODMOTO = '$codMot',
					TB02096_DTSAIDA = GETDATE(),
					TB02096_CONFERIDO = '$login',
					TB02096_MOTORISTA = '$nomeMot'
				WHERE
					TB02096_CODIGO = @CODIGO

			 IF EXISTS (SELECT * FROM TB02096 WHERE TB02096_CODIGO = @CODIGO)
				UPDATE TB02130
				SET TB02130_CODTEC = '$codMot',
					TB02130_NOMETEC = '$nomeMot',
					TB02130_DATA = GETDATE()
				WHERE TB02130_CODIGO = @CODIGO
					AND TB02130_STATUS = '$StatusComMot'
		      
			 IF NOT EXISTS (SELECT * FROM TB02096 WHERE TB02096_CODIGO = @CODIGO)
			   INSERT INTO TB02096
				(TB02096_CODIGO,
				TB02096_TIPO,
				TB02096_MOTORISTA,
				TB02096_CODMOTO, 
				TB02096_DTENTREGA)
				VALUES (
						@CODIGO,
						'V',
						'$nomeMot',
						'$codMot',
						GETDATE()
						)
				UPDATE TB02021 
					SET 
						TB02021_STATUS = '$StatusComMot',
						TB02021_DTALT = GETDATE(),
						TB02021_OPALT = '$login'
					WHERE TB02021_CODIGO = @CODIGO
			   
				 INSERT INTO 
					TB02130 (
							TB02130_CODIGO,
							TB02130_USER,
							--TB02130_OBS,
							TB02130_DATA,
							TB02130_DATAEXEC,
							TB02130_STATUS,
							TB02130_TIPO,
							TB02130_NOMETEC,
							TB02130_CODCAD,
							TB02130_CODEMP,
							TB02130_NOME,
							TB02130_CODTEC
							)
							(SELECT 
							@CODIGO,
							'$login',
							--'APP ROT REQ',
							GETDATE(), 
							GETDATE(), 
							'$StatusComMot',
							'V',
							TB01077_NOME,
							TB02021_CODCLI,
							TB02021_CODEMP,
							(SELECT TB01021_NOME FROM TB01021 WHERE TB01021_CODIGO = '$StatusComMot'),
							'0091'
							FROM TB02021
							LEFT JOIN TB01077 ON TB01077_CODIGO = '$codMot'
							LEFT JOIN TB02176 ON TB02176_CODIGO = TB02021_CODSITE
							WHERE TB02021_CODIGO = @CODIGO
							AND TB02176_CIDADE = '$cidadeBotao'
							AND NOT EXISTS (SELECT * FROM TB02130 WHERE TB02130_CODIGO = @CODIGO AND TB02130_STATUS = '$StatusComMot')
						) 
					
			FETCH NEXT FROM CURSOR_UP_MASSA_END
			INTO @CODIGO
		END
		CLOSE CURSOR_UP_MASSA_END
		DEALLOCATE CURSOR_UP_MASSA_END
	

		END;
		";
	  }

	 $stmt = sqlsrv_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title>DATABIT</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<link rel="stylesheet" href="css/style.css">

	<script src="js/jQuery/jquery-3.5.1.min.js"></script>
	<script src="js/script.js"></script>
	<script>
		function observação(){
			var texto;
			let d_obs = prompt("Observações:", "");
			if (obs == null || obs == "") {
				texto = "";
			} else {
				texto = d_obs;
			}
			 var input = document.getElementById("obs");
			 input.value = d_obs;

		}
	</script>
</head>
<body>
	<section class="container-fluid">
		<div class="box_form">
		<a href="<?php echo $Url;?>/login.php"><button class="btn-logoff"></button></a>
				
				<?php /*  echo "<h1  class='titulo'><b>$codTecSes2</b></h1>"; */?>
				<form id="form-filters" class="form-filters" method='post' action="<?php echo $Url; ?>/MotReq1.php">
					<p class="titulo">REQUISIÇÕES</p>
					<select class="selectMotorista" id="codMot" name="codMot" onchange="this.form.submit()" required>        
						<option name='codMot' value="1">Todos</option>
								<?php
									include_once("conexaoSQL.php");
									$sql = 
									"
										SELECT 
											TB01077_CODIGO CodMot,
											TB01077_NOME NomeMot
										FROM TB01077
										WHERE 
										TB01077_SITUACAO = 'A'
										ORDER BY TB01077_NOME
									";
				
										$stmt = sqlsrv_query($conn, $sql);
				
										if($stmt === false)
										{
											die (print_r(sqlsrv_errors(), true));
										}


										$opcao1 = "";

										while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
										{
											$opcao1 .= "<option name='Motorista' value='$row[CodMot]'>$row[NomeMot]</option>";
										
										}
										
									$opcao1 .= " <option disabled selected>$row[NomeMot]</option>
									             </select>";

								print($opcao1);
						?>  
    
					<?php echo "<h1  class='titulo'>Motorista: <b>$nomeMot</b> </h1>";?>
					<?php echo "<h1  class='titulo'>Cidade: <b>$nomeCidade</b> </h1>";?>
				
				<!-- Filtro Estado -->
				 <div class="filters-baixo">
				 <select class="selectEstado" id="Estado" name="Estado" onchange="this.form.submit()" >        
						<option name='Estado' value="1">Todos</option>
								<?php
									include_once("conexaoSQL.php");
									$sql = 
									"
										SELECT DISTINCT
											TB02176_ESTADO Estado
										FROM 
											TB02021
										LEFT JOIN TB02176 ON TB02176_CODIGO = TB02021_CODSITE
										WHERE
											TB02021_STATUS IN ($StatusAguardMot) AND
											TB02176_ESTADO IS NOT NULL
											AND TB02176_ESTADO <> ''
										ORDER BY TB02176_ESTADO
									";
				
										$stmt = sqlsrv_query($conn, $sql);
				
										if($stmt === false)
										{
											die (print_r(sqlsrv_errors(), true));
										}


										$opcao1 = "";

										while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
										{
										$opcao1 .= "<option name='Estado' value='$row[Estado]'>$row[Estado]</option>";
										
										}
										
									$opcao1 .= "<option disabled selected>$estadoInput</option>
												</select>";

								print($opcao1);
						?>   
				   


					<!-- Filtro cidade -->
					<select class="selectCidade" id="Cidade" name="Cidade" onchange="this.form.submit()" required>        
						<option name='Cidade' value="1">Todas</option>
								<?php
									include_once("conexaoSQL.php");
									$sql = 
									"
										SELECT DISTINCT
											TB02176_CIDADE Cidade
										FROM 
											TB02021
										LEFT JOIN TB02176 ON TB02176_CODIGO = TB02021_CODSITE
										WHERE
											TB02021_STATUS IN ($StatusAguardMot) AND
											TB02176_CIDADE IS NOT NULL
											AND TB02176_CIDADE <> ''
											$estado2
										ORDER BY TB02176_CIDADE
									";
				
										$stmt = sqlsrv_query($conn, $sql);
				
										if($stmt === false)
										{
											die (print_r(sqlsrv_errors(), true));
										}


										$opcao1 = "";

										while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
										{
										$opcao1 .= "<option name='Cidade' value='$row[Cidade]'>$row[Cidade]</option>";
										
										}
										
									$opcao1 .= "<option disabled selected>$cidadeInput</option>
												</select>";

								print($opcao1);
						?>  

					<!-- Filtro Bairro -->
					<select class="selectBairro" id="Bairro" name="Bairro" onchange="this.form.submit()" required>        
						<option name='Bairro' value="1">Todos</option>
								<?php
									include_once("conexaoSQL.php");
									$sql = 
									"
										SELECT DISTINCT
											TB02176_BAIRRO Bairro
										FROM 
											TB02021
										LEFT JOIN TB02176 ON TB02176_CODIGO = TB02021_CODSITE
										WHERE
											TB02021_STATUS IN ($StatusAguardMot) AND
											TB02176_BAIRRO IS NOT NULL
											AND TB02176_BAIRRO <> ''
											$cidade2
											$estado2
										ORDER BY TB02176_BAIRRO
									";
				
										$stmt = sqlsrv_query($conn, $sql);
				
										if($stmt === false)
										{
											die (print_r(sqlsrv_errors(), true));
										}


										$opcao1 = "";

										while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
										{
											$opcao1 .= "<option name='Bairro' value='$row[Bairro]'>$row[Bairro]</option>";
										}
										
									$opcao1 .= "<option disabled selected>$bairroInput</option>
												</select>";

								print($opcao1);
						?> 
				   <?php echo "<input type='hidden' name='nomeMot' id='nomeMot' value='$nomeMot'/>";?>
				   <?php echo "<input type='hidden' name='estadoSes' id='estadoSes' value='$estadoSes'/>";?>
				   <?php echo "<input type='hidden' name='cidadeSes' id='cidadeSes' value='$cidadeSes'/>";?>
				   <?php echo "<input type='hidden' name='bairroSes' id='bairroSes' value='$bairroSes'/>";?>
				   <?php /* echo "<input type='hidden' name='codTec' id='codTec' value='$codTec'/>"; */?>
				   <input type='hidden' name='FiltroEstado' id='FiltroEstado' value='1'/>
				   <input type='hidden' name='FiltroCidade' id='FiltroCidade' value='1'/>
				   <input type='hidden' name='FiltroBairro' id='FiltroBairro' value='1'/>
				   <!-- <input type="submit" class='btn-tec' value="BUSCAR"> -->
				 </div>
			 </form>
		  </div>
		</br>
 <div class="container" id="resultados">
  <div class="row">
	<div class="col-sm" style="background-color: #dceef4; border-radius: 2rem;">
			<div class="card-header" style="">
			 <p class="titulo">Roterização de requisições </p>
				<div class="formMassa">
					<form id="formTodos" name="formTodos" action="<?php echo $Url;?>/MotReq1.php" method="post">
						<?php echo "<input name='estadoBotao' type='hidden' value='$estadoInput'/>";?>
						<?php echo "<input name='motoristaBotao' type='hidden' value='$codMotInput'/>";?>
						<?php echo "<input name='cidadeBotao' type='hidden' value='$cidadeInput'/>";?>
						<?php echo "<input name='bairroBotao' type='hidden' value='$bairroInput'/>";?>
						<?php echo "<input type='hidden' name='nomeMot' id='nomeMot' value='$nomeMot'/>";?>
				  		<?php echo "<input type='hidden' name='codMot' id='codMot' value='$codMot'/>";?>
						<?php echo "<input  type='hidden' id='estadoInput' name='estadoInput' value = '$estadoInput'>";?>
						<?php echo "<input  type='hidden' id='codMotInput' name='codMotInput' value = '$codMotInput'>";?>
						<?php echo "<input  type='hidden' id='cidadeInput' name='cidadeInput' value = '$cidadeInput'>";?>
						<?php echo "<input  type='hidden' id='bairroInput' name='bairroInput' value = '$bairroInput'>";?>
						<?php echo $btnEnvTodos;?>
					</form>
				</div>
		    </div>
			<?php
				include_once("conexaoSQL.php");
				$sql = 
				"
				SELECT DISTINCT
					TB02022_CODIGO req,
					TB02021_CONTRATO Contrato,
					TB02021_CODCLI CodCli,
					TB01008_FANTASIA NomeCli,
					SUBSTRING(TB01008_FANTASIA, 1, 1) Inicial,
					TB02021_STATUS [Status],
					TB01021_NOME NomeStatus,
					TB02176_BAIRRO Bairro,
					FORMAT(TB02021_DATA, 'dd/MM/yyyy') DataAbertura
				FROM 
					TB02022
					LEFT JOIN TB02021 ON TB02021_CODIGO = TB02022_CODIGO
					LEFT JOIN TB01008 ON TB01008_CODIGO = TB02021_CODCLI
					LEFT JOIN TB02176 ON TB02176_CODIGO = TB02021_CODSITE
					LEFT JOIN TB01021 ON TB01021_CODIGO = TB02021_STATUS
				WHERE
					TB02021_STATUS IN ($StatusAguardMot)
					$cidade2
					$bairro2
					$estado2
				ORDER BY TB02022_CODIGO
				
				";
				$stmt = sqlsrv_query($conn, $sql);
				
				if($stmt === false)
				{
					die (print_r(sqlsrv_errors(), true));
				}
				?>            
					<table id="myTable" class="table table-border table-sm" style="font-size: 6px;">
						<thead>
							<tr>
								<th scope="col" style="width:;">REQ</th>
								<th scope="col" style="width:;">ABERTURA</th>                                    
								<th scope="col" style="width:;">NOME</th>                                                               
								<th scope="col" style="width:;">BAIRRO</th>                                                                  
								<th scope="col" style="width:;">ENCAMINHAR</th>                                                                  
							</tr>
						</thead>
				<?php
				$tabela = "";
				$cont = 0;
				while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
				{
				$cont++;
				$tabela .= "<tr>";
				$tabela .= "<td style='background: $cor;'>
							 <form id='formA$cont' name='formA$cont'>
								<input class='btnDetal' type='submit' id='reqA$cont' name='reqA$cont' value='$row[req]'/>

								<script>
									$('#formA$cont').submit(function(e){
										e.preventDefault();  /*Interronpendo a atualização automatica da pagina*/ 
								
										var d_req$cont = $('#reqA$cont').val();
									
										let resultados = document.getElementById('resultados');
									
										console.log(d_req$cont);
								
									$.ajax({
										url: '$Url/infoReq.php',
										method: 'POST',
										data: {numreq: d_req$cont},
										/* dataType: 'json' */
									}).done(function(result$cont){
										console.log(result$cont);
										resultados.innerHTML = result$cont;
									});
								});
							  </script>
							 </form>
							</td>";
				$tabela .= "<td>".$row['DataAbertura']."</td>";
				$tabela .= "<td>".$row['NomeCli']."</td>"; 
				$tabela .= "<td><b>".$row['Bairro']."</b></td>";
				$tabela .= "<td>
								<form class='form$cont' id='form$cont' action='$Url/MotReq1.php' method='post'>
									<input  type='hidden' id='codMot' name='codMot' value = '$codMot'>
									<input  type='hidden' id='nomeMot' name='nomeMot' value = '$nomeMot'>
									<input  type='hidden' id='estadoInput' name='estadoInput' value = '$estadoInput'>
									<input  type='hidden' id='codMotInput' name='codMotInput' value = '$codMotInput'>
									<input  type='hidden' id='cidadeInput' name='cidadeInput' value = '$cidadeInput'>
									<input  type='hidden' id='bairroInput' name='bairroInput' value = '$bairroInput'>
									<input  type='hidden' id='req' name='req' value = '$row[req]'>
									<input  type='submit' class='btn-mot' value='ENVIAR'/>
								</form>
							</td>";
				$tabela .= "</tr>";
				}
					$tabela .= "</table>";
					print($tabela);
				?>                                                                           
			</div>
	 
	 <div class="col-sm" style="background-color: #dceef4; margin-left: 1rem; border-radius: 2rem;">
	 <div class="card-header">
		   <p class="tituloMot">Req Com Motorista | </p>

		   <!-- Mudar todas as OS para outro Motorista -->
            <?php
					$sql1 = "
					SELECT 
						TB01077_CODIGO CodMot,
						TB01077_NOME NomeMot
					FROM TB01077
					WHERE 
					TB01077_SITUACAO = 'A'
					ORDER BY TB01077_NOME
				";

		    $tabelaMot .= "<form action='$Url/MotReq1.php' method='post'>
						<select class='selectMotTodas' id='motoristaTdReq' name='motoristaTdReq'>
							<option disabled selected>Mot</option>";	
				$stmt1 = sqlsrv_query($conn, $sql1);

					while ($row1 = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC))
					{

						$tabelaMot .= "<option id='motoristaTdReq' name='motoristaTdReq' value='$row1[CodMot]'>$row1[NomeMot]</option>";
					
					}
								
			$tabelaMot .= "</select>";						
			$tabelaMot .= "<input  type='hidden' id='codMot' name='codMot' value = '$codMot'>
						<input  type='hidden' id='nomeTec' name='nomeTec' value = '$nomeMot'>
						<input  type='hidden' id='estadoInput' name='estadoInput' value = '$estadoInput'>
						<input  type='hidden' id='codMotInput' name='codMotInput' value = '$codMotInput'>
						<input  type='hidden' id='cidadeInput' name='cidadeInput' value = '$cidadeInput'>
						<input  type='hidden' id='bairroInput' name='bairroInput' value = '$bairroInput'>
					</td>
					<td>
						<input type='submit' value='ENVIAR TODAS' class='filtrarLinhaTodas'>
					</td>
					</form>";

					print($tabelaMot);
			?>

		 </div>
			<?php
				include_once("conexaoSQL.php");
				$sql = 
				"
					SELECT DISTINCT
						TB02022_CODIGO req,
						TB02021_CONTRATO Contrato,
						TB02021_CODCLI CodCli,
						TB01008_FANTASIA NomeCli,
						SUBSTRING(TB01008_FANTASIA, 1, 1) Inicial,
						TB02021_STATUS [Status],
						TB01021_NOME NomeStatus,
						TB02176_BAIRRO Bairro,
						FORMAT(TB02021_DATA, 'dd/MM/yyyy') DataAbertura
					FROM 
						TB02022
						LEFT JOIN TB02021 ON TB02021_CODIGO = TB02022_CODIGO
						LEFT JOIN TB01008 ON TB01008_CODIGO = TB02021_CODCLI
						LEFT JOIN TB02176 ON TB02176_CODIGO = TB02021_CODSITE
						LEFT JOIN TB01021 ON TB01021_CODIGO = TB02021_STATUS
						LEFT JOIN TB02096 ON TB02096_CODIGO = TB02021_CODIGO
					WHERE
						TB02021_STATUS IN ('$StatusComMot')
						AND TB02096_CODMOTO IN ('$codMot')
						
					ORDER BY TB02022_CODIGO
				
				";
				$stmt = sqlsrv_query($conn, $sql);
				
				if($stmt === false)
				{
					die (print_r(sqlsrv_errors(), true));
				}
				?>            
					<table class="table table-border table-sm" style="font-size: 6px;">
						<thead>
							<tr>
								<th scope="col" style="width:;">REQ</th>
								<th scope="col" style="width:;">ABERTURA</th>                                   
								<th scope="col" style="width:;">NOME</th>                                                                  
								<th scope="col" style="width:;">BAIRRO</th>
								<th scope="col" style="width:;">|SUBSTITUIR</th>                                                                    
								<th scope="col" style="width:;">MOT|</th>                                                                    
								<th scope="col" style="width:;">ROTERIZAÇÃO</th>                                                                    
							</tr>
						</thead>
				<?php
				$tabela = "";
				$cont1 = 1;
				while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
				{
					$cont1++;
					$tabela .= "<tr>";
					$tabela .= "<td style='background: $cor;'>
							 <form id='formC$cont1' name='formC$cont1'>
								<input class='btnDetal' type='submit' id='reqC$cont1' name='reqC$cont1' value='$row[req]'/>

								<script>
									$('#formC$cont1').submit(function(e){
										e.preventDefault();  /*Interronpendo a atualização automatica da pagina*/ 
								
										var d_req$cont1 = $('#reqC$cont1').val();
									
										let resultados = document.getElementById('resultados');
									
										console.log(d_req$cont1);
								
									$.ajax({
										url: '$Url/infoReq.php',
										method: 'POST',
										data: {numreq: d_req$cont1},
										/* dataType: 'json' */
									}).done(function(result$cont1){
										console.log(result$cont1);
										resultados.innerHTML = result$cont1;
									});
								});
							  </script>
							 </form>
							</td>";
					$tabela .= "<td>".$row['DataAbertura']."</td>";
					$tabela .= "<td>".$row['NomeCli']."</td>";
					$tabela .= "<td>".$row['Bairro']."</td>";
					$tabela .= "<td>";
						$sql1 = "
							SELECT 
								TB01077_CODIGO CodMot,
								TB01077_NOME NomeMot
							FROM TB01077
							WHERE 
							TB01077_SITUACAO = 'A'
							ORDER BY TB01077_NOME	
						 ";
		
					$tabela .= "<form action='$Url/MotReq1.php' method='post'>
									<select class='selectMotLinha' id='motoristaLinha' name='motoristaLinha'>
										<option disabled selected>Mot</option>";	
							$stmt1 = sqlsrv_query($conn, $sql1);
	
								while ($row1 = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC))
								{

									$tabela .= "<option id='motoristaLinha' name='motoristaLinha' value='$row1[CodMot]'>$row1[NomeMot]</option>";
								
								}
											
						$tabela .= "</select>";						
						$tabela .= "<input  type='hidden' id='codMot' name='codMot' value = '$codMot'>
									<input  type='hidden' id='nomeMot' name='nomeMot' value = '$nomeMot'>
									<input  type='hidden' id='estadoInput' name='estadoInput' value = '$estadoInput'>
									<input  type='hidden' id='codMotInput' name='codMotInput' value = '$codMotInput'>
									<input  type='hidden' id='cidadeInput' name='cidadeInput' value = '$cidadeInput'>
									<input  type='hidden' id='bairroInput' name='bairroInput' value = '$bairroInput'>
									<input  type='hidden' id='reqLinha' name='reqLinha' value = '$row[req]'>
						        </td>
						    	<td>
									<input type='submit' value='ENVIAR' class='filtrarLinha'>
								</td>
						        </form>";

						$tabela .= "<td>
										<form action='$Url/MotReq1.php' method='post'>
											<input  type='hidden' id='codMot' name='codMot' value = '$codMot'>
											<input  type='hidden' id='estadoInput' name='estadoInput' value = '$estadoInput'>
											<input  type='hidden' id='codMotInput' name='codMotInput' value = '$codMotInput'>
											<input  type='hidden' id='cidadeInput' name='cidadeInput' value = '$cidadeInput'>
											<input  type='hidden' id='bairroInput' name='bairroInput' value = '$bairroInput'>
											<input  type='hidden' id='reqLinhaRet' name='reqLinhaRet' value = '$row[req]'>

											<input type='submit' value='' class='filtrarLinhaRet'>
										</form>
						             </td>";

						$tabela .= "</tr>";							
       
					}
					$tabela .= "</table>";
				  print($tabela);
				?>                                                                           
		  </div>

		<div class="col-sm" style="background-color: #dceef4; margin-left: 1rem; border-radius: 2rem;">
		 <div class="card-header">
		   <p class="titulo">Requisições Pendentes</p>
		 </div>
		 <?php
				include_once("conexaoSQL.php");
				$sql = 
				"
				SELECT DISTINCT
					TB02022_CODIGO req,
					TB02021_CONTRATO Contrato,
					TB02021_CODCLI CodCli,
					TB01008_FANTASIA NomeCli,
					SUBSTRING(TB01008_FANTASIA, 1, 1) Inicial,
					TB02021_STATUS [Status],
					TB01021_NOME NomeStatus,
					TB02176_BAIRRO Bairro,
					FORMAT(TB02021_DATA, 'dd/MM/yyyy') DataAbertura
				FROM 
					TB02022
					LEFT JOIN TB02021 ON TB02021_CODIGO = TB02022_CODIGO
					LEFT JOIN TB01008 ON TB01008_CODIGO = TB02021_CODCLI
					LEFT JOIN TB02176 ON TB02176_CODIGO = TB02021_CODSITE
					LEFT JOIN TB01021 ON TB01021_CODIGO = TB02021_STATUS
					LEFT JOIN TB02096 ON TB02096_CODIGO = TB02021_CODIGO
				WHERE
					TB02021_STATUS IN ('$StatusPendente')
					$codMot2
					$cidade2
					$bairro2
					$estado2
					
				ORDER BY TB02022_CODIGO
				
				";
				$stmt = sqlsrv_query($conn, $sql);
				
				if($stmt === false)
				{
					die (print_r(sqlsrv_errors(), true));
				}
				?>            
					<table class="table table-border table-sm" style="font-size: 6px;">
						<thead>
							<tr>
								<th scope="col" style="width:;">REQ</th>
								<th scope="col" style="width:;">ABERTURA</th>                             
								<th scope="col" style="width:;">NOME</th>                                                                  
								<th scope="col" style="width:;">BAIRRO</th>                                                                  
								<th scope="col" style="width:;">ROTERIZAÇÃO</th>                                                                  
							</tr>
						</thead>
				<?php
				$tabela = "";
				$cont3 = 2;
				while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
				{
				$cont3++;
				$tabela .= "<tr>";
				$tabela .= "<td style='background: $cor;'>
							 <form id='formE$cont3' name='formE$cont3'>
								<input class='btnDetal' type='submit' id='reqE$cont3' name='reqE$cont3' value='$row[req]'/>

								<script>
									$('#formE$cont3').submit(function(e){
										e.preventDefault();  /*Interronpendo a atualização automatica da pagina*/ 
								
										var d_req$cont3 = $('#reqE$cont3').val();
									
										let resultados = document.getElementById('resultados');
									
										console.log(d_req$cont3);
								
									$.ajax({
										url: '$Url/infoReq.php',
										method: 'POST',
										data: {numreq: d_req$cont3},
										/* dataType: 'json' */
									}).done(function(result$cont3){
										console.log(result$cont3);
										resultados.innerHTML = result$cont3;
									});
								});
							  </script>
							 </form>
							</td>";
				$tabela .= "<td>".$row['DataAbertura']."</td>";
				$tabela .= "<td>".$row['NomeCli']."</td>";
				$tabela .= "<td>".$row['Bairro']."</td>";
				$tabela .= "<td>
								<form action='$Url/MotReq1.php' method='post'>
									<input  type='hidden' id='codMot' name='codMot' value = '$codMot'>
									<input  type='hidden' id='estadoInput' name='estadoInput' value = '$estadoInput'>
									<input  type='hidden' id='codMotInput' name='codMotInput' value = '$codMotInput'>
									<input  type='hidden' id='cidadeInput' name='cidadeInput' value = '$cidadeInput'>
									<input  type='hidden' id='bairroInput' name='bairroInput' value = '$bairroInput'>
									<input  type='hidden' id='obs' name='obs'>
									<input  type='hidden' id='reqLinhaRet' name='reqLinhaRet' value = '$row[req]'>

									<input onclick='return observação();' type='submit' value='' class='filtrarLinhaRet'>
								</form>
								</td>";
				$tabela .= "</tr>";
				}
					$tabela .= "</table>";
					print($tabela);

					echo $codMot2;
				?>                                                                                         
		  </div>
		</div>
	  </div>	
	</section>
	<script>
          $(document).ready(function() {
              $('#motorista').select2();
          });
    </script>
</body>
</html>