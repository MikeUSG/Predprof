<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="10">
    <title>Влажность воздуха</title>
</head>
<link href="v_a.css" rel="stylesheet">
<body>
<?php 
 $mysql = mysqli_connect('localhost', 'MikeUSG', 'Mikle21032008', 'Teplitsa');
  
 if(!$mysql) {
     die('Не получилось подключиться к базе данных');
 }
  
  $temp1 = curl_init("https://dt.miet.ru/ppo_it/api/temp_hum/1");
  $temp2 = curl_init("https://dt.miet.ru/ppo_it/api/temp_hum/2");
  $temp3 = curl_init("https://dt.miet.ru/ppo_it/api/temp_hum/3");
  $temp4 = curl_init("https://dt.miet.ru/ppo_it/api/temp_hum/4");

  curl_setopt($temp1, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($temp2, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($temp3, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($temp4, CURLOPT_RETURNTRANSFER, 1);


  $res1 = curl_exec($temp1);
  $res2 = curl_exec($temp2);
  $res3 = curl_exec($temp3);
  $res4 = curl_exec($temp4);

  $j1 = json_decode($res1, false);
  $j2 = json_decode($res2, false);
  $j3 = json_decode($res3, false);
  $j4 = json_decode($res4, false);

  $t1 = $j1 -> humidity;
  $t2 = $j2 -> humidity;
  $t3 = $j3 -> humidity;
  $t4 = $j4 -> humidity;
  $a = date('H:i:s');
  $b = strtotime($a);
  $b += 2 * 3600;
  $a = date('H:i:s', $b);
  
  $ins = "INSERT INTO `vlasnost_air` (`id`, `v_a_1`, `v_a_2`, `v_a_3`, `v_a_4`, `time`) VALUES (NULL,'$t1','$t2','$t3','$t4','$a')";
  mysqli_query($mysql, $ins);
  /*echo $j1 -> humidity, ' - ', $j1 -> id."<br>";
  echo $j2 -> humidity, ' - ', $j2 -> id."<br>";
  echo $j3 -> humidity, ' - ', $j3 -> id."<br>";
  echo $j4 -> humidity, ' - ', $j4 -> id."<br>";*/
  
  /*while(true) {
    //mysql_query();
    echo $j -> humidity;
    sleep(1);
}*/
function table() {
    $temp1 = curl_init("https://dt.miet.ru/ppo_it/api/temp_hum/1");
  $temp2 = curl_init("https://dt.miet.ru/ppo_it/api/temp_hum/2");
  $temp3 = curl_init("https://dt.miet.ru/ppo_it/api/temp_hum/3");
  $temp4 = curl_init("https://dt.miet.ru/ppo_it/api/temp_hum/4");

  curl_setopt($temp1, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($temp2, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($temp3, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($temp4, CURLOPT_RETURNTRANSFER, 1);


  $res1 = curl_exec($temp1);
  $res2 = curl_exec($temp2);
  $res3 = curl_exec($temp3);
  $res4 = curl_exec($temp4);

  $j1 = json_decode($res1, false);
  $j2 = json_decode($res2, false);
  $j3 = json_decode($res3, false);
  $j4 = json_decode($res4, false);

  $t1 = $j1 -> humidity;
  $t2 = $j2 -> humidity;
  $t3 = $j3 -> humidity;
  $t4 = $j4 -> humidity;
echo "<tr>
        <td>$t1</td>
        <td>$t2</td>
        <td>$t3</td>
        <td>$t4</td>
    </tr>";
}
?>
<b style="font-size: 40px; display: flex; justify-content: center;">Влажность воздуха</b>
<b style="font-size: 20px; display: flex;">Текущее время - <?php echo date('H:i:s', $b); ?></b>
<table class="table">
	<thead>
		<tr>
			<th><?php echo $j1 -> id ?></th>
			<th><?php echo $j2 -> id ?></th>
			<th><?php echo $j3 -> id ?></th>
			<th><?php echo $j4 -> id ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo $t1;?></td>
			<td><?php echo $t2;?></td>
			<td ><?php echo $t3;?></td>
			<td><?php echo $t4;?></td>
		</tr>
	</tbody>
<?php
    $oc = "Включено";
    $oc2 = "Включить увлажнение";
?>
<?php echo "<br>";?>
<b style="font-size: 20px;">Средняя влажность воздуха: <?php $middle = intdiv($t1 + $t2 + $t3 + $t4, 4); echo $middle;?> φ</b>
<?php echo "<br>";?>
<?php echo "<br>";?>
<b style="font-size: 20px;">Увлажнение: <?php echo $oc;?></b>
<?php echo "<br>";?>
<?php echo "<br>";?>
<button class = "leaf"><?php echo $oc2;?></button>
<?php echo "<br>";?>
<?php echo "<br>";?>
<a href="/Teplitsa/tepl.php" style="color:red; text-decoration: underline;">На главную</a>
</body>
</html>