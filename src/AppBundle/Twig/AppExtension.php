<?php


namespace AppBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('dateend', [$this, 'formatTimer']),
            new TwigFilter('price', [$this, 'formatPrice']),
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('finishing', [$this, 'timerFinishing']),
        ];
    }

    /**
     * Выводим оставшееся время до полуночи.
     *
     * @param string $date_end Дата окончания лота
     *
     * @return string
     */
    public function formatTimer($date_end)
    {
        $now = strtotime('now');
        $midninght = strtotime($date_end);
        $diff = $midninght - $now;
        $hours = floor($diff / 3600);
        $minutes = floor(($diff % 3600) / 60);
        $dateend = $hours . ':' . $minutes;

        return $dateend;
    }

    /**
     * Добовляет пробел после 3 нулей к цене слота.
     *
     * @param int $price Цена лота
     *
     * @return string
     */
    public function formatPrice($price)
    {
        $price = ceil((float)$price);
        $price = number_format($price, 0, '', ' ');

        return $price;
    }

    /**
     * Проверяем осталось меньше часа или нет до данного времени.
     *
     * @param string $date_end Дата окончания лота
     *
     * @return bool
     */
    public function timerFinishing($date_end)
    {
        $timeUnix = strtotime($date_end);
        $now = time();
        $diff = $timeUnix - $now;
        if ($diff <= 3600) {
            $finishing = 'timer--finishing';
        } else $finishing = '';

        return $finishing;
    }
}
