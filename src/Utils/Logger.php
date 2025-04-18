<?php

declare(strict_types=1);

namespace App\Utils;

use DateTime;

trait Logger
{
  public static function log($mensagem)
  {
    $date = new DateTime();
    $now = $date->format('H:i:s Y-m-d ');
    
    echo $now . " [LOG]: " . $mensagem . PHP_EOL;
  }

}