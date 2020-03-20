<?php
/**
 * Этот файл отвечает за
 *
 */

namespace frontend\models\instructor;

use Yii;

/**
 * Класс
 *
 * @author Constantin Ogloblin <cnst@mail.ru>
 * @since 1.0.0
 */

class Language
{
    private $_list;


    public function __construct()
    {
        $this->_list = [
            '1' => 'Русский',
            '2' => 'Английский',
            '3' => 'Другой',
        ];
    }
    /*
        азербайджанский
        английский
        арабский
        армянский
        белорусский
        болгарский
        венгерский
        вьетнамский
        греческий
        грузинский
        датский
        зулу
        иврит
        индонезийский
        ирландский
        исландский
        испанский
        итальянский
        казахский
        киргизский
        китайский
        корейский
        латышский
        литовский
        немецкий
        норвежский
        польский
        португальский
        румынский
        русский
        таджикский
        тайский
        турецкий
        узбекский
        украинский
        финский
        французский
        чешский
        шведский
        эстонский
        японский
*/
    /**
     *
     *
     * @return
     */
    public function all()
    {
        return $this->_list;
    }

    /**
     *
     *
     * @return
     */
    public function selected($data)
    {
        $ret = [];
        if (!empty($data)) {
            foreach ($this->_list as $key => $item) {
                if (in_array($key, $data)) {
                    $ret[] = $item;
                }
            }
        }
        return $ret;
    }

}
