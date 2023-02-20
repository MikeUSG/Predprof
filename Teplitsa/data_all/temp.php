<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="10">
    <title>Температура</title>
</head>
<link href="temp.css" rel="stylesheet">
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

  $t1 = $j1 -> temperature;
  $t2 = $j2 -> temperature;
  $t3 = $j3 -> temperature;
  $t4 = $j4 -> temperature;

  $a = date('H:i:s');
  $b = strtotime($a);
  $b += 2 * 3600;
  $a = date('H:i:s', $b);

  
  $ins = "INSERT INTO `temperature`(`id`, `t_1`, `t_2`, `t_3`, `t_4`, `time`) VALUES (NULL,'$t1','$t2','$t3','$t4','$a')";
  mysqli_query($mysql, $ins);
  /*echo $j1 -> temperature, ' - ', $j1 -> id."<br>";
  echo $j2 -> temperature, ' - ', $j2 -> id."<br>";
  echo $j3 -> temperature, ' - ', $j3 -> id."<br>";
  echo $j4 -> temperature, ' - ', $j4 -> id."<br>";
  */
  //echo date('H:i:s', $b);

  /*while(true) {
    //mysql_query();
    echo $j -> temperature;
    sleep(1);
}*/
?>
<b style="font-size: 40px; display: flex; justify-content: center;">Температура</b>
<b style="font-size: 20px;">Текущее время - <?php echo date('H:i:s', $b); ?></b>
<table class="table">
	<thead>
		<tr>
			<th>1</th>
			<th>2</th>
			<th>3</th>
			<th>4</th>
            <th>Время</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo $t1;?> °C</td>
			<td><?php echo $t2;?> °C</td>
			<td ><?php echo $t3;?> °C</td>
			<td><?php echo $t4;?> °C</td>
            <td><?php echo $a;?></td>
		</tr>
	</tbody>

<?php
    $oc = "Открыта";
    $oc2 = "Открыть форточку";
?>
<?php echo "<br>";?>
<?php echo "<br>";?>
<b style="font-size: 20px;">Средняя температура: <?php $middle = intdiv($t1 + $t2 + $t3 + $t4, 4); echo $middle; ?> °C</b>
<?php echo "<br>";?>
<?php echo "<br>";?>
<b style="font-size: 20px;">Форточка: <?php echo $oc;?></b>
<?php echo "<br>";?>
<?php echo "<br>";?>
<form action="temp.php" method="POST">
    <button class = "leaf"><?php echo $oc2;?></button>
</form>
<?php /*

$handle = curl_init('https://dt.miet.ru/ppo_it/api/fork_drive/');

$data = [
    'state' => 1
];

$encodedData = json_encode($data);

curl_setopt($handle, CURLOPT_POST, 1);
curl_setopt($handle, CURLOPT_POSTFIELDS, $encodedData);
curl_setopt($handle, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$result = curl_exec($handle);

$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ($code == 200 || $code == 204) {
    echo 'Запрос PATCH отправлен успешно';
} else {
    echo 'Произошла ошибка при отправке запроса PATCH';
}*/
?>
<?php echo "<br>";?>
<?php echo "<br>";?>
<a href="/Teplitsa/tepl.php" style="color:red; text-decoration: underline;">На главную</a>
</body>
</html>

