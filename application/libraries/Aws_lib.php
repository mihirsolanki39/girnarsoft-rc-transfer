<?php

/**
 * Description of AWS s3 <Simple Storage Service>
 *
 * @author Raj Kumar
 */
//echo APPPATH . '/third_party/aws/aws-autoloader.php'; die;
require APPPATH . 'third_party/aws/aws-autoloader.php';
class Aws_lib
{

    private $s3;
    private $config;

    public function __construct()
    {
        $this->s3 = self::connectS3Client();
    }

    private static function connectS3Client()
    {
        //$config = self::$config;

        $s3 = new Aws\S3\S3Client([
            'region'      => 'ap-south-1',
            'version'     => 'latest',
            'credentials' => [
                'key'    => 'AKIAUIHAPPNSOFV23UP4',
                'secret' => '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'
            ]
        ]);
        return $s3;
    }

   /**
    * 
    * @param type $sourceFile
    * @param type $destinationFile
    * @return type $result
    */
    public  function Upload($sourceFile, $destinationFile, $ext = '')
    {
        
        //$config = self::$config;
       //echo $ext; die;
        if(trim($ext) != ''){
            if($ext=='pdf' || $ext=='PDF'){
            $content_type = 'application/'.$ext; 
            }else{
            $content_type = 'image/'.$ext;
            }
        }
        
        try
        {
            $result = $this->s3->putObject(array(
                'Bucket'       => 'cdn.cdrive.online',
                'SourceFile'   => $sourceFile,
                'Key'          => $destinationFile,
                'ContentType'  => $content_type,
                'ContentLength' => filesize($sourceFile),
                'ACL'          => 'public-read',
                'StorageClass' => 'REDUCED_REDUNDANCY'
            ));
            return $result;
        }
        catch (Aws\S3\Exception\S3Exception $e)
        {
            return $e->getMessage();
        }
    }
    /**
     * 
     * @param type $destinationFile
     * @return type $result
     */
    public  function Delete($destinationFile)
    {
        //$config = self::$config;
        try
        {
            $result = $this->s3->deleteObject(array(
                'Bucket'       => 'cdn.cdrive.online',
                'Key'          => $destinationFile,
            ));
            return $result;
        }
        catch (Aws\S3\Exception\S3Exception $e)
        {
            return ($e->getMessage());
        }
    }
    public function getUploadedUrl($destinationFile)
    {
        return 'http://cdn.cdrive.online.s3-website.ap-south-1.amazonaws.com/'. $destinationFile;
    }

}
/*
|$aws = new AWS();
|$aws->Upload('/var/www/girnarsoft-gaadi-dealers/656maincar.jpg', '20180502/images/'.time().'.jpg');
*/
