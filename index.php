<?php
                ini_set('display_errors', 1); //отображать ошибки -1 не отображать - 0
                date_default_timezone_set('Europe/Moscow'); //если б. раб. с датой нужн задать ч. пояс
                $dir = 'upload/'; // Папка с изображениями
                $cols = 6; // Количество картинок в одной строке
                if (!empty($_FILES['file'])) { //если файл был отправлен
                    if ($_FILES['file']['error'] === 0) { //если файл был пришел на сервер
                        $tmp = $_FILES['file']['tmp_name'];
                        $name = $_FILES['file']['name'];
                        $path = $dir . $name;
                        if (!move_uploaded_file($tmp, $path)) { //если файл не был загружен (был отправлен но не смогл загрузиться)
                            echo '<p class="error">Не удалось загрузить файл :(</p>'; // выводим ошибку
                        }
                    } else { //иначе выводим сообщение об ошибке
                        echo '<p class="error">Вы не выбрали файл :(</p>';
                    }
                }
                $files = scandir($dir); // получаем массив содержимого папки

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Галерея изображений</title>
		<link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        <div class="wrapper">
            <h1>Галерея изображений</h1>
            <form method="POST" enctype="multipart/form-data">
                <label>Выберите изображение в формате png, jpeg или gif</label><br>
                <input type="file" name="file">
                <br><br>
                <input type= submit name="doUpload" value="Закачать новую фотографию">
            </form>
            <div class="gallery">
             <?php
                $i = 1; //счетчик будет отслеживать какая по счету картинка в строке
                echo "<table><tr>"; // Начинаем таблицу
                foreach ($files as $file) { //обходим массив содержимого папки (массив картинок)
				
                    if ($file !== '.' && $file !== '..') { //если это имя файла
                        $modified = date('d.m.Y', filemtime($dir . $file)); //получаем дату изм. файла
                        printf('<td><a href="%s" title="Просмотр полного изображения" target="_blank"><img src="%s" style="height:100px;"></a><br><div>%s</div></td>', $dir . $file, $dir . $file, $modified); //печатем ячейку, картинку и ссылку
                        if ($i % $cols == 0) { //если это последняя картинка в строке
                            echo '</tr><tr>'; //переходим на новую строку
                        }
                        $i++; //увеличиваем номер картинки на 1
                    }
                }
                echo "</tr></table>"; // Закрываем таблицу
                ?>
            </div><!--/gallery -->
        </div><!--/wrapper -->
    </body>
</html>
