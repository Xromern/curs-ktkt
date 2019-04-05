<?php
include $_SERVER['DOCUMENT_ROOT'] . '/module/include.php';
if($login->A() || $login->T()){
$result = $_news->show_advertisement();
echo '<tr> <th>Назва</th><th>Опис</th><th>Дія</th></tr>';
while (list($id, $caption, $text, $date) = mysqli_fetch_array($result)) {
	echo "<tr data-id='$id' class='advertisement-tr'><td><textarea class='container-advertisement-blocks-caption'>$caption</textarea></td><td><textarea class='container-advertisement-blocks-text'>$text</textarea></td>
          <td><div class='button_journal change-advertisement'>✔</div><div class='button_journal remove-advertisement'>✘</div></td></tr>
          <tr> <td colspan='2'><hr></td></tr>";
}
}