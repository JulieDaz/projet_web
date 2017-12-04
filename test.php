<?php
  $jour = date('d');

  $heure = 8;


  $i = 0;
  $j = 0;
  $heureSortie = date('H', mktime(18,0,0));

  while($i < 40){

    $dateTab[] = date('l H:i', mktime(8 ,0 + (30 * $i) ,0 ,date('m'), date('d')+$j , date('Y')));
    echo $dateTab[$i];
    echo '</br>';

    if($dateTab[$i] == 'Sunday 18:00'){

      $j++;
      $dateTab[] = date_modify(date_create_from_format('l H:i', $dateTab[$i]), '+ 14 hours');
    }



    $i++;
  }



  // for($i = 0; $i < 40 ; $i++){
  //
  //   echo dateTab[$i];
  //   $date = date_format($date, 'H');
  //   echo $date;

  // }
?>
