<?php
include_once "config.php";
function filtroMot($conn, $nomeMot)
{
    $sql = "SELECT 
                TB01077_CODIGO CodMot,
                TB01077_NOME NomeMot
            FROM TB01077
            WHERE 
            TB01077_SITUACAO = 'A'
            ORDER BY TB01077_NOME
        ";

    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }


    $opcao1 = "";

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $opcao1 .= "<option name='Motorista' value='$row[CodMot]'>$row[NomeMot]</option>";

    }

    $opcao1 .= " <option disabled selected>$nomeMot</option>
									             </select>";
    print ($opcao1);
}
function filtroEstado($conn, $StatusAguardMot, $estadoInput)
{
    $sql = "SELECT DISTINCT
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
}

function filtroCidade($conn, $StatusAguardMot, $estado2, $cidadeInput)
{
    $sql = "SELECT DISTINCT
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
}