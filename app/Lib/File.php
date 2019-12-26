<?php

namespace App;

use App\Helpers\UrlHelper;
use yii\base\BaseObject;
use yii\base\Exception;
use yii\web\UploadedFile;

/**
 * Класс по работе с публичными и приватными файлами
 */
class File extends BaseObject
{
    const PREFIX_CROP   = '_crop';
    const PREFIX_RESIZE = '_resize';

    const DEFAULT_EXT = 'png';

    const SUBDOMAIN_COUNT = 6;


    /**
     * Домен с файлами, задаётся в конфиге
     * @var string
     */
    protected $domainPublic;

    /**
     * Флаг, находимся мы в продакшене или нет
     * @var boolean
     */
    protected $inProduction;

    /**
     * @param string $domainPublic
     */
    public function setDomainPublic($domainPublic)
    {
        $this->domainPublic = $domainPublic;
    }

    /**
     * @param boolean $inProduction
     */
    public function setInProduction($inProduction)
    {
        $this->inProduction = $inProduction;
    }

    /**
     * @return string
     */
    public function getDomainPublic()
    {
        return $this->domainPublic;
    }

    /**
     * @return boolean
     */
    public function inProduction()
    {
        return $this->inProduction;
    }

    /**
     * для статики
     * @return string
     */
    protected function getStaticDomainTemplate()
    {
        return App::i()->getConfig()->getStaticDomainTemplate();
    }

    /**
     * Сохраняет измененный файл
     *
     * @param string $filename_ext
     * @param int    $width
     * @param int    $height
     *
     * @return array
     */
    public function resizePublic($filename_ext, $width, $height)
    {
        self::resizeFile($filename_ext, (int)$width, (int)$height);
        $name = $this->getNameByNameFile($filename_ext);
        return [$name . self::PREFIX_RESIZE, self::DEFAULT_EXT];
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    protected function deleteFile($path)
    {
        if (file_exists($path)) {
            return unlink($path);
        }
        return true;
    }

    /**
     * Вычисляет имя поддомена по имени файла
     *
     * @param string $filename -- имя файла
     *
     * @return string
     */
    public function getSubdomain($filename)
    {
        $index = ord($filename) % self::SUBDOMAIN_COUNT + 1;
        return str_replace('%i', $index, $this->getStaticDomainTemplate());
    }

    /**
     * Multi Domain Url -- отдает статический контент с разных поддоменов.
     * Для использования во вьюхах:
     * @example File::imgUrl('/bs3style/icons/actions.ico') --> 'http://st2.hotfix.7img.ru/bs3style/icons/actions.ico'
     *
     * @param string $filename --  имя файла (можно с путем)
     *
     * @return string
     */
    public function mdUrl($filename)
    {
        if (!$this->inProduction) {
            return App::i()->getConfig()->getFaceDomain() . $filename;
        }
        $only_name = basename($filename);
        return $this->getSubdomain($only_name) . $filename;
    }

    /**
     * Генерация уникального имени
     *
     * @param mixed $file
     *
     * @return string
     */
    protected function generateMd5($file)
    {
        return md5(microtime() . $file);
    }

    /**
     * Возвращает название по
     *
     * @param $filename_ext
     *
     * @return string
     */
    public function getNameByNameFile($filename_ext)
    {
        return pathinfo($filename_ext, PATHINFO_FILENAME);
    }

    /**
     * Получает расширение файла
     *
     * @param UploadedFile|string $file
     *
     * @return string
     */
    public function getExtension($file)
    {
        $ext = mb_strtolower(pathinfo($file, PATHINFO_EXTENSION), 'UTF-8');
        return $ext != 'jpeg' ? $ext : 'jpg';
    }

    /**
     * Формирует путь к файлам с картинками моделей
     *
     * @return string
     */
    public function getModelPath($file)
    {
        $web = \Yii::getAlias('@Web');
        return "{$web}/images/models/$file";
    }
}
