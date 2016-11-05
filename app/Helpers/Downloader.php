<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 04/11/2016
 * Time: 12:53
 */

namespace app\Helpers;


class Downloader
{
    protected function getFileHeaders($url) {
        $img = get_headers($url, 1);
        return $img["Content-Length"];
    }

    protected function getElementsByClass(&$parentNode, $tagName, $className) {
        $nodes=array();

        $childNodeList = $parentNode->getElementsByTagName($tagName);
        for ($i = 0; $i < $childNodeList->length; $i++) {
            $temp = $childNodeList->item($i);

            if (stripos($temp->getAttribute('class'), $className) !== false) {
                $aux = $temp->getAttribute('onclick');
                $aux = explode("'",$aux);

                $nodes[]=$aux[1];
            }
        }

        return $nodes;
    }

    protected function getElementsByTag(&$parentNode, $tagName) {
        $childNodeList = $parentNode->getElementsByTagName($tagName);

        return $childNodeList;
    }

    protected function write_to_file($text,$new_filename){
        $fp = fopen($new_filename, 'w');
        fwrite($fp, $text);
        fclose($fp);
    }

    protected function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow)); 

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}