<?php

namespace App\Helpers;

class Paginator
{

    /**
     * Текущая страница
     * @var int
     */
    protected $page_current;

    /**
     * Элементов на страницу
     * @var int
     */
    protected $per_page;

    /**
     * Всего результатов поиска без учета пагинации
     * @var int
     */
    protected $total_count;

    /**
     * Всего страниц
     * @var int
     */
    protected $pages_count;

    /**
     * Количество элементов страниц, которые нужны на странице
     * @var int
     */
    protected $page_range;

    /**
     * @param int $current_page
     * @param int $per_page
     * @param int $total_count
     * @param int $page_range
     */
    public function __construct($current_page, $per_page, $total_count, $page_range = 7)
    {
        $this->page_current = $current_page;
        $this->per_page     = $per_page;
        $this->total_count  = $total_count;
        $this->page_range   = $page_range;

        $this->pages_count = intval(ceil($this->total_count / $this->per_page));
        if ($this->pages_count == 0) {
            $this->pages_count = 1;
        }
    }

    /**
     * Возвращает следующую страницу
     * @return int
     */
    public function getNextPage()
    {
        if ($this->isEnabledNext()) {
            return $this->page_current + 1;
        }
        return $this->page_current;
    }

    /**
     * Возвращает предыдущую страницу
     * @return int
     */
    public function getPrevPage()
    {
        if ($this->isEnabledPrev()) {
            return $this->page_current - 1;
        }
        return $this->page_current;
    }

    /**
     * @return bool
     */
    public function isEnabledPrev()
    {
        return $this->page_current != 1;
    }

    /**
     * @return bool
     */
    public function isEnabledNext()
    {
        return $this->page_current != $this->pages_count;
    }

    /**
     * @param int $page
     * @return bool
     */
    public function isActive($page)
    {
        return $this->page_current == $page;
    }

    /**
     * Выводит массив нумерации пагинатора
     * @return array
     */
    public function getPages()
    {
        $pages              = [1];
        $current_page_range = floor($this->page_range / 2);
        $range              = floor($current_page_range / 2);
        for ($i = 2; $i < $this->pages_count; $i++) {
            //если кол-во всех страниц меньше или равен кол-ву выводимых страниц в пагинаторе, то выводим все страницы
            if ($this->pages_count <= $this->page_range + 2) {
                $pages[] = $i;
                continue;
            }
            if ($this->page_current + $current_page_range > $this->pages_count) {
                $pages[] = null;
                for ($k = $current_page_range + 1; $k > 0; $k--) {
                    $pages[] = $this->pages_count - $k;
                }
                break;
            }
            if ($i <= $current_page_range && $this->page_current <= $current_page_range) {
                for ($k = 0; $k <= $current_page_range; $k++) {
                    $pages[] = $i + $k;
                }
                $pages[] = null;
                break;
            }
            $pages[] = null;
            for ($k = -$range; $k <= $range; $k++) {
                if ($k == 0) {
                    $pages[] = $this->page_current;
                    continue;
                }
                $pages[] = $this->page_current + $k;
            }

            $pages[] = null;
            break;

        }
        if ($this->pages_count > 1) {
            $pages[] = $this->pages_count;
        }
        return $pages;
    }
}