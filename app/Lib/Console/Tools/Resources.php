<?php


namespace App\Console\Tools;


use App\AppHelper;

class Resources
{
    public function run(){
      $destination = \Yii::getAlias('@Web');
      $typeOS = php_uname('s');

      if(stripos($typeOS, "Windows") === false){

        $ico_source = \Yii::getAlias(\App\AppHelper::getProjectResourcesAlias()) . '/favicon.ico';
        if(file_exists($ico_source)){
          exec('rm -f ' . $destination . '/favicon.ico');
          exec('cp ' . $ico_source . ' ' , $destination);
        }

        $sources = [
          'images',
          'fonts',
          'files'
        ];

        foreach ($sources as $folder){
          $source = \Yii::getAlias(AppHelper::getProjectResourcesAlias()) . DIRECTORY_SEPARATOR . $folder;
          if(is_dir($source)){
            exec('cd ' . $destination . DIRECTORY_SEPARATOR . $folder . ' && ls | grep -v \'.gitignore\' | xargs rm -rf');
            exec('cp -R ' . $source . ' ' . $destination);
            exec('cd ..');
          }
        }
      } else {

        $ico_source = \Yii::getAlias(AppHelper::getProjectResourcesAlias()) . '/favicon.ico';
        if(file_exists($ico_source)){
          exec('DEL ' . $destination . '/favicon.ico');
          exec('COPY ' . $ico_source . ' ' , $destination);
        }

        $sources = [
          'images',
          'fonts',
          'files'
        ];

        foreach ($sources as $folder){
          $source = \Yii::getAlias(AppHelper::getProjectResourcesAlias()) . DIRECTORY_SEPARATOR . $folder;
          if(is_dir($source)){
            exec('cd ' . $destination . DIRECTORY_SEPARATOR . $folder);
            exec('COPY ' . $source . ' ' . $destination);
            exec('cd ..');
            var_dump($source, $destination);
          }
        }
      }

    } // actionRun
}