<?php
class Upload
{
    //上传文件的最大限制
    private $max_size;
    //文件名称的前缀
    private $prefix = 'xuece_';
    //上传的文件路径
    private $upload_path = './Images/mryl/';
    //允许上传的文件类型
    private $allow_type = ['image/png','image/jpg','image/jpeg','image/gif'];

    public function __set($name, $value)
    {
        if(property_exists($this,$name)){
            $this -> $name = $value;
        }
    }
    public function __get($name)
    {
        if(property_exists($this,$name)){
            return $this -> $name;
        }
    }

    public function __construct()
    {
        //有些php版本中不能在定义属性时初始化一个表达式作为值
        $this -> max_size = 2*1024*1024;
    }

    //接收参数
    public function doUpload($file)
    {
        //接收表单提交过来的文件资源
        if($file['error'] == 0){
            //1. 限制上传的文件大小
            $maxsize = $this->max_size; //2MB
            //拿上传的文件的大小和我们限制的大小进行比较
            if($file['size'] > $maxsize){
                die('文件最大不能超过2MB');
            }
            //2. 防止文件重命名
            $filename = uniqid($this->prefix,false);
            //确定文件的后缀，文件名称后面最后一个点号后面的字符就是后缀，例如：bs.png 的后缀就是.png
            $suffix = strrchr($file['name'],'.');
            //通常我们会将上传的文件保存在uploads目录下
            $upload_path = $this -> upload_path;

            //3. 按照年月日格式创建子目录
            $sub_dir = date('Ymd').'/';
            if(!is_dir($upload_path.$sub_dir)){
                mkdir($upload_path.$sub_dir,0777,true);
            }
            $new_file = $upload_path. $sub_dir . $filename . $suffix;

            //4. 限制用户上传的文件类型
            if(!in_array($file['type'],$this -> allow_type)){
                die('格式错误，请选择jpg|png|gif格式的图片');
            }
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $type  = $finfo ->file($file['tmp_name']);
            if(!in_array($type,$this -> allow_type)){
                die('小样，想骗我们，再吃几年土吧');
            }

            //参数1：临时文件
            //参数2：目标文件名
            if(move_uploaded_file($file['tmp_name'],$new_file)){
                //echo '上传成功';
                //返回上传的文件地址
                return $sub_dir . $filename . $suffix;       // 20170827/itbull_sdfsadas.png
            }else{
                return false;
            }
            //var_dump($_FILES);
        }else{
            return false;
        }
    }
}
