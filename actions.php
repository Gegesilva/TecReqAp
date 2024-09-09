<?php
include_once ("conexaoSQL.php");
function enviaOSTec($os, $codTec, $StatusComTec, $login, $conn)
{

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
			AND TB02115_DTFECHA IS NULL
			AND TB02115_CODCLI <> '00000000'
			AND TB02115_PREVENTIVA <> 'R'


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
					AND TB02115_DTFECHA IS NULL
					AND TB02115_CODCLI <> '00000000'
					AND TB02115_PREVENTIVA <> 'R'
				) 
		";
	$stmt = sqlsrv_query($conn, $sql);
}


function mudaTecLinha($tecnicoLinha, $login, $osLinha, $StatusComTec, $conn)
{
	$sql1 =
		"UPDATE 
				TB02115 
			SET 
				TB02115_CODTEC = '$tecnicoLinha',
				TB02115_DTALT = GETDATE(),
				TB02115_OPALT = '$login'
			WHERE
				TB02115_CODIGO = '$osLinha'
				AND TB02115_CODCLI <> '00000000'
			    AND TB02115_PREVENTIVA <> 'R'

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
                        '$osLinha',
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
                        '$tecnicoLinha'
                        FROM TB02115
                        LEFT JOIN TB01073 ON TB01073_CODIGO = '$StatusComTec'
                        LEFT JOIN TB01024 ON TB01024_CODIGO = '$tecnicoLinha'
                        WHERE TB02115_CODIGO = '$osLinha'
                        AND NOT EXISTS (SELECT TB02130_CODIGO FROM TB02130 WHERE TB02130_CODIGO = '$osLinha' AND TB02130_CODTEC = '$tecnicoLinha' AND TB02130_STATUS = '$StatusComTec')
						AND TB02115_CODCLI <> '00000000'
						AND TB02115_PREVENTIVA <> 'R'
                    ) 
			";
	$stmt = sqlsrv_query($conn, $sql1);
}

function mudaTodasAsOSTec($tecnicoTdOs, $login, $codTec, $StatusComTec, $conn)
{
	$sql1 =
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
					TB02115_CODIGO,
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
					'$tecnicoTdOs'
				FROM TB02115
				LEFT JOIN TB01073 ON TB01073_CODIGO = '$StatusComTec'
				LEFT JOIN TB01024 ON TB01024_CODIGO = '$tecnicoTdOs'
				WHERE
					TB02115_CODTEC = '$codTec'
					AND TB02115_STATUS = '$StatusComTec'
					AND TB02115_CODCLI <> '00000000'
					AND TB02115_PREVENTIVA <> 'R')
					

				UPDATE 
					TB02115 
				SET 
					TB02115_CODTEC = '$tecnicoTdOs',
					TB02115_DTALT = GETDATE(),
					TB02115_OPALT = '$login'
				WHERE
					TB02115_CODTEC = '$codTec'
					AND TB02115_CODCLI <> '00000000'
					AND TB02115_PREVENTIVA <> 'R'
			";
	$stmt = sqlsrv_query($conn, $sql1);
}

function devolveRoterizacao($login, $osLinhaRet, $conn)
{
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
				AND TB02115_CODCLI <> '00000000'
				AND TB02115_PREVENTIVA <> 'R'


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
                        '$osLinhaRet',
                        '$login',
                        'APP GESTÃO OS',
                        GETDATE(), 
                        GETDATE(), 
                        '00',
                        'O',
                        TB01024_NOME,
                        TB02115_CODCLI,
                        TB02115_CODEMP,
                        TB01073_NOME,
                        '0000'
                        FROM TB02115
                        LEFT JOIN TB01073 ON TB01073_CODIGO = '00'
                        LEFT JOIN TB01024 ON TB01024_CODIGO = '0000'
                        WHERE TB02115_CODIGO = '$osLinhaRet'
                        AND NOT EXISTS (SELECT TB02130_CODIGO FROM TB02130 WHERE TB02130_CODIGO = '$osLinhaRet' AND TB02130_CODTEC = '0000' AND TB02130_STATUS = '00')
						AND TB02115_CODCLI <> '00000000'
						AND TB02115_PREVENTIVA <> 'R'
                    ) 
			";
	$stmt = sqlsrv_query($conn, $sql1);
}

function envioOSMassaTec($login, $StatusComTec, $codTec, $cidadeBotao, $bairro2, $StatusAguardTec, $conn)
{
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
					TB02115_CODIGO,
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
					WHERE TB02115_CIDADE = '$cidadeBotao'	
					$bairro2
					AND TB02115_STATUS IN ($StatusAguardTec)
					AND TB02115_CODCLI <> '00000000'
					AND TB02115_PREVENTIVA <> 'R'
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
					AND TB02115_CODCLI <> '00000000'
					AND TB02115_PREVENTIVA <> 'R'
					$bairro2

		";

	$stmt = sqlsrv_query($conn, $sql);
}