<?php
namespace app\Helpers;

use App\Gallery;
use App\image;
use DOMDocument;
use ImageDownloader;

include_once('ImageDownloader.php');
 
class RusasDownloader extends Downloader
{
    private $dw;
    private $showLog = false;
    private $picFolder = 'fotos/';
    private $ultimo = 0;
    private $offset = 1;
    private $na_start = 0;
    private $na_step = 30;
    private $pagina = 0;

    /**
     * @param boolean $showLog
     */
    public function setShowLog($showLog)
    {
        $this->showLog = $showLog;
    }

    
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

    public function setStep($step)
    {
        $this->na_step = $step;
    }

    /**
     * @param int $pagina
     */
    public function setPagina($pagina=0)
    {
        $this->pagina = $pagina;
    }


    private function getRusasUrl()
    {
        return "http://forum.index.hu/Article/showArticle?na_start=".$this->na_start."&na_step=".$this->na_step."&t=9042625&na_order=";
    }


    public function startDownload()
    {
        $url = $this->getRusasUrl();

        $parsedUrl = parse_url($url);

        $aUrl = $parsedUrl['path'];

        $path = "";
        for ($i=0;$i<count($aUrl)-1;$i++ )
        {
            $path .= $aUrl[$i].'/';
        }

        $i = $this->offset;
        $urls = array();
        while (true){

            $html = $this->dw->get_remote_data($url);
            $aux = $this->getImagesUrls($html);

            if (count($aux)>0){
                if ($this->showLog) {
                    echo "procesando Pagina: " . $i . PHP_EOL;
                }

                $urls = array_merge($urls,$aux);
            }else{
                break;
            }

            if ($this->pagina != 0 and $this->pagina == $i){
                break;
            }

            $this->na_start = $this->na_start+$this->na_step;
            $url = $this->getRusasUrl();
            $i++;
        }

//        $titulo = $this->getTitle($this->dw->get_remote_data($url));

        $folder = $this->picFolder;

        $this->downloadImages(array_reverse($urls),$folder);


    }

    function drawProgress($total,$actual)
    {
//        $str = "[";
//        for($i=0; $i<$total; $i+=1){
//            if ($i < $actual){
//                $str .= "|";
//            }else{
//                $str .= "-";
//            }
//        }

        
        $aux1 = $actual * 100;
        $porcentaje = $aux1 / $total;
        
        $str = "[ ".$actual. " / ". $total. "] " . round($porcentaje) . " %           " . "\r";
        echo $str;
    }

    private function getImagesUrls($html)
    {
        $DOM = new DOMDocument;
        $DOM->loadHTML($html);

        $images = $this->getElementsByClass($DOM,'img','tn_img');
//        $urls = [];
//        foreach ($images as $k => $v ) {
//            if (isset($v->childNodes[2])){
//                $urls[] = $v->childNodes[2]->getAttribute('src');
//            }
//        }

        return $images;

    }

    private function downloadImages($urls,$folder)
    {

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        $i=0;
        $total = count($urls);
//        if ($this->showLog) {
//            $total = $this->getTotalSize($urls);
//        }else{
//            $total = 0;
//        }

        $actualDownload = 0;

        $gallery = Gallery::find(1);

        foreach ($urls as $k=>$url) {
            $fileData = pathinfo($url);
            $fileExtension = $fileData['extension'];
            $new_file_name = $fileData['filename'] . "." . $fileExtension;

            $gifFolder = "";
            if ($fileExtension == "gif"){
//                $gifFolder = "/gif/";
            }

            if (!file_exists($folder . "/" . $new_file_name)) {
                $temp_file_contents = $this->dw->get_remote_data($url);
                if ($temp_file_contents){
                    $this->write_to_file($temp_file_contents, $folder . '/' . $new_file_name);
                }
            }

            //$aux0 = $this->getFileHeaders($url);
//            $fileSize = ($aux0[1] != null) ? $aux0[1] : 0;

            $this->saveImageDb($gallery,$new_file_name,$url);

            if ($this->showLog){
//                $actualDownload = $actualDownload + $fileSize;
                $this->drawProgress($total,$i);
            }

            $i++;
        }
        $this->drawProgress($total,$i);
        
    }

    private function saveImageDb($gallery,  $name,$url)
    {
        
        $img = image::firstOrCreate([
            'path' => '/storage/rusas/'.$name,
            'OriginalUrl' => $url
        ]);

//        $img = new image();
//        $img->path = '/storage/rusas/'.$name;
//        $img->size = $fileSize;
//        $img->OriginalUrl = $url;
//        $img->save();
//        var_dump($img);
//        die();
        $img->galleries()->attach($gallery);
    }
    
    private function getTotalSize($urls) {
        $total = 0;
        
        $i = 0;
        $t = count($urls);
        foreach ($urls as $url) {

            $aux1 = $i * 100;
            $porcentaje = $aux1 / $t;

            $str = round($porcentaje) . " %";
            
            echo "calculando peso total: ".$str."\r";
            
            $aux = $this->getFileHeaders($url);
            $total = $total + $aux[1];
            
            $i++;
        }
        
        return $total;
    }
    
}

