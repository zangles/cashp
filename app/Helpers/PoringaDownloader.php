<?php
namespace app\Helpers;

use DOMDocument;
use ImageDownloader;

include_once('ImageDownloader.php');

class PoringaDownloader extends Downloader
{
    private $dw;
    private $showLog = true;
    private $picFolder = 'fotos/';
    private $ultimo = 0;
    private $offset = 1;
    private $na_start = 10;
    private $pages = 30;
    private $pagina = 0;

    function __construct($user = '', $pass = '')
    {
        set_time_limit (0);
        error_reporting(E_ERROR | E_PARSE);
        $this->dw = new ImageDownloader($user,$pass);
    }

    /**
     * @param string $picFolder
     */
    public function setPicFolder($picFolder)
    {
        $this->picFolder = $picFolder;
    }

    /**
     * @param int $offset
     */
    public function setOffset($offset=0)
    {
        $this->offset = $offset;
    }

    public function setStart($start)
    {
        $this->na_start = $start;
    }

    public function setPages($pages)
    {
        $this->pages = $pages;
    }

    /**
     * @param int $pagina
     */
    public function setPagina($pagina=0)
    {
        $this->pagina = $pagina;
    }


    private function getPoringaUrl()
    {
        return "http://theworstdrug.com/poringa/".$this->na_start;
    }

    public function startDownload()
    {
        $url = $this->getPoringaUrl();

        $parsedUrl = parse_url($url);

        $aUrl = $parsedUrl['path'];

        $path = "";
        for ($i=0;$i<count($aUrl)-1;$i++ )
        {
            $path .= $aUrl[$i].'/';
        }

        $urlWithOutOffset = $parsedUrl['scheme']."://".$parsedUrl['host'].$path;
        
        $i = 0;
        $urls = array();
        while (true){
            
            $html = $this->dw->get_remote_data($url);
            dd($html);

//            $fichero = 'test.html';
//            $actual = file_get_contents($fichero);
//            file_put_contents($fichero, $html);

            $aux = $this->getImagesUrls($html);

            if (count($aux)>0){
                echo "procesando Pagina: ".$i.PHP_EOL;
                $urls = array_merge($urls,$aux);
            }
            
            if ($this->pages == $i){
                break;
            }
            
            $this->na_start++;
            
            $url = $this->getPoringaUrl();
            $i++;
        }

//        $titulo = $this->getTitle($this->dw->get_remote_data($url));
        $folder = $this->picFolder;
        $this->downloadImages($urls,$folder);
    }

    function drawProgress($total,$actual)
    {
        
        $aux1 = $actual * 100;
        $porcentaje = $aux1 / $total;
        
        $str = "[ ".$actual. " / ". $total. "] " . round($porcentaje) . " %           " . "\r";
        echo $str;
    }

    private function getImagesUrls($html)
    {
        $DOM = new DOMDocument;
        $DOM->loadHTML($html);

        $urls = [];
        
        if (strpos($html,"id='error'") === false) {
            //        $images = $this->getElementsByClass($DOM,'section','show-ads');
            $aux = explode("script>", $html);
            foreach ($aux as $a) {
                if (strpos($a, '._q') > 0) {
                    $html1 = $a;
                }
            }
            $html2 = explode(" = ", $html1);
            $html3 = str_replace("window._externalClick", "", $html2[1]);
            $html4 = substr($html3, 0, -4);

            $oJson = json_decode($html4);

            foreach ($oJson as $item) {
                $urls[] = $item->source_url;
            }
        }

        return $urls;

    }

    function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    private function downloadImages($urls,$folder)
    {

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        $i=0;
        $total = count($urls);
//        $total = $this->getTotalSize($urls);
        $actualDownload = 0;
        foreach ($urls as $k=>$url) {
            $fileData = pathinfo($url);
            $fileExtension = $fileData['extension'];
            $new_file_name = $fileData['filename'] . "." . $fileExtension;

            $gifFolder = "";

            
            if (!file_exists($folder . "/" . $gifFolder . $new_file_name)) {
                $temp_file_contents = $this->dw->get_remote_data($url);
                if ($temp_file_contents){
                    $this->write_to_file($temp_file_contents, $folder . '/' . $gifFolder . $new_file_name);
                }
            }
            
            $actualDownload++;
            
            $this->drawProgress($total,$actualDownload);

            $i++;
        }
    }
    
    
}

