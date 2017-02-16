<?php 
namespace frontend\controllers;
use yii\base\Controller;

class UploadController extends Controller
{
	private $error_msg  = null;  //错误信息
	private $file_data  = null;	//文件信息
	private $file_type =  array('mp3','lrc','jpg','jpeg','png');	//文件格式
	private $max_size   =  20971520;	//文件大小
	public function __construct()
	{
	}
	/**
	 * 上传文件
	 * @param  [type] $filename [文本域值]
	 * @param  [type] $path     [上传路径]
	 * @return [type] bool      true or false
	 */
	public function upload($filename,$path='./Uploads')
	{
		if(!is_dir($path))
		{
			mkdir($path);
		}
		$fileData = $_FILES[$filename];
		//大小不能超过5m
		if($fileData['size'] > $this->max_size)
		{
			$this->error_msg = '超过文件大小限制';
			return false;
		}
		//类型视频
		$type = substr($fileData['name'], strrpos($fileData['name'],'.')+1);
		if(!in_array(strtolower($type), $this->file_type))
		{
			$this->error_msg = '文件格式不正确';
			return false;
		}
		$filename = time().'.'.$type;
		if(move_uploaded_file($fileData['tmp_name'],$path.'/'.$filename))
		{
			$this->file_data = array(
				'file_name' => $filename,
				'file_path' => $path,
				'file_type' => $type,
			);
			return true;
		}
		else
		{
			return false;
		}
	}
	//配置文件格式
	public function editor_type($type)
	{
		$this->file_type = $type;
	}
	//配置文件大小
	public function editor_size($size)
	{
		$this->max_size = $size * 1024 * 1024;
	}
	//获取错误信息
	public function get_error()
	{
		return $this->error_msg;
	}
	//成功后获取文件信息
	public function get_data()
	{
		return $this->file_data;
	}
}



 ?>