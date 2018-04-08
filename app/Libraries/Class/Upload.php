<?php
use Illuminate\Support\Facades\Storage;
class Upload
{
    public  $filepath = 'uploads';
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
                    $filePath  = $this->filepath.'/'.'house/'.$id;
                    break;
                default:
                    return false;
            }
            $fileFrom = public_path().$this->fileFrom.$name;
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
    private function uploads( $filePath, $fileFrom, $name, $alias  )
    {
        $newName = $alias?$alias:$name;
        if( $filePath && $fileFrom && $name )
        {
            $Directory = $filePath;
            $obj = Storage::disk(self::$disk)->makeDirectory( $Directory );
            if( $obj === true )
            {
                $upload = Storage::disk(self::$disk)->put($Directory.'/'.$newName,file_get_contents($fileFrom));
                if( $upload === true && file_exists($fileFrom) == true )
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
     *  删除图片
     *
     */
    public function delImg( $path )
    {
        $path = $this->filepath.'/'.$path;
        if( Storage::disk(self::$disk)->exists($path) )
        {
            $images = Storage::disk(self::$disk)->delete( $path );
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
            if( $dir && $id )
            {
                $Path = $this->filepath . '/' . $dir . '/' . $id;
                $res = Storage::disk(self::$disk)->deleteDirectory($Path);
                if ( $res )
                {
                    return true;
                }
                return false;
            }else
                return false;

        }catch (Exception $e)
        {
            return false;
        }
    }
}
