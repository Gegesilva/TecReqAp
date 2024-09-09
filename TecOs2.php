<?php
header('Content-type: text/html; charset=utf-8');
include_once ("conexaoSQL.php");
include_once ("config.php");


/* VALIDA USUARIO */
session_start();

$login = $_SESSION["login"];
$senha = $_SESSION["password"];

$sql = "SELECT 
			TB01066_USUARIO Usuario,
			TB01066_SENHA Senha
		FROM 
			TB01066
		WHERE 
			TB01066_USUARIO = '$login'
			AND TB01066_SENHA = '$senha'";
$stmt = sqlsrv_query($conn, $sql);
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
	$usuario = $row['Usuario'];
	$senha = $row['Senha'];
}
if ($usuario != NULL) {

} else {
	echo "<script>window.alert('É necessário fazer login!')</script>";
	echo "<script>location.href='$Url/login.php'</script>";
}



/* SALVA O FILTRO TECNICO */
$codTecSes2 = $_SESSION["codTecSes"];

if (isset($_POST["codTec"]) && $_POST["codTec"] != '') {
	$_SESSION["codTecSes"] = $_POST["codTec"];
	$cidade2 = "";
	$bairro2 = "";
	$estado2 = "";
}

$codTecPass = $_POST['codTec'];


if (isset($codTecPass) && $codTecPass != '') {
	$codTec = $codTecPass;
} else {
	$codTec = $codTecSes2;
}

if ($codTecPass == '1') {
	$codTec = '';
}

/* SALVA O FILTRO ESTADO */
$estadoSes2 = $_SESSION["EstadoSes"];

if (isset($_POST["Estado"]) && $_POST["Estado"] != '') {
	$_SESSION["EstadoSes"] = $_POST["Estado"];
}

$estadoPass = $_POST['Estado'];


if (isset($estadoPass) && $estadoPass != '') {
	$estado = $estadoPass;
	$nomeEstado = $estadoPass;
} else if (!isset($estadoPass) || $estadoPass == '') {
	$estado = $estadoSes2;
	$nomeEstado = $estadoSes2;
}





/* SALVA O FILTRO CIDADE */
$cidadeSes2 = $_SESSION["CidadeSes"];

if (isset($_POST["Cidade"]) && $_POST["Cidade"] != '') {
	$_SESSION["CidadeSes"] = $_POST["Cidade"];
}

$cidadePass = $_POST['Cidade'];


if (isset($cidadePass) && $cidadePass != '') {
	$cidade = $cidadePass;
	$nomeCidade = $cidadePass;
} else if (!isset($cidadePass) || $cidadePass == '') {
	$cidade = $cidadeSes2;
	$nomeCidade = $cidadeSes2;
}


/* SALVA O FILTRO BAIRRO */
$bairroSes2 = $_SESSION["BairroSes"];

if (isset($_POST["Bairro"]) && $_POST["Bairro"] != '') {
	$_SESSION["BairroSes"] = $_POST["Bairro"];
}

$bairroPass = $_POST['Bairro'];


if (isset($bairroPass) && $bairroPass != '') {
	$bairro = $bairroPass;
} else if (!isset($bairroPass) || $bairroPass == '') {
	$bairro = $bairroSes2;
}





$os = $_POST['os'];

$tecnicoLinha = $_POST['tecnicoLinha'];

$osLinha = $_POST['osLinha'];

$filtroCidade = $_POST['FiltroCidade'];

$osLinhaRet = $_POST['osLinhaRet'];


/* VARIAVEIS E CONDICIONAIS DO FILTRO ESTADO */
$estadoInput = $_POST['estadoInput'];
$estadoPost = $estado;

if (isset($estadoPost) && $estadoPost != '1') {
	$estado2 = "AND TB02115_ESTADO = '$estadoPost'";
	$estadoInput = $estadoPost;
} else {
	if ($estadoInput == "" || $estadoPost == '1' || $estadoPass == '1') {
		$estado2 = "";
	} else {
		$estado2 = "AND TB02115_ESTADO = '$estadoInput'";
	}
}


/* VARIAVEIS E CONDICIONAIS DO FILTRO CIDADE */
$cidadeInput = $_POST['cidadeInput'];
$cidadePost = $cidade;

if (isset($cidadePost) && $cidadePost != '1') {
	$cidade2 = "AND TB02115_CIDADE = '$cidadePost'";
	$cidadeInput = $cidadePost;
} else {
	if ($cidadeInput == "" || $cidadePost == '1' || $cidadePass == '1') {
		$cidade2 = "";
		$nomeCidade = "Todas";
	} else {
		$cidade2 = "AND TB02115_CIDADE = '$cidadeInput'";
	}
}


/* VARIAVEIS E CONDICIONAIS DO FILTRO BAIRRO */
$bairroInput = $_POST['bairroInput'];
$bairroPost = $bairro;

