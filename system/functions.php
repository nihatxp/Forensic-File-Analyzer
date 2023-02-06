<?php

function get_exif_data($image)
{
    $html = "";
    $html .= "File Name : " . $image['FileName'] . "<br>";
    $html .= "File DateTime : " . $image['FileDateTime'] . "<br>";
    $html .= "File Size : " . $image['FileSize'] . "<br>";
    $html .= "File Type : " . $image['FileType'] . "<br>";
    $html .= "Mime Type : " . $image['MimeType'] . "<br>";
    $html .= "Sections Found : " . $image['SectionsFound'] . "<br>";
    $html .= "Computed Html : " . $image['COMPUTED']['html'] . "<br>";
    $html .= "Computed Height : " . $image['COMPUTED']['Height'] . "<br>";
    $html .= "Computed Width : " . $image['COMPUTED']['Width'] . "<br>";
    $html .= "Computed Is Color : " . $image['COMPUTED']['IsColor'] . "<br>";
    $html .= "Computed Byte Order Motorola : " . $image['COMPUTED']['ByteOrderMotorola'] . "<br>";
    $html .= "Image Width : " . $image['ImageWidth'] . "<br>";
    $html .= "Model : " . $image['Model'] . "<br>";
    $html .= "Image Length : " . $image['ImageLength'] . "<br>";
    $html .= "Make : " . $image['Make'] . "<br>";
    $html .= "Exif IFD Pointer : " . $image['Exif_IFD_Pointer'] . "<br>";
    $html .= "Orientation : " . $image['Orientation'] . "<br>";
    $html .= "Date Time : " . $image['DateTime'] . "<br>";
    $html .= "Light Source : " . $image['LightSource'] . "<br>";
    return $html;
}


function ConvertToUTF8($text)
{
    $encoding = mb_detect_encoding($text, mb_detect_order(), false);
    if ($encoding == "UTF-8") {
        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
    }
    $out = iconv(mb_detect_encoding($text, mb_detect_order(), false), "UTF-8//IGNORE", $text);
    return $out;
}

function strToBin($number)
{
    $result = '';
    for ($i = 0; $i < strlen($number); $i++) {
        $conv = base_convert($number[$i], 16, 2);
        $result .= str_pad($conv, 4, '0', STR_PAD_LEFT);
        $result .= ' ';
    }
    return $result;
}

function yapilandir($char)
{
    return "<i>" . strtoupper(implode(unpack("H*", $char))) . " </i>";
}

function getImgType($filename)
{
    $handle = @fopen($filename, 'r');
    if (!$handle)
        throw new Exception('File Open Error');

    $types = array('jpeg' => "\xFF\xD8\xFF", 'gif' => 'GIF', 'png' => "\x89\x50\x4e\x47\x0d\x0a", 'bmp' => 'BM', 'psd' => '8BPS', 'swf' => 'FWS');
    $bytes = fgets($handle, 8);
    $found = 'other';

    foreach ($types as $type => $header) {
        if (strpos($bytes, $header) === 0) {
            $found = $type;
            break;
        }
    }
    fclose($handle);
    return $found;
}