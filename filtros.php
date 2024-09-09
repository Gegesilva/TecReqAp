<?php
include_once ("conexaoSQL.php");
function filtroTec($nomeTec, $conn)
{

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

    $opcao1 = "";

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $opcao1 .= "<option name='Tecnico' value='$row[CodTec]'>$row[NomeTec]</option>";

    }

    $opcao1 .= " <option disabled selected>$nomeTec</option>
                         </select>";
    return print ($opcao1);
}



function filtroEstado($StatusAguardTec, $estadoInput, $conn)
{
    $sql = "SELECT DISTINCT
                TB02115_ESTADO Estado
            FROM 
                TB02115
            WHERE
                TB02115_STATUS IN ($StatusAguardTec) AND
                TB02115_ESTADO IS NOT NULL
                AND TB02115_ESTADO <> ''
                AND TB02115_DTFECHA IS NULL
                AND TB02115_CODCLI <> '00000000'
                AND TB02115_PREVENTIVA <> 'R'
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
    return print ($opcao1);
}


function filtroCidade($StatusAguardTec, $estado2, $conn, $cidadeInput)
{
    $sql =
        "SELECT DISTINCT
            TB02115_CIDADE Cidade
         FROM 
            TB02115
         WHERE
            TB02115_STATUS IN ($StatusAguardTec) AND
            TB02115_CIDADE IS NOT NULL
            AND TB02115_CIDADE <> ''
            AND TB02115_DTFECHA IS NULL
            AND TB02115_CODCLI <> '00000000'
            AND TB02115_PREVENTIVA <> 'R'
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

    return print ($opcao1);
}


function filtroBairro($StatusAguardTec, $cidade2, $estado2, $bairroInput, $conn)
{
    $sql = "SELECT DISTINCT
                TB02115_BAIRRO Bairro
            FROM 
                TB02115
            WHERE
                TB02115_STATUS IN ($StatusAguardTec)
                AND TB02115_BAIRRO IS NOT NULL
                AND TB02115_BAIRRO <> ''
                AND TB02115_DTFECHA IS NULL
                AND TB02115_CODCLI <> '00000000'
                AND TB02115_PREVENTIVA <> 'R'
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

    return print ($opcao1);

}