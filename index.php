<?php require_once 'system/config.php'; ?>
<?php require_once 'inc/header.php'; ?>
<?php require_once 'inc/form.php'; ?>
<div id=grid>
    <?php
    require_once 'system/functions.php';
    if (isset($_POST['submitFile']) && isset($_POST['limit'])) {
        if ($_POST['limit'] != 0 && is_numeric($_POST['limit'])) {
            $file = $_FILES['file'];
            $fileSize = $file['size'];
            if ($fileSize != 0) {
                $fileName = $file['name'];
                $fileError = $file['error'];
                $fileType = $file['type'];
                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));
                $limit_satir = trim(htmlspecialchars($_POST['limit'])) * 16;

                
                echo "<center><h2>";
                $fileName = explode(".", $fileName);
               
                if (strlen($fileName[0]) > 40)
                    $fileName = substr($fileName[0], 0, 20) . "[...]." . $fileName[1];
                else
                    $fileName = $fileName[0].".".$fileName[1];
                echo $fileName;
                echo "</h2></center>";

                if ($fileError === 0) {
                    if ($fileSize < 134217728) {
                        $fname = uniqid('', true) . "." . str_replace(" ", "-", $fileName) . "." . $fileActualExt;
                        $fileDestination = 'img/uploads/' . $fname;
                        move_uploaded_file($_FILES['file']['tmp_name'], $fileDestination);
                        if (file_exists($fileDestination)) {
                            $file = file_get_contents($fileDestination);
                            $limited_icerik = substr($file, 0, $limit_satir);
                            $limited_utf8_icerik = substr(utf8_encode($file), 0, $limit_satir);

                            $hex = bin2hex($limited_icerik);
                            $yapi_hex = chunk_split($hex, 2, ' ');
                            $b64 = base64_encode($file);

                            preg_match_all('/[a-zA-Z0-9\s=><.\'#,{}\]\[!*$():;%&]/', $limited_icerik, $matches);
                            $letters = implode('', $matches[0]);

                            preg_match_all('/[a-zA-Z0-9\s=><.\'#,{}\]\[!*$():;%&]/', $limited_utf8_icerik, $matches);
                            $letters_utf8 = implode('', $matches[0]);


                            echo "<table border='1' style='width:100%'>";

                            echo "<tr>";
                            echo "<th>Sha1</th>";
                            echo "<th>Sha256</th>";
                            echo "<th>Sha512</th>";
                            echo "<th>MD5</th>";
                            echo "</tr>";

                            echo "<tr>";
                            echo "<td>" . "<input class='input' type='text' value='" . sha1($file) . "' readonly>" . "</td>";
                            echo "<td>" . "<input class='input' type='text' value='" . hash('sha256', $file) . "' readonly>" . "</td>";
                            echo "<td>" . "<input class='input' type='text' value='" . hash('sha512', $file) . "' readonly>" . "</td>";
                            echo "<td>" . "<input class='input' type='text' value='" . md5($file) . "' readonly>" . "</td>";
                            echo "</tr>";

                            echo "</table>";


                            echo "<table border='1' style='width:100%'>";

                            echo "<tr>";
                            echo "<th>İçerik</th>";
                            echo "<th><abbr title='Bu içerik daha iyi okunurluk için utf-8 encode edildi. Gerçek dosya ile hash değerleri farklıdır.'>İçerik UTF-8 Converted</abbr></th>";
                            echo "<th>Hex</th>";
                            echo "</tr>";

                            echo "<tr>";
                            echo "<td>" . "<textarea class='textarea' readonly >" . $limited_icerik . "</textarea>" . "</td>";
                            echo "<td>" . "<textarea class='textarea' readonly >" . $limited_utf8_icerik . "</textarea>" . "</td>";
                            echo "<td>" . "<textarea class='textarea' readonly >" . $hex . "</textarea>" . "</td>";
                            echo "</tr>";

                            echo "</table>";


                            echo "<table border='1' style='width:100%'>";

                            echo "<tr>";
                            echo "<th>Strings</th>";
                            echo "<th>Strings (UTF-8)</th>";
                            echo "<th>Base64</th>";
                            echo "</tr>";

                            echo "<tr>";
                            echo "<td>" . "<textarea class='textarea' readonly >" . $letters . "</textarea>" . "</td>";
                            echo "<td>" . "<textarea class='textarea' readonly >" . $letters_utf8 . "</textarea>" . "</td>";
                            echo "<td>" . "<textarea class='textarea' readonly >" . $b64 . "</textarea>" . "</td>";
                            echo "</tr>";

                            echo "</table>";


                            echo "<table border='1' style='width:100%'>";

                            echo "<tr>";
                            echo "<th>Binary</th>";
                            echo "<th>Hex</th>";
                            echo "</tr>";

                            echo "<tr>";
                            echo "<td>" . "<textarea class='textarea' readonly >" . str_replace(" ", "", strToBin(substr($hex, 0, $limit_satir))) . "</textarea>" . "</td>";
                            echo "<td>" . "<textarea class='textarea' readonly >" . $yapi_hex . "</textarea>" . "</td>";
                            echo "</tr>";

                            echo "</table>";


                            echo "<br />";
                            echo "<center><h2>Exif Bilgileri</h2></center>";


                            if (file_exists($fileDestination)) {
                                $full_path = realpath($fileDestination);
                                $exif = @exif_read_data($full_path);
                                if ($exif === false) {
                                    echo "Exif Bilgileri Bulunamadi<br />\n";
                                } else {
                                    echo "<ul>";
                                    foreach ($exif as $key => $section) {
                                        if (is_array($section)) {
                                            echo "<ul>";
                                            foreach ($section as $name => $val) {
                                                echo "<li>$key.$name: $val</li>\n";
                                            }
                                            echo "</ul>";
                                        } else {
                                            echo "<li>$key: $section</li>\n";
                                        }
                                    }
                                    echo "</ul>";
                                }
                            }


                            echo "<center><h3>Dosya Kırpılmış mı?</h3></center>";
                            if (isset($exif['ResolutionUnit']) && $exif['ResolutionUnit'] == 2) {
                                // Check if the image dimensions have been changed from the original
                                if ($exif['ImageWidth'] != $exif['ExifImageWidth'] || $exif['ImageHeight'] != $exif['ExifImageHeight']) {
                                    echo "Resim kırpılmış.\n";
                                } else {
                                    echo "Resim kırpılmamış.\n";
                                }
                            } else {
                                echo "[Hata] Maalesef Dosyanın Bu Bilgisine Erişemedik.\n";
                            }
                            echo "<center><h3>Dosya Döndürülmüş mü?</h3></center>";
                            if (isset($exif['Orientation'])) {
                                switch ($exif['Orientation']) {
                                    case 1:
                                        echo "Resim döndürülmüş değil.\n";
                                        break;
                                    case 2:
                                        echo "Resim yatay olarak aynalanmış.\n";
                                        break;
                                    case 3:
                                        echo "Resim 180 derece döndürülmüş.\n";
                                        break;
                                    case 4:
                                        echo "Resim dikey olarak aynalanmış.\n";
                                        break;
                                    case 5:
                                        echo "Resim 90 derece sola döndürülmüş ve dikey olarak aynalanmış.\n";
                                        break;
                                    case 6:
                                        echo "Resim 90 derece sağa döndürülmüş.\n";
                                        break;
                                    case 7:
                                        echo "Resim 90 derece sağa döndürülmüş ve dikey olarak aynalanmış.\n";
                                        break;
                                    case 8:
                                        echo "Resim 90 derece sola döndürülmüş.\n";
                                        break;
                                    default:
                                        echo "[Hata] Maalesef Dosyanın Bu Bilgisine Erişemedik.\n";
                                        break;
                                }
                            } else {
                                echo "[Hata] Maalesef Dosyanın Bu Bilgisine Erişemedik.\n";
                            }

                            echo "<center><h3>Dosya Hash Değeri</h3></center>";
                            echo "<ul>";
                            echo "<li>MD5: " . md5_file($fileDestination) . "</li>";
                            echo "<li>SHA1: " . sha1_file($fileDestination) . "</li>";
                            echo "<li>SHA256: " . hash_file('sha256', $fileDestination) . "</li>";
                            echo "</ul>";
                        }
                    } else {
                        echo "<center>Dosya boyutu çok büyük</center>";
                    }
                } else {
                    echo "<center>Dosya yüklenirken bir hata oluştu</center>";
                }
            } else {
                echo "<center>Dosya seçilmedi</center>";
            }
        } else {
            echo "<center>Limit değeri 0'dan büyük olmalı</center>";
        }
        if (AUTO_DELETE) {
            $fileDestination = __DIR__ . DIRECTORY_SEPARATOR . $fileDestination;
            unlink($fileDestination);
        }
    }
    ?>
</div>
<?php require_once 'inc/footer.php'; ?>