<?php
function dec2x($num, $base): array
{

    $num = filter_var($num, FILTER_VALIDATE_INT);
    $base = filter_var($base, FILTER_VALIDATE_INT, ["options" => ["min_range" => 2, "max_range" => 9]]);

    if (!$base && !$num) {
        return ['Error: número y bases errorenos', true];
    } else if (!$num) {
        return ['Error: número erroneo', true];
    } else if (!$base) {
        return ['Error: base erronea <br>(tiene que estar entre 2 y 9)', true];
    } else {
        $transformacion = "";
        $resultado = $num;

        while (intdiv($resultado, $base) >= $base) {
            $transformacion = ($resultado % $base) . $transformacion;
            $resultado = intdiv($resultado, $base);
        }
        $transformacion = ($resultado % $base) . $transformacion;
        $transformacion = intdiv($resultado, $base) . $transformacion;
        return [$transformacion, false];
    }
}