if (isset($bairroPost) && $bairroPost != '1') {
	$bairro2 = "AND TB02115_BAIRRO = '$bairroPost'";
	$bairroInput = $bairroPost;
} else {
	if ($bairroInput == "" || $bairroPost == '1' || $bairroPass == '1') {
		$bairro2 = "";
	} else {
		$bairro2 = "AND TB02115_BAIRRO = '$bairroInput'";
	}
}




/* CONDICIONAIS PARA BOTÃO EM MASSA */
$cidadeBotao = $_POST['cidadeBotao'];
$bairroBotao = $_POST['bairroBotao'];

if (isset($cidadeInput) && isset($filtroCidade)) {
	/* $btnEnvTodos = "<input type='submit' form='formTodos' class='btn btn-warning' style='border-radius: 20px; box-shadow: 2px 3px white;' value='Enviar Todos'/>"; */

	if ($bairroBotao != 1) {

		$bairro2;
		/* $estado2; */
	}

} else {
	$btnEnvTodos = "";
}



/* LIMPAR BOTÃO ENV TODOS */
if (isset($_POST["codTec"]) && $_POST["codTec"] != '') {

	$btnEnvTodos = "";
}


/*MUDANÇA POR NUMERO DE OS*/
if (isset($os)) {
	$sql =
		"UPDATE 
			TB02115 
		SET 
			TB02115_CODTEC = '$codTec',
			TB02115_DTALT = GETDATE(),
			TB02115_STATUS = '$StatusComTec',
			TB02115_OPALT = '$login'
		WHERE
			TB02115_CODIGO = '$os'


			INSERT INTO 
			TB02130 (
					TB02130_CODIGO,
					TB02130_USER,
					TB02130_OBS,
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
					'$os',
					'$login',
					'APP GESTÃO OS',
					GETDATE(), 
					GETDATE(), 
					'$StatusComTec',
					'O',
					TB01024_NOME,
					TB02115_CODCLI,
					TB02115_CODEMP,
					TB01073_NOME,
					'$codTec'
					FROM TB02115
					LEFT JOIN TB01073 ON TB01073_CODIGO = '$StatusComTec'
					LEFT JOIN TB01024 ON TB01024_CODIGO = '$codTec'
					WHERE TB02115_CODIGO = '$os'
					AND NOT EXISTS (SELECT TB02130_CODIGO FROM TB02130 WHERE TB02130_CODIGO = '$os' AND TB02130_CODTEC = '$codTec' AND TB02130_STATUS = '$StatusComTec')
				) 
		";
}

$stmt = sqlsrv_query($conn, $sql);


/* CONDICIONAIS MUDA TECNICO EM LINHA */
if (isset($tecnicoLinha)) {
	$sql1 =
		"UPDATE 
				TB02115 
			SET 
				TB02115_CODTEC = '$tecnicoLinha',
				TB02115_DTALT = GETDATE(),
				TB02115_OPALT = '$login'
			WHERE
				TB02115_CODIGO = '$osLinha'
			";
	$stmt = sqlsrv_query($conn, $sql1);

}


/* DEVOLVE PARA A ROTERIZAÇÃO */
if (isset($osLinhaRet)) {
	$sql1 =
		"UPDATE 
				TB02115 
			SET 
				TB02115_CODTEC = '0000',
				TB02115_DTALT = GETDATE(),
				TB02115_STATUS = '00',
				TB02115_OPALT = '$login'
			WHERE
				TB02115_CODIGO = '$osLinhaRet'
			";
	$stmt = sqlsrv_query($conn, $sql1);

}



/* UPDATE EM MASSA POR CIDADE/BAIRRO */
if ($cidadeBotao != NULL && $cidadeBotao != "") {
	$sql =
		"INSERT INTO 
		TB02130 (
				TB02130_CODIGO,
				TB02130_USER,
				TB02130_OBS,
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
				A.TB02115_CODIGO,
				'$login',
				'APP WEB',
				GETDATE(), 
				GETDATE(), 
				'$StatusComTec',
				'O',
				TB01024_NOME,
				A.TB02115_CODCLI,
				A.TB02115_CODEMP,
				TB01073_NOME,
				'$codTec'
				FROM TB02115 A
				LEFT JOIN TB01073 ON TB01073_CODIGO = '$StatusComTec'
				LEFT JOIN TB01024 ON TB01024_CODIGO = '$codTec'
				WHERE TB02115_CIDADE = '$cidadeBotao'	
				$bairro2
				AND TB02115_STATUS IN ($StatusAguardTec)
				AND (SELECT COUNT(B.TB02115_CODIGO) FROM TB02115 B WHERE B.TB02115_NUMSERIE = A.TB02115_NUMSERIE AND A.TB02115_DTFECHA IS NULL) > 1
			) 

			UPDATE 
				TB02115 
			SET 
				TB02115_CODTEC = '$codTec',
				TB02115_DTALT = GETDATE(),
				TB02115_STATUS = '$StatusComTec',
				TB02115_OPALT = '$login'
			WHERE
				TB02115_CIDADE = '$cidadeBotao'
				AND TB02115_STATUS IN ($StatusAguardTec)
				AND (SELECT COUNT(TB02115_CODIGO) FROM TB02115 B WHERE B.TB02115_NUMSERIE = TB02115_NUMSERIE AND TB02115_DTFECHA IS NULL) > 1
				$bairro2

		";
}

