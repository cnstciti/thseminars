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

class Certificate
{
    private $_list;


    public function __construct()
    {
        $this->_list = [
            '1' => 'Практик',
            '2' => 'Инструктор',
            '3' => 'Мастер',
        ];
    }

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
