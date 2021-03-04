<?php 
//  require 'vendor/autoload.php';
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

class Clustering
{
    protected $changeYear = false;
    public $finalOutput = '';
    public $year = '';


    protected function storeKeywordsToFile($keywords)
    {
        $time = time();
        $path_in = './data/input'.$time.'.txt';
        $path_out = './data/output'.$time.'.txt';
        $file = fopen($path_in, 'w');
        fwrite($file, $keywords);
        fclose($file);
        $path = [
            'in' => $path_in,
            'out' => $path_out
        ];
        return $path;
    }

    public function goClusteriseKeys($keywords)
    {
        // dd(array_chunk(explode(PHP_EOL, $keywords), 300));
        $chunks = array_chunk(explode(PHP_EOL, $keywords), 250);
        foreach ($chunks as $chunk) {
            $file = $this->storeKeywordsToFile(implode("\n", $chunk));
            // var_dump($file);
            $locale = 'ru_RU.utf-8';
            setlocale(LC_CTYPE, $locale);
            putenv("PYTHONIOENCODING=utf-8");
            $command = escapeshellcmd('python run.py '. $file['in'] . ' ' . $file['out']);
            $output = shell_exec($command);
            usleep(1000);
            unlink($file['out']);
            unlink($file['in']);
            $this->finalOutput .= $output;
        }
        
        return str_ireplace("\n\n\n", "\n\n", $this->finalOutput);
    }

    public function changeYear($value)
    {
        $this->year = date('Y');
        $value = str_ireplace(['2015','2016','2017','2018','2019','2020'], $this->year, $value);
        return $value;
    }

    public function toArray($output)
    {
        $i = 0;
        $array = explode("\n", $output);
        foreach ($array as $key => $value) {
            if($value === "") {
                $i++; 
                continue;
            }

            $data[$i][] = $value;
        }

        return $data;
    }

    public function makeOutFinalForParsing($output, $random = false, $skip = null)
    {
        $data = $this->toArray($output);
        // dd($data);
        $final = '';
        foreach ($data as $value) {
            $count = count($value);
            if($random == true) {
                shuffle($value);
            }
            foreach($value as $v) {
                if($skip != null && $count > $skip) {
                    for ($i=0; $i < $skip; $i++) { 
                        unset($value[$i]);
                    }
                    continue;
                }

                $final .= $v."\n";
                break;
            } 
        }
        return $final;
    }

}
$year = false;
$small = false;
$data = $_POST;
// dd($data);
if(isset($_POST['is_random']) && $_POST['is_random'] == '1') {
    $random = true;
}
if(isset($_POST['makecurrentyear']) && $_POST['makecurrentyear'] == '1') {
    $year = true;
}
if(isset($_POST['makesmall']) && $_POST['makesmall'] == '1') {
    $small = true;
}
if(isset($_POST['text'])) {
    $keywords = $_POST['text'];
}
// dd($data);
$out = new Clustering();
$data = $out->goClusteriseKeys($keywords);
if($year) {
    $data = $out->changeYear($data);
}
// data - ключи, true - рандомайзер
if($small) {
    $data = $out->makeOutFinalForParsing($data, $random);
}
// dd($data);
$f = fopen('./data/results.txt', 'w');
fwrite($f,$data);
fclose($f);
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename('./data/results.txt'));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize('./data/results.txt'));
readfile('./data/results.txt');
exit;
echo "заебись";