$stmt = sqlsrv_query($conn, $sql);


/* PEGA NOME TEC */
if (isset($codTec)) {
	$sql =
		"SELECT 
			TB01024_NOME NomeTec
		FROM TB01024
		WHERE TB01024_CODIGO = '$codTec'
		";
	$stmt = sqlsrv_query($conn, $sql);
	while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
		$nomeTec = $row['NomeTec'];
	}
} else {
	/* $nomeTec = "Selecione técnico"; */
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<title>DATABIT</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
		integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
		integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
		crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<link rel="stylesheet" href="css/style.css">

	<script src="js/jQuery/jquery-3.5.1.min.js"></script>
	<script src="js/script.js"></script>
</head>

<body>
	<section class="container-fluid">
		<div class="box_form_crit">
			<h1 class='titulo-acima'><b>CRÍTICO</b> </h1>
			<?php /*  echo "<h1  class='titulo'><b>$codTecSes2</b></h1>"; */ ?>
			<form id="form-filters" class="form-filters" method='post' action="<?php echo $Url; ?>/TecOs2.php">
				<!-- <label for="form-filters" class="labelTecOS">Técnico</label> -->
				<select class="selectTecnico" id="codTec" name="codTec" onchange="this.form.submit()" required>
					<option name='codTec' value="1">Todos</option>
					<?php
					include_once ("conexaoSQL.php");
					$sql =
						"SELECT 
							TB01066_TECNICO CodTec,
							TB01024_NOME NomeTec
						FROM TB01066
						LEFT JOIN TB01024 ON TB01024_CODIGO = TB01066_TECNICO
						WHERE TB01066_TIPO = '4'
						AND TB01066_OUTSOURCING = 'S'
						AND TB01024_SITUACAO = 'A'
						ORDER BY TB01024_NOME
					";

					$stmt = sqlsrv_query($conn, $sql);

					if ($stmt === false) {
						die(print_r(sqlsrv_errors(), true));
					}


					$opcao1 = "";

					while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
						$opcao1 .= "<option name='Tecnico' value='$row[CodTec]'>$row[NomeTec]</option>";

					}

					$opcao1 .= " <option disabled selected>$nomeTec</option>
									             </select>";

					print ($opcao1);
					?>

					<?php echo "<h1  class='titulo'>Técnico: <b>$nomeTec</b> </h1>"; ?>
					<?php echo "<h1  class='titulo'>Cidade: <b>$nomeCidade</b> </h1>"; ?>

					<!-- Filtro Estado -->
					<div class="filters-baixo">
						<select class="selectEstado" id="Estado" name="Estado" onchange="this.form.submit()">
							<option name='Estado' value="1">Todos</option>
							<?php
							include_once ("conexaoSQL.php");
							$sql =
								"SELECT DISTINCT
										TB02115_ESTADO Estado
									FROM 
										TB02115
									WHERE
										TB02115_STATUS IN ($StatusAguardTec) AND
										TB02115_ESTADO IS NOT NULL
										AND TB02115_ESTADO <> ''
									ORDER BY TB02115_ESTADO
									";

							$stmt = sqlsrv_query($conn, $sql);

							if ($stmt === false) {
								die(print_r(sqlsrv_errors(), true));
							}


							$opcao1 = "";

							while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
								$opcao1 .= "<option name='Estado' value='$row[Estado]'>$row[Estado]</option>";

							}

							$opcao1 .= "<option disabled selected>$estadoInput</option>
												</select>";

							print ($opcao1);
							?>



							<!-- Filtro cidade -->
							<select class="selectCidade" id="Cidade" name="Cidade" onchange="this.form.submit()"
								required>
								<option name='Cidade' value="1">Todas</option>
								<?php
								include_once ("conexaoSQL.php");
								$sql =
									"SELECT DISTINCT
											TB02115_CIDADE Cidade
										FROM 
											TB02115
										WHERE
											TB02115_STATUS IN ($StatusAguardTec) AND
											TB02115_CIDADE IS NOT NULL
											AND TB02115_CIDADE <> ''
											$estado2
										ORDER BY TB02115_CIDADE
									";

								$stmt = sqlsrv_query($conn, $sql);

								if ($stmt === false) {
									die(print_r(sqlsrv_errors(), true));
								}


								$opcao1 = "";

								while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
									$opcao1 .= "<option name='Cidade' value='$row[Cidade]'>$row[Cidade]</option>";

								}

								$opcao1 .= "<option disabled selected>$cidadeInput</option>
												</select>";

								print ($opcao1);
								?>

								<!-- Filtro Bairro -->
								<select class="selectBairro" id="Bairro" name="Bairro" onchange="this.form.submit()"
									required>
									<option name='Bairro' value="1">Todos</option>
									<?php
									include_once ("conexaoSQL.php");
									$sql =
										"SELECT DISTINCT
											TB02115_BAIRRO Bairro
										FROM 
											TB02115
										WHERE
											TB02115_STATUS IN ($StatusAguardTec)
											AND TB02115_BAIRRO IS NOT NULL
											AND TB02115_BAIRRO <> ''
											$cidade2
											$estado2
										ORDER BY TB02115_BAIRRO
									";

									$stmt = sqlsrv_query($conn, $sql);

									if ($stmt === false) {
										die(print_r(sqlsrv_errors(), true));
									}


									$opcao1 = "";

									while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
										$opcao1 .= "<option name='Bairro' value='$row[Bairro]'>$row[Bairro]</option>";
									}

									$opcao1 .= "<option disabled selected>$bairroInput</option>
												</select>";

									print ($opcao1);
									?>
									<a class="btn-voltar" href="<?php echo $Url; ?>/TecOs1.php">VOLTAR</a>
									<?php echo "<input type='hidden' name='nomeTec' id='nomeTec' value='$nomeTec'/>"; ?>
									<?php echo "<input type='hidden' name='estadoSes' id='estadoSes' value='$estadoSes'/>"; ?>
									<?php echo "<input type='hidden' name='cidadeSes' id='cidadeSes' value='$cidadeSes'/>"; ?>
									<?php echo "<input type='hidden' name='bairroSes' id='bairroSes' value='$bairroSes'/>"; ?>
									<?php /* echo "<input type='hidden' name='codTec' id='codTec' value='$codTec'/>"; */ ?>
									<input type='hidden' name='FiltroEstado' id='FiltroEstado' value='1' />
									<input type='hidden' name='FiltroCidade' id='FiltroCidade' value='1' />
									<input type='hidden' name='FiltroBairro' id='FiltroBairro' value='1' />
									<!-- <input type="submit" class='btn-tec' value="BUSCAR"> -->
					</div>
			</form>
		</div>
		</br>
		<div class="container" id="resultados">
			<div class="row">
				<div class="col-sm" style="background-color: white; border-radius: 2rem;">
					<div class="card-header-crit" style="">
						<p class="titulo">Mais de uma OS por série </p>
						<div class="formMassa">
							<form id="formTodos" name="formTodos" action="<?php echo $Url; ?>/TecOs2.php" method="post">
								<?php echo "<input name='estadoBotao' type='hidden' value='$estadoInput'/>"; ?>
								<?php echo "<input name='cidadeBotao' type='hidden' value='$cidadeInput'/>"; ?>
								<?php echo "<input name='bairroBotao' type='hidden' value='$bairroInput'/>"; ?>
								<?php echo "<input type='hidden' name='nomeTec' id='nomeTec' value='$nomeTec'/>"; ?>
								<?php echo "<input type='hidden' name='codTec' id='codTec' value='$codTec'/>"; ?>
								<?php echo "<input  type='hidden' id='estadoInput' name='estadoInput' value = '$estadoInput'>"; ?>
								<?php echo "<input  type='hidden' id='cidadeInput' name='cidadeInput' value = '$cidadeInput'>"; ?>
								<?php echo "<input  type='hidden' id='bairroInput' name='bairroInput' value = '$bairroInput'>"; ?>
								<?php echo $btnEnvTodos; ?>
							</form>
						</div>
					</div>
					<?php
					include_once ("conexaoSQL.php");
					$sql =
						"SELECT 
					A.TB02115_CODIGO os,
					A.TB02115_CONTRATO Contrato,
					A.TB02115_CODCLI CodCli,
					TB01008_FANTASIA NomeCli,
					SUBSTRING(TB01008_FANTASIA, 1, 1) Inicial,
					A.TB02115_STATUS [Status],
					TB01073_NOME NomeStatus,
					A.TB02115_SOLICITANTE Solicitante,
					A.TB02115_BAIRRO Cidade,
					A.TB02115_NUMSERIE Serie,
					FORMAT(A.TB02115_DATA, 'dd/MM/yyyy') DataAbertura,
					TB01048_NOME Defeito,
					(SELECT COUNT(TB02115_CODIGO) FROM TB02115 B WHERE B.TB02115_NUMSERIE = A.TB02115_NUMSERIE AND TB02115_DTFECHA IS NULL),
				CASE 
					WHEN TB02115_PREVENTIVA = 'N' THEN 'N'
					WHEN TB02115_PREVENTIVA = 'S' THEN 'P'
					WHEN TB02115_PREVENTIVA = 'I' THEN 'I'
					WHEN TB02115_PREVENTIVA = 'D' THEN 'D'
					WHEN TB02115_PREVENTIVA = 'R' THEN 'R'
					WHEN TB02115_PREVENTIVA = 'A' THEN 'A'
				END Tipo
				FROM 
					TB02115 A
					LEFT JOIN TB01008 ON TB01008_CODIGO = A.TB02115_CODCLI
					LEFT JOIN TB01073 ON TB01073_CODIGO = A.TB02115_STATUS
					LEFT JOIN TB02116 ON TB02116_CODIGO = A.TB02115_CODIGO
					LEFT JOIN TB01048 ON TB01048_CODIGO = TB02116_DEFEITO
				WHERE
					TB02115_STATUS IN ($StatusAguardTec)
					AND (SELECT COUNT(TB02115_CODIGO) FROM TB02115 B WHERE B.TB02115_NUMSERIE = A.TB02115_NUMSERIE AND TB02115_DTFECHA IS NULL AND TB02115_PREVENTIVA <> 'A') > 1
					$cidade2
					$bairro2
					$estado2
				ORDER BY A.TB02115_NUMSERIE
				
				";
					$stmt = sqlsrv_query($conn, $sql);

					if ($stmt === false) {
						die(print_r(sqlsrv_errors(), true));
					}
					?>
					<table id="myTable" class="table table-border table-sm" style="font-size: 6px;">
						<thead>
							<tr>
								<th scope="col" style="width:;">TIPO</th>
								<th scope="col" style="width:;">OS</th>
								<th scope="col" style="width:;">ABERTURA</th>
								<th onclick="/* sortTable(document.getElementById('myTable'),'asc',0)" scope="col"
									style="width:; */">NOME</th>
								<th scope="col" style="width:;">BAIRRO</th>
								<th scope="col" style="width:;">SÉRIE</th>
								<th scope="col" style="width:;">DEFEITO</th>
								<th scope="col" style="width:;">ENCAMINHAR</th>
							</tr>
						</thead>
						<?php
						$tabela = "";
						$cont = 0;
						while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
							$cont++;
							$tabela .= "<tr>";
							$tabela .= "<td style='font-size: 0.7rem; color: red;'><b>" . $row['Tipo'] . "</b></td>";
							$tabela .= "<td style='background: $cor;'>
							 <form id='formA$cont' name='formA$cont'>
								<input class='btnDetal' type='submit' id='osA$cont' name='osA$cont' value='$row[os]'/>

								<script>
									$('#formA$cont').submit(function(e){
										e.preventDefault();  /*Interronpendo a atualização automatica da pagina*/ 
								
										var d_os$cont = $('#osA$cont').val();
									
										let resultados = document.getElementById('resultados');
									
										console.log(d_os$cont);
								
									$.ajax({
										url: '$Url/infoOs.php',
										method: 'POST',
										data: {numos: d_os$cont},
										/* dataType: 'json' */
									}).done(function(result$cont){
										console.log(result$cont);
										resultados.innerHTML = result$cont;
									});
								});
							  </script>
							 </form>
							</td>";
							$tabela .= "<td>" . $row['DataAbertura'] . "</td>";
							$tabela .= "<td>" . $row['NomeCli'] . "</td>";
							$tabela .= "<td><b>" . $row['Cidade'] . "</b></td>";
							$tabela .= "<td style='background: $cor;'>
							 <form id='formB$cont' name='formB$cont'>
								<input class='btnDetal' type='submit' id='serieB$cont' name='serieB$cont' value='$row[Serie]'/>

								<script>
									$('#formB$cont').submit(function(e){
										e.preventDefault();  /*Interronpendo a atualização automatica da pagina*/ 
								
										var d_serie$cont = $('#serieB$cont').val();
									
										let resultados = document.getElementById('resultados');
									
										console.log(d_serie$cont);
								
									$.ajax({
										url: '$Url/top10os.php',
										method: 'POST',
										data: {serie: d_serie$cont},
										/* dataType: 'json' */
									}).done(function(result$cont){
										console.log(result$cont);
										resultados.innerHTML = result$cont;
									});
								});
							  </script>
							 </form>
							</td>";
							$tabela .= "<td>" . $row['Defeito'] . "</td>";
							$tabela .= "<td>
								<form class='form$cont' id='form$cont' action='$Url/TecOs2.php' method='post'>
									<input  type='hidden' id='codTec' name='codTec' value = '$codTec'>
									<input  type='hidden' id='nomeTec' name='nomeTec' value = '$nomeTec'>
									<input  type='hidden' id='estadoInput' name='estadoInput' value = '$estadoInput'>
									<input  type='hidden' id='cidadeInput' name='cidadeInput' value = '$cidadeInput'>
									<input  type='hidden' id='bairroInput' name='bairroInput' value = '$bairroInput'>
									<input  type='hidden' id='os' name='os' value = '$row[os]'>
									<input  type='submit' class='btn-tec' value='ENVIAR'/>
								</form>
							</td>";
							$tabela .= "</tr>";
						}
						$tabela .= "</table>";
						print ($tabela);
						?>
				</div>

				<div class="col-sm" style="background-color: white; margin-left: 1rem; border-radius: 2rem;">
					<div class="card-header">
						<p class="titulo">OS Com Técnico</p>
					</div>
					<?php
					include_once ("conexaoSQL.php");
					$sql =
						"SELECT 
					TB02115_CODIGO os,
					TB02115_CONTRATO Contrato,
					TB02115_CODCLI CodCli,
					TB01008_FANTASIA NomeCli,
					TB02115_STATUS [Status],
					TB01073_NOME NomeStatus,
					TB02115_SOLICITANTE Solicitante,
					TB02115_BAIRRO Cidade,
					TB01024_NOME NomeTec,
					TB02115_NUMSERIE Serie,
					FORMAT(TB02115_DATA, 'dd/MM/yyyy') DataAbertura,
				CASE 
					WHEN TB02115_PREVENTIVA = 'N' THEN 'N'
					WHEN TB02115_PREVENTIVA = 'S' THEN 'P'
					WHEN TB02115_PREVENTIVA = 'I' THEN 'I'
					WHEN TB02115_PREVENTIVA = 'D' THEN 'D'
					WHEN TB02115_PREVENTIVA = 'R' THEN 'R'
					WHEN TB02115_PREVENTIVA = 'A' THEN 'A'
				END Tipo
				FROM 
					TB02115
					LEFT JOIN TB01008 ON TB01008_CODIGO = TB02115_CODCLI
					LEFT JOIN TB01073 ON TB01073_CODIGO = TB02115_STATUS
					LEFT JOIN TB01024 ON TB01024_CODIGO = TB02115_CODTEC
				WHERE
 					TB02115_CODTEC IN ('$codTec')
					AND TB02115_STATUS IN ('$StatusComTec')
				ORDER BY TB02115_CODIGO 
				
				";
					$stmt = sqlsrv_query($conn, $sql);

					if ($stmt === false) {
						die(print_r(sqlsrv_errors(), true));
					}
					?>
					<table class="table table-border table-sm" style="font-size: 6px;">
						<thead>
							<tr>
								<th scope="col" style="width:0.1rem;">TIPO</th>
								<th scope="col" style="width:;">OS</th>
								<th scope="col" style="width:;">ABERTURA</th>
								<th scope="col" style="width:;">NOME</th>
								<th scope="col" style="width:;">BAIRRO</th>
								<th scope="col" style="width:;">SÉRIE</th>
								<th scope="col" style="width:;">|SUBSTITUIR</th>
								<th scope="col" style="width:;">TEC|</th>
								<th scope="col" style="width:;">ROTERIZAÇÃO</th>
							</tr>
						</thead>
						<?php
						$tabela = "";
						$cont1 = 1;
						while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
							$cont1++;
							$tabela .= "<tr>";
							$tabela .= "<td style='font-size: 0.7rem; color: red;'><b>" . $row['Tipo'] . "</b></td>";
							$tabela .= "<td style='background: $cor;'>
							 <form id='formC$cont1' name='formC$cont1'>
								<input class='btnDetal' type='submit' id='osC$cont1' name='osC$cont1' value='$row[os]'/>

								<script>
									$('#formC$cont1').submit(function(e){
										e.preventDefault();  /*Interronpendo a atualização automatica da pagina*/ 
								
										var d_os$cont1 = $('#osC$cont1').val();
									
										let resultados = document.getElementById('resultados');
									
										console.log(d_os$cont1);
								
									$.ajax({
										url: '$Url/infoOs.php',
										method: 'POST',
										data: {numos: d_os$cont1},
										/* dataType: 'json' */
									}).done(function(result$cont1){
										console.log(result$cont1);
										resultados.innerHTML = result$cont1;
									});
								});
							  </script>
							 </form>
							</td>";
							$tabela .= "<td>" . $row['DataAbertura'] . "</td>";
							$tabela .= "<td>" . $row['NomeCli'] . "</td>";
							$tabela .= "<td>" . $row['Cidade'] . "</td>";
							$tabela .= "<td style='background: $cor;'>
							 <form id='formD$cont1' name='formD$cont1'>
								<input class='btnDetal' type='submit' id='serieD$cont1' name='serieD$cont1' value='$row[Serie]'/>

								<script>
									$('#formD$cont1').submit(function(e){
										e.preventDefault();  /*Interronpendo a atualização automatica da pagina*/ 
								
										var d_serie$cont1 = $('#serieD$cont1').val();
									
										let resultados = document.getElementById('resultados');
									
										console.log(d_serie$cont1);
								
									$.ajax({
										url: '$Url/top10os.php',
										method: 'POST',
										data: {serie: d_serie$cont1},
										/* dataType: 'json' */
									}).done(function(result$cont1){
										console.log(result$cont1);
										resultados.innerHTML = result$cont1;
									});
								});
							  </script>
							 </form>
							</td>";
							$tabela .= "<td>";
							$sql1 =
								"SELECT 
								TB01066_TECNICO CodTec,
								TB01024_NOME NomeTec
								FROM TB01066
								LEFT JOIN TB01024 ON TB01024_CODIGO = TB01066_TECNICO
							WHERE TB01066_TIPO = '4'
							AND TB01066_OUTSOURCING = 'S'
							AND TB01024_SITUACAO = 'A'
							ORDER BY TB01024_NOME
						";

							$tabela .= "<form action='$Url/TecOs2.php' method='post'>
									<select class='selectTecLinha' id='tecnicoLinha' name='tecnicoLinha'>
										<option disabled selected>Tec</option>";
							$stmt1 = sqlsrv_query($conn, $sql1);

							while ($row1 = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC)) {

								$tabela .= "<option id='tecnicoLinha' name='tecnicoLinha' value='$row1[CodTec]'>$row1[NomeTec]</option>";

							}

							$tabela .= "</select>";
							$tabela .= "<input  type='hidden' id='codTec' name='codTec' value = '$codTec'>
									<input  type='hidden' id='nomeTec' name='nomeTec' value = '$nomeTec'>
									<input  type='hidden' id='estadoInput' name='estadoInput' value = '$estadoInput'>
									<input  type='hidden' id='cidadeInput' name='cidadeInput' value = '$cidadeInput'>
									<input  type='hidden' id='bairroInput' name='bairroInput' value = '$bairroInput'>
									<input  type='hidden' id='osLinha' name='osLinha' value = '$row[os]'>
						        </td>
						    	<td>
									<input type='submit' value='ENVIAR' class='filtrarLinha'>
								</td>
						        </form>";

							$tabela .= "<td>
										<form action='$Url/TecOs2.php' method='post'>
											<input  type='hidden' id='codTec' name='codTec' value = '$codTec'>
											<input  type='hidden' id='estadoInput' name='estadoInput' value = '$estadoInput'>
											<input  type='hidden' id='cidadeInput' name='cidadeInput' value = '$cidadeInput'>
											<input  type='hidden' id='bairroInput' name='bairroInput' value = '$bairroInput'>
											<input  type='hidden' id='osLinhaRet' name='osLinhaRet' value = '$row[os]'>

											<input type='submit' value='' class='filtrarLinhaRet'>
										</form>
						             </td>";

							$tabela .= "</tr>";

						}
						$tabela .= "</table>";
						print ($tabela);
						?>
				</div>

				<div class="col-sm" style="background-color: white; margin-left: 1rem; border-radius: 2rem;">
					<div class="card-header-crit" style="">
						<p class="titulo">Liberada para atendimento</p>
						<div class="formMassa">
							<form id="formTodos2" name="formTodos2" action="<?php echo $Url; ?>/TecOs2.php"
								method="post">
								<?php echo "<input name='estadoBotao' type='hidden' value='$estadoInput'/>"; ?>
								<?php echo "<input name='cidadeBotao' type='hidden' value='$cidadeInput'/>"; ?>
								<?php echo "<input name='bairroBotao' type='hidden' value='$bairroInput'/>"; ?>
								<?php echo "<input type='hidden' name='nomeTec' id='nomeTec' value='$nomeTec'/>"; ?>
								<?php echo "<input type='hidden' name='codTec' id='codTec' value='$codTec'/>"; ?>
								<?php echo "<input  type='hidden' id='estadoInput' name='estadoInput' value = '$estadoInput'>"; ?>
								<?php echo "<input  type='hidden' id='cidadeInput' name='cidadeInput' value = '$cidadeInput'>"; ?>
								<?php echo "<input  type='hidden' id='bairroInput' name='bairroInput' value = '$bairroInput'>"; ?>
								<?php echo $btnEnvTodos; ?>
							</form>
						</div>
					</div>
					<?php
					include_once ("conexaoSQL.php");
					$sql =
						"SELECT 
					TB02115_CODIGO os,
					TB02115_CONTRATO Contrato,
					TB02115_CODCLI CodCli,
					TB01008_FANTASIA NomeCli,
					SUBSTRING(TB01008_FANTASIA, 1, 1) Inicial,
					TB02115_STATUS [Status],
					TB01073_NOME NomeStatus,
					TB02115_SOLICITANTE Solicitante,
					TB02115_BAIRRO Cidade,
					TB02115_NUMSERIE Serie,
					FORMAT(TB02115_DATA, 'dd/MM/yyyy') DataAbertura,
					TB01048_NOME Defeito,
				CASE 
					WHEN TB02115_PREVENTIVA = 'N' THEN 'N'
					WHEN TB02115_PREVENTIVA = 'S' THEN 'P'
					WHEN TB02115_PREVENTIVA = 'I' THEN 'I'
					WHEN TB02115_PREVENTIVA = 'D' THEN 'D'
					WHEN TB02115_PREVENTIVA = 'R' THEN 'R'
					WHEN TB02115_PREVENTIVA = 'A' THEN 'A'
				END Tipo
				FROM 
					TB02115
					LEFT JOIN TB01008 ON TB01008_CODIGO = TB02115_CODCLI
					LEFT JOIN TB01073 ON TB01073_CODIGO = TB02115_STATUS
					LEFT JOIN TB02116 ON TB02116_CODIGO = TB02115_CODIGO
					LEFT JOIN TB01048 ON TB01048_CODIGO = TB02116_DEFEITO
				WHERE
				    EXISTS (SELECT * FROM TB02130 WHERE TB02130_CODIGO = TB02115_CODIGO AND TB02130_STATUS = '$StatusSpecifico')
				    AND TB02115_STATUS IN ($StatusAguardTec)
					AND TB02115_DTFECHA IS NULL
					$cidade2
					$bairro2
					$estado2
				ORDER BY SUBSTRING(TB01008_FANTASIA, 1, 1)
				
				";
					$stmt = sqlsrv_query($conn, $sql);

					if ($stmt === false) {
						die(print_r(sqlsrv_errors(), true));
					}
					?>
					<table id="myTable" class="table table-border table-sm" style="font-size: 5px;">
						<thead>
							<tr>
								<th scope="col" style="width: auto;">ENCAMINHAR</th>
								<th scope="col" style="width: 0.1rem;">TIPO</th>
								<th scope="col" style="width:;">OS</th>
								<th scope="col" style="width:;">ABERTURA</th>
								<th onclick="/* sortTable(document.getElementById('myTable'),'asc',0)" scope="col"
									style="width:; */">NOME</th>
								<th scope="col" style="width:;">BAIRRO</th>
								<th scope="col" style="width:;">SÉRIE</th>
								<th scope="col" style="width:;">DEFEITO</th>
							</tr>
						</thead>
						<?php
						$tabela = "";
						$cont = 0;
						while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
							$cont++;
							$tabela .= "<tr>";
							$tabela .= "<td>
								<form class='form$cont' id='form$cont' action='$Url/TecOs2.php' method='post'>
									<input  type='hidden' id='codTec' name='codTec' value = '$codTec'>
									<input  type='hidden' id='nomeTec' name='nomeTec' value = '$nomeTec'>
									<input  type='hidden' id='estadoInput' name='estadoInput' value = '$estadoInput'>
									<input  type='hidden' id='cidadeInput' name='cidadeInput' value = '$cidadeInput'>
									<input  type='hidden' id='bairroInput' name='bairroInput' value = '$bairroInput'>
									<input  type='hidden' id='os' name='os' value = '$row[os]'>
									<input  type='submit' class='btn-tec' value='ENVIAR'/>
								</form>
							</td>";
							$tabela .= "<td style='width: 0.1rem; font-size: 0.7rem; color: red;'><b>" . $row['Tipo'] . "</b></td>";
							$tabela .= "<td style='background: $cor;'>
							 <form id='formC$cont' name='formC$cont'>
								<input class='btnDetal' type='submit' id='osC$cont' name='osC$cont' value='$row[os]'/>

								<script>
									$('#formC$cont').submit(function(e){
										e.preventDefault();  /*Interronpendo a atualização automatica da pagina*/ 
								
										var d_os$cont = $('#osC$cont').val();
									
										let resultados = document.getElementById('resultados');
									
										console.log(d_os$cont);
								
									$.ajax({
										url: '$Url/infoOs.php',
										method: 'POST',
										data: {numos: d_os$cont},
										/* dataType: 'json' */
									}).done(function(result$cont){
										console.log(result$cont);
										resultados.innerHTML = result$cont;
									});
								});
							  </script>
							 </form>
							</td>";
							$tabela .= "<td>" . $row['DataAbertura'] . "</td>";
							$tabela .= "<td>" . $row['NomeCli'] . "</td>";
							$tabela .= "<td><b>" . $row['Cidade'] . "</b></td>";
							$tabela .= "<td style='background: $cor;'>
							 <form id='formD$cont' name='formD$cont'>
								<input class='btnDetal' type='submit' id='serieD$cont' name='serieD$cont' value='$row[Serie]'/>

								<script>
									$('#formD$cont').submit(function(e){
										e.preventDefault();  /*Interronpendo a atualização automatica da pagina*/ 
								
										var d_serie$cont = $('#serieD$cont').val();
									
										let resultados = document.getElementById('resultados');
									
										console.log(d_serie$cont);
								
									$.ajax({
										url: '$Url/top10os.php',
										method: 'POST',
										data: {serie: d_serie$cont},
										/* dataType: 'json' */
									}).done(function(result$cont){
										console.log(result$cont);
										resultados.innerHTML = result$cont;
									});
								});
							  </script>
							 </form>
							</td>";
							$tabela .= "<td>" . $row['Defeito'] . "</td>";

							$tabela .= "</tr>";
						}
						$tabela .= "</table>";
						print ($tabela);
						?>
				</div>


			</div>
		</div>
	</section>
	<script>
		$(document).ready(function () {
			$('#tecnico').select2();
		});
	</script>
</body>

</html>