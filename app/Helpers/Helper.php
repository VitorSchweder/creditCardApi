<?php
namespace App\Helpers;

class Helper {
    public static function removeMoneyCaracter($valor) {
        if ($valor) {
            return
            str_replace(',', '.',
                str_replace('.', '',
                    str_replace('R$ ', '', $valor)
                )
            );
        }

        return 0;
    }
 }
