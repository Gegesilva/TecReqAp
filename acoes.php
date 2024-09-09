<?php
include_once "config.php";

function enviaReqTec($conn, $req, $codMot, $login, $nomeMot, $StatusComMot)
{
    /* CONFERE SE JÁ REGISTRO NO 2096*/
    $sql3 = "SELECT 
        1 Existe
    FROM TB02096
    WHERE TB02096_CODIGO = '$req'
";
    $stmt = sqlsrv_query($conn, $sql3);
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $existe = $row['Existe'];
    }


    if ($existe == '1') {
        $sql4 = "UPDATE 
                TB02096
            SET 
                TB02096_CODMOTO = '$codMot',
                TB02096_DTSAIDA = GETDATE(),
                TB02096_CONFERIDO = '$login'
            WHERE
                TB02096_CODIGO = '$req'
    ";
        $stmt = sqlsrv_query($conn, $sql4);

    } else {
        $sql5 = "INSERT INTO TB02096
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
        $stmt = sqlsrv_query($conn, $sql5);
    }

    $sql6 = "UPDATE TB02021 
SET 
    TB02021_STATUS = '$StatusComMot',
    TB02021_DTALT = GETDATE(),
    TB02021_OPALT = '$login'
WHERE TB02021_CODIGO = '$req'


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
            (SELECT TOP 1
            '$req',
            '$login',
            'APP ROT REQ',
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
            --AND NOT EXISTS (SELECT * FROM TB02130 WHERE TB02130_CODIGO = '$req' AND TB02130_STATUS = '$StatusComMot')
        ) 

        /* UPDATE TB02130
        SET TB02130_CODTEC = '$codMot',
            TB02130_NOMETEC = '$nomeMot',
            TB02130_USER = '$login',
            TB02130_DATA = GETDATE(),
            TB02130_OBS = 'APP ROT REQ'
        WHERE TB02130_CODIGO = '$req'
            AND TB02130_STATUS = '$StatusComMot' */
";
    $stmt = sqlsrv_query($conn, $sql6);
}

function mudaMotLinha($conn, $motoristaLinha, $login, $reqLinha)
{
    $sql7 = "UPDATE 
				TB02096
			SET 
				TB02096_CODMOTO = '$motoristaLinha',
				TB02096_DTSAIDA = GETDATE(),
				TB02096_CONFERIDO = '$login'
			WHERE
				TB02096_CODIGO = '$reqLinha'
			";
    $stmt = sqlsrv_query($conn, $sql7);
}

function mudaTdReqMot($conn, $motoristaTdReq, $login, $codMot)
{
    $sql8 = "UPDATE 
				TB02096 
			SET 
				TB02096_CODMOTO = '$motoristaTdReq',
				TB02096_DTSAIDA = GETDATE(),
				TB02096_CONFERIDO = '$login'
			WHERE
				TB02096_CODMOTO = '$codMot'
			";
    $stmt = sqlsrv_query($conn, $sql8);
}

function devolveRot($conn, $obs, $CodMotGeral, $login, $reqLinhaRet, $StatusRot, $nomeMot, $codMot)
{
    if (!isset($obs) || $obs == NULL || $obs == "") {
        $obs = 'APP ROT REQ';
    }

    $sql2 = "UPDATE 
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
				TB02021_OPALT = '$login'
				--TB02021_OBS = '$obs'
			WHERE TB02021_CODIGO = '$reqLinhaRet'

			
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
						(SELECT TOP 1
						'$reqLinhaRet',
						'$login',
						'$obs',
						GETDATE(), 
						GETDATE(), 
						'$StatusRot',
						'V',
						'$nomeMot',
						TB02021_CODCLI,
						TB02021_CODEMP,
						(SELECT TB01021_NOME FROM TB01021 WHERE TB01021_CODIGO = '$StatusRot'),
						'$codMot'
						FROM TB02021
						WHERE TB02021_CODIGO = '$reqLinhaRet'
						--AND NOT EXISTS (SELECT * FROM TB02130 WHERE TB02130_CODIGO = '$reqLinhaRet' AND TB02130_STATUS = '$StatusRot')
					) 
			";
    $stmt = sqlsrv_query($conn, $sql2);
}

function mudaMassaCidade($conn, $cidadeBotao, $StatusAguardMot, $bairro2, $codMot, $login, $nomeMot, $StatusComMot)
{
    $sql9 = "DECLARE @CODIGO VARCHAR(6);
	
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
							@CODIGO,
							'$login',
							'APP ROT REQ',
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
							--AND NOT EXISTS (SELECT * FROM TB02130 WHERE TB02130_CODIGO = @CODIGO AND TB02130_STATUS = '$StatusComMot')
						) 

			
		      
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
							@CODIGO,
							'$login',
							'APP ROT REQ',
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
							--AND NOT EXISTS (SELECT * FROM TB02130 WHERE TB02130_CODIGO = @CODIGO AND TB02130_STATUS = '$StatusComMot')
						) 
					
			FETCH NEXT FROM CURSOR_UP_MASSA_END
			INTO @CODIGO
		END
		CLOSE CURSOR_UP_MASSA_END
		DEALLOCATE CURSOR_UP_MASSA_END
	

		END;
		";
	$stmt = sqlsrv_query($conn, $sql9);
}