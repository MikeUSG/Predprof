<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="10">
    <title>Влажность почвы</title>
</head>
<link href="v_e.css" rel="stylesheet">
<body>
<?php 
 $mysql = mysqli_connect('localhost', 'MikeUSG', 'Mikle21032008', 'Teplitsa');
  
 if(!$mysql) {
     die('Не получилось подключиться к базе данных');
 }
  
  $temp1 = curl_init("https://dt.miet.ru/ppo_it/api/hum/1");
  $temp2 = curl_init("https://dt.miet.ru/ppo_it/api/hum/2");
  $temp3 = curl_init("https://dt.miet.ru/ppo_it/api/hum/3");
  $temp4 = curl_init("https://dt.miet.ru/ppo_it/api/hum/4");
  $temp5 = curl_init("https://dt.miet.ru/ppo_it/api/hum/5");
  $temp6 = curl_init("https://dt.miet.ru/ppo_it/api/hum/6");

  curl_setopt($temp1, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($temp2, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($temp3, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($temp4, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($temp5, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($temp6, CURLOPT_RETURNTRANSFER, 1);


  $res1 = curl_exec($temp1);
  $res2 = curl_exec($temp2);
  $res3 = curl_exec($temp3);
  $res4 = curl_exec($temp4);
  $res5 = curl_exec($temp5);
  $res6 = curl_exec($temp6);

  $j1 = json_decode($res1, false);
  $j2 = json_decode($res2, false);
  $j3 = json_decode($res3, false);
  $j4 = json_decode($res4, false);
  $j5 = json_decode($res5, false);
  $j6 = json_decode($res6, false);

  $t1 = $j1 -> humidity;
  $t2 = $j2 -> humidity;
  $t3 = $j3 -> humidity;
  $t4 = $j4 -> humidity;
  $t5 = $j5 -> humidity;
  $t6 = $j6 -> humidity;

  $a = date('H:i:s');
  $b = strtotime($a);
  $b += 2 * 3600;
  $a = date('H:i:s', $b);

  
  $ins = "INSERT INTO `vlasnost_earth`(`id`,`v_e_1`, `v_e_2`, `v_e_3`, `v_e_4`,`v_e_5`, `v_e_6`, `time`) VALUES (NULL,'$t1','$t2','$t3','$t4','$t5','$t6', '$a')";
  mysqli_query($mysql, $ins);
  /*echo $j1 -> humidity, ' - ', $j1 -> id."<br>";
  echo $j2 -> humidity, ' - ', $j2 -> id."<br>";
  echo $j3 -> humidity, ' - ', $j3 -> id."<br>";
  echo $j4 -> humidity, ' - ', $j4 -> id."<br>";*/
  
  //echo date('H:i:s', $b);

  /*while(true) {
    //mysql_query();
    echo $j -> humidity;
    sleep(1);
}*/

?>
<b style="font-size: 40px; display: flex; justify-content: center;">Влажность почвы</b>
<table class="table">
	<thead>
		<tr>
			<th><?php echo $j1 -> id ?></th>
			<th><?php echo $j2 -> id ?></th>
			<th><?php echo $j3 -> id ?></th>
			<th><?php echo $j4 -> id ?></th>
            <th><?php echo $j5 -> id ?></th>
			<th><?php echo $j6 -> id ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo $t1;?></td>
			<td><?php echo $t2;?></td>
			<td ><?php echo $t3;?></td>
			<td><?php echo $t4;?></td>
            <th><?php echo $t5;?></th>
			<th><?php echo $t6;?></th>
            
		</tr>
	</tbody>
<?php
    $oc = "Включен";
    $oc2 = "Включить полив";
?>
<b style="font-size: 20px;">Текущее время - <?php echo date('H:i:s', $b); ?></b>
<?php echo "<br>";?>
<?php echo "<br>";?>
<b style="font-size: 20px;">Средняя влажность почвы: <?php $middle = intdiv($t1 + $t2 + $t3 + $t4 + $t5 + $t6, 6); echo $middle;?> φ</b>
<?php echo "<br>";?>
<?php echo "<br>";?>
<b style="font-size: 20px;">Полив: <?php echo $oc;?></b>
<?php echo "<br>";?>
<?php echo "<br>";?>
<button class = "leaf"><?php echo $oc2;?></button>
<?php echo "<br>";?>
<?php echo "<br>";?>
<a href="/Teplitsa/tepl.php" style="color:red; text-decoration: underline;">На главную</a>


</body>
</html>