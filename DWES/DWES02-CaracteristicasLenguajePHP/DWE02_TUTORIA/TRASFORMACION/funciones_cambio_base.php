<?php

// Convierte de decimal a una base concreta
function dec2x(int $numero, int $base): string {
    $conversion = '';

    do {
        $resto = $numero % $base;
        if ($resto > 9) {
            $resto = chr(ord('A') + $resto - 10);
        }
        $conversion = $resto . $conversion;
        $numero = intdiv($numero, $base);
    } while ($numero > 0);

    return $conversion;
}

// Convierte de una base concreta a decimal
function x2dec(string $numero, int $base) : int {
    $conversion = 0;
    
    for ($i=0; $i < strlen($numero); $i++) {
        // Sacar el digito
        $digito = substr(strrev((string) $numero), $i, 1);
        // Si no es un número -> lo convierto en numero
        if(!is_numeric($digito)){
            $digito = (ord($digito) - ord('A') + 10);
        }
        $conversion += $digito * pow($base, $i);
    }

    return $conversion;
}

// Pasar de base x a base y sin pasar por decimal
// function x2y (string $numero, int $baseOrigen, int $baseDestino) : string {
//     return dec2x(x2dec($numero, $baseOrigen), $baseDestino);
// }


