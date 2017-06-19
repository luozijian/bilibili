<?php
namespace App\Services;

use Excel;

class ExcelService{


    public function export($filename,$data,$head,$width="")
    {
        return Excel::create($filename, function($excel) use($data,$head,$width){

            $excel->sheet('Sheet1', function($sheet) use($data,$head,$width){

                $sheet->fromArray($data, null, 'A1', false, false);

                $sheet->prependRow($head);

                if($width){
                    $sheet->setWidth($width);
                }
            });
        })->export('xlsx');
    }


    /**
     * @param $file string
     *
     * @return array
     */
    public function import($file)
    {
        $result=Excel::load($file)->all();
        $data=[];
        foreach($result as $row){
            $data[]=$row->toArray();
        }

        return $data;
    }


    /**
     * 存储
     *
     * @param $file  \Illuminate\Http\UploadedFile
     * @param $title
     */
    public function save($file,$title)
    {
        $path=$file->store('excels');
    }


    public function exportByView($name,$view,$key,$data)
    {
        return Excel::create($name, function($excel)use($view,$key,$data) {
            $excel->sheet('sheet1', function($sheet)use($view,$key,$data) {
                $sheet->loadView($view)->with($key,$data);
            })->download('xlsx');
        });
    }
}