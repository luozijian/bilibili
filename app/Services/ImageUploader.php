<?php

namespace App\Services;

use Illuminate\Http\Request;


class ImageUploader
{

    /**
     * @var Request
     */
    private $request;


    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $file
     *
     * @return $this
     */
    public function upload($index,$path,&$input)
    {
        $save_path=public_path(str_finish($path, '/'));

        if(!is_dir($save_path)){
            \File::makeDirectory($save_path, 0755, true);
        }

        $file= $this->request->file($index);
        if($file){
            $filename=md5(time()).".".$file->getClientOriginalExtension();
            $file->move($save_path,$filename);
            $input[$index]=str_finish($path, '/').$filename;
        }
    }


    /**
     * 多组多文件上传
     * 上传多个文件
     * @param $index
     * @param $path
     * @param $input
     */
    public function uploadMany($index,$path,&$input)
    {
        $save_path=public_path(str_finish($path, '/'));

        if(!is_dir($save_path)){
            \File::makeDirectory($save_path, 0755, true);
        }

        $group= $this->request->files;
        foreach($group as $key => $files){
            foreach($files as $file){
                $filename=md5(time().$file->getClientOriginalName()).".".$file->getClientOriginalExtension();
                $file->move($save_path,$filename);
                $input[$index][$key][]=asset(str_finish($path, '/').$filename);
            }
        }
    }
}
