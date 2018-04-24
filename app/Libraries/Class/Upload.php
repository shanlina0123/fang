<?php
use Illuminate\Support\Facades\Storage;
class Upload
{
    public  $filepath = 'upload';
    public  $fileFrom = "temp/";
    public static $disk = 'upload';
    public function __construct()
    {
       $this->filepath = config('configure.uploads');
       $this->fileFrom = config('configure.temp');
    }
    /**
     * @param $uuid
     * @param $name 文件临时目录下的名字
     * @param $type 上传类型
     * @param $alias 新名称
     * @return bool
     */
    public function uploadProductImage( $id, $name, $type, $alias=null )
    {

        try{
            switch ( $type )
            {
                case "house": //房源图片
                    $filePath = base_path().'/public/'.$this->filepath.'/'.'house/'.$id;
                    break;
                default:
                    return false;
            }
            $fileFrom = base_path().'/public/'.$this->fileFrom.$name;
            if( file_exists($fileFrom) )
            {
                $res = $this->uploads( $filePath, $fileFrom, $name, $alias );
                if( $res )
                {
                    return true;
                }else
                {
                    return false;
                }
            }else
                return false;

        } catch (Exception $e)
        {
            return false;
        }

    }

    /**
     * @param $filepath
     * @param $iPid
     * @param $fileFrom
     * @param $fileName
     * @return bool
     * 私有方法
     */
    private function uploads( $filePath, $fileFrom, $name  )
    {
        if( $filePath && $fileFrom && $name )
        {

            $Directory = $filePath;
            $arrDirectory =  str_replace("\\","/",$Directory);
            $dir = $this->Directory($arrDirectory);
            if( $dir )
            {
                $file =  copy( $fileFrom,$arrDirectory.'/'.$name );
                if( $file == true )
                {
                    @unlink($fileFrom);
                    return true;
                }else
                {
                    return false;
                }
            }else
            {
                return false;
            }
        }else
        {
            return false;
        }

    }

    /**
     * @param $dir
     * @return bool
     * 递归创建文件夹
     */
    public function Directory( $dir )
    {
        return  is_dir ( $dir ) or $this->Directory(dirname( $dir )) and  mkdir ( $dir , 0777);
    }

    /**
     *  删除图片
     *
     */
    public function delImg( $path )
    {
        $path = base_path().'/public/'.$this->filepath.'/'.$path;
        if( file_exists($path) )
        {
            $images =  @unlink($path);;
            if ( $images )
            {
                return true;
            }
            return false;
        }else
            return false;
    }


    /**
     * @param $dir
     * @param $id
     * @return bool
     * 删除文件夹以及下面的文件
     */
    public function delDir( $dir, $id )
    {
        try
        {
            $dirName = base_path().'/public/'.$this->filepath . '/' . $dir . '/' . $id;
            if(! is_dir($dirName))
            {
                return false;
            }
            $handle = @opendir($dirName);
            while(($file = @readdir($handle)) !== false)
            {
                if($file != '.' && $file != '..')
                {
                    $dir = $dirName . '/' . $file;
                    is_dir($dir) ? removeDir($dir) : @unlink($dir);
                }
            }
            closedir($handle);
            return rmdir($dirName) ;

        }catch (Exception $e)
        {
            return false;
        }
    }
}
