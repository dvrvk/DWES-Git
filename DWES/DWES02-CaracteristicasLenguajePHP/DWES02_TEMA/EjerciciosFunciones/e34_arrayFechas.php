<?php
/*
Realiza un programa que dado un array con fechas de nacimiento expresadas en el formato "dd/mm/aaaa" devuelva las fechas en el formato "dd mes en letras yyyy"  de personas que han nacido entre 1998 y 2010 ordenadas por el numero de letras del mes en que han nacido sumado al digito que indica su día de nacimiento.
-> Puedes utilizar array_filter, usort y array_map para realizar el ejercicio.
-> Puedes utilizar el siguiente array de fechas como dato de entrada:
$fechas = ["01/10/2045", "15/03/2009", "30/10/1989", "08/01/2015", "23/04/2010", "20/08/2005", "09/06/2003","21/02/2012", "16/11/2020", "19/10/2000", "03/07/1998", "11/09/2004", "13/10/2009", "07/08/2001", "01/05/2008", "11/07/2022", "03/12/2008", "05/10/2021", "27/04/2019", "19/04/1980", "04/05/2003"]
-> Se pueden manejar los nombres de los meses en inglés
*/

$fechas = ["01/10/2045", "15/03/2009", "30/10/1989", "08/01/2015", "23/04/2010", "20/08/2005", "09/06/2003","21/02/2012", "16/11/2020", "19/10/2000", "03/07/1998", "11/09/2004", "13/10/2009", "07/08/2001", "01/05/2008", "11/07/2022", "03/12/2008", "05/10/2021", "27/04/2019", "19/04/1980", "04/05/2003"];

echo "<pre>";
var_dump($fechas);
echo "</pre>";

$orden = function ($f1, $f2) {
    $valor1 = strlen($f1->format('F')) + $f1->format('j');
    $valor2 = strlen($f2->format('F')) + $f2->format('j');
    return $valor1 - $valor2;
};

// Formatear las fechas
$fechasDate = array_map(fn($fecha) => DateTime::createFromFormat('d/m/Y', $fecha), $fechas);
// Filtrar entre 1998 y 2010
$fechasFiltradas = array_filter($fechasDate, fn($fecha) => $fecha->format('Y') >= 1998 && $fecha->format('Y') < 2010);
// Ordenar fechas
usort($fechasFiltradas, $orden);
// Convertir al formato que nos piden
$fechasFinal = array_map(fn($fecha) => $fecha->format('d F Y'), $fechasFiltradas);

echo "<pre>";
var_dump($fechasFinal);
echo "</pre>";

?>