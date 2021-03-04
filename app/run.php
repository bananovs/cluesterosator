<?php 
// require 'vendor/autoload.php';

class Clustering
{
    protected $changeYear = false;


    public function __construct($changeYear)
    {
        $this->changeYear = $changeYear;
        $this->year = date('Y');
    }

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
        $file = $this->storeKeywordsToFile($keywords);
        $locale = 'ru_RU.utf-8';
        setlocale(LC_CTYPE, $locale);
        putenv("PYTHONIOENCODING=utf-8");
        $command = escapeshellcmd('python run.py '. $file['in'] . ' ' . $file['out']);
        $output = shell_exec($command);
        // unlink($file['out']);
        unlink($file['in']);
        return $output;
    }

    public function makeWordsArray($output)
    {
        $i = 0;
        $array = explode("\n", $output);
        foreach ($array as $key => $value) {
            if($value === "") {
                $i++; 
                continue;
            }
            if($this->changeYear == true){
                $value = str_ireplace(['2015','2016','2017','2018','2019','2020'], $this->year, $value);
            }
            $data[$i][] = $value;
        }

        return $data;
    }

    public function makeOutFinalForParsing($output, $random = false, $skip = null)
    {
        $data = $this->makeWordsArray($output);
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
$out = new Clustering($year);
$data = $out->goClusteriseKeys($keywords);
// dd($data);
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
