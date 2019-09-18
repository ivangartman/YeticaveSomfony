<?php


namespace AppBundle\Service;


class AppFunctioins
{
    /**
     * Определение максимальной ставки лота.
     *
     * @param mysqli $link Ресурс соединения
     * @param int    $page id лота
     *
     * @return int
     */
    public function minrate($link, $page)
    {
        $price_max = '';
        foreach (db_price_max($link, $page) as $price) {
            if (isset($price['price'])) {
                $price_max = $price['price'];
            }
        }
        foreach (db_price($link, $page) as $price_lots) {
            $price_lot = $price_lots['price'];
            $step_rate = $price_lots['step_rate'];
        }
        if ($price_lot > $price_max) {
            $price_max = $price_lot;
        }
        $min_rate = $price_max + floor(($price_max / 100) * $step_rate);

        return $min_rate;
    }
}