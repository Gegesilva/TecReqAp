<?php
header('Content-type: text/html; charset=utf-8');
include_once("conexaoSQL.php");
include_once("config.php");


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


$os = $_POST['os'];

$tecnicoLinha = $_POST['tecnicoLinha'];

$osLinha = $_POST['osLinha'];

$filtroCidade = $_POST['FiltroCidade'];

$osLinhaRet = $_POST['osLinhaRet'];


/* PEGA NOME TEC */
if (isset($codTec)) {
	$sql = "
				SELECT 
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
	<link rel="stylesheet" href="css/style3.css">

	<script src="js/jQuery/jquery-3.5.1.min.js"></script>
	<script src="js/script.js"></script>
</head>

<body>
	<div class="container-fluid">
		<header>
			<!-- <div class="box_form"> -->
			<?php /*  echo "<h1  class='titulo'><b>$codTecSes2</b></h1>"; */ ?>
			<form id="form-filters" class="form-filters" method='post' action="TecOs1.php">
				<a class="btn-logoff" href="login.php"></a>
				<label for="form-filters" class="labelTecOS">Detalhar Técnico</label>
				<select class="selectTecnico" id="codTec" name="codTec" onchange="this.form.submit()" required>
					<option name='codTec' value="1">Todos</option>
					<?php
					include_once("conexaoSQL.php");
					$sql =
						"
									SELECT 
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

					<!-- Filtro Estado -->
					<div class="filters-baixo">
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
			<!-- </div> -->
		</header>

		</br>
		<div class="container-geral">
			<div class="container" id="resultados">
				<?php

				$sql1 = "SELECT 
							TB01024_CODIGO Cod,
							CAST(TB01024_NOME AS VARCHAR(MAX)) Nome,
								(SELECT 
									COUNT(TB02115_CODIGO) 
								FROM TB02115  
								WHERE TB02115_CODTEC = TB01024_CODIGO 
								AND TB02115_STATUS IN ('$StatusComTec')
								AND TB02115_CODCLI <> '00000000'
								AND TB02115_PREVENTIVA <> 'R'
								AND TB02115_DTFECHA IS NULL) Qtde
							FROM TB01024 A
							WHERE TB01024_SITUACAO = 'A'
							AND EXISTS (SELECT 
											TB02115_STATUS 
										FROM TB02115 
										WHERE TB01024_CODIGO = TB02115_CODTEC  
										AND TB02115_STATUS IN ('$StatusComTec')
										AND TB02115_CODCLI <> '00000000'
										AND TB02115_PREVENTIVA <> 'R'
										AND TB02115_DTFECHA IS NULL)
							";

				$stmt1 = sqlsrv_query($conn, $sql1);
				$containers = "";
				$contGeral = 0;
				while ($row1 = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC)) {
					$contGeral++;
					$containers .= "<div>";


					$sql2 = "SELECT 
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
							LEFT JOIN TB02111 ON TB02111_CODIGO = TB02115_CONTRATO 
						WHERE
							 TB02115_STATUS IN ('$StatusComTec')
							 AND TB02115_CODTEC = '$row1[Cod]'
							 AND TB02115_CODCLI <> '00000000'
							 AND TB02115_PREVENTIVA <> 'R'
							 AND TB02115_DTFECHA IS NULL
							 AND TB02111_TIPOCONTR = 'L'
						ORDER BY TB02115_CODIGO 
						
						";
					$stmt2 = sqlsrv_query($conn, $sql2);

					/* $tabela2 .= ""; */

					$tabela2 = "";
					$tabela2 .= "<table  class='table table-borderless' style='font-size: 9px; background-color: white; border-radius: 1rem; margin-left: 7px; margin-top: 5px;'>
										<thead>
										    <tr><th colspan='6' style='color: Blue; font-size: 10px;'>$row1[Nome] - <b style='color: red; font-size: 15px;'>$row1[Qtde] OS</b></th></tr>
											<tr>
												<th scope='col' style='width:;'>TIPO</th>
												<th scope='col' style='width:;'>OS</th>
												<th scope='col' style='width:;'>ABERTURA</th>                                   
												<th scope='col' style='width:;'>NOME</th>                                                                  
												<th scope='col' style='width:;'>BAIRRO</th>
												<th scope='col' style='width:;'>SÉRIE</th>                                                                  
											</tr>
										</thead>";
					$contOsTec = 0;
					$contSerieTec = 0;
					while ($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
						$tabela2 .= "<tbody>";
						$tabela2 .= "<tr>";
						$tabela2 .= "<td style='font-size: 0.7rem; color: blue;'><b>'" . $row2['Tipo'] . "</b></td>";
						/* $tabela2 .= "<td><b>".$row1['Nome']."</b></td>"; */
						$tabela2 .= "<td>" . $row2['os'] . "</td>";
						$tabela2 .= "<td>" . $row2['DataAbertura'] . "</td>";
						$tabela2 .= "<td>" . $row2['NomeCli'] . "</td>";
						$tabela2 .= "<td>" . $row2['Cidade'] . "</td>";
						$tabela2 .= "<td>" . $row2['Serie'] . "</td>";
						$tabela2 .= "<td>";
						$tabela2 .= "</tr>";
						$tabela2 .= "<tbody>";

						$containers .= "</table>";
						$containers .= "</div>";
					}
					print ($tabela2);
				}
				print ($containers);
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
	<script src="js/jQuery/jquery-3.5.1.min.js"></script>
	<script src="js/script.js"></script>
</body>

</html>