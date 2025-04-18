<?php
namespace UTILS;

class ENV{

  /**
   * Método responsável por carregar as variáveis de ambiente do projeto
   * @param  string $dir Caminho absoluto da pasta onde encontra-se o arquivo .env
   */
  public static function load($dir)
  {
     //VERIFICA SE O ARQUIVO .ENV EXISTE
     if(!file_exists($dir.'/.env'))
     {
        return false;
     }

     //DEFINE AS VARIÁVEIS DE AMBIENTE
     $lines = file($dir.'/.env');
     foreach($lines as $line)
     {
         $line = trim($line);
         if(!empty($line) && !str_starts_with($line,'#')){
            putenv(trim($line));
            if (preg_match('/^([^=]+)=(.*)$/', trim($line), $matches)) {
               $key = $matches[1];
               $value = $matches[2];
               $_ENV[$key] = $value;
            }
        }
     }
  }
}

?>