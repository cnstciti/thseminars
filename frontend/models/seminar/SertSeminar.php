<?php
/**
 * Этот файл отвечает за
 *
 */

namespace frontend\models\seminar;

use Yii;

/**
 * Класс
 *
 * @author Constantin Ogloblin <cnst@mail.ru>
 * @since 1.0.0
 */

class SertSeminar
{
    private $_list;


    public function __construct()
    {
        $this->_list[] = [1 => 'Базовый курс (Basic DNA)'];
        $this->_list[] = [2 => 'Продвинутый курс (Advanced DNA)'];
        $this->_list[] = [3 => 'Глубинные раскопки (Dig Deeper)'];
        $this->_list[] = [4 => 'Животные (Animal Seminar)'];
        $this->_list[] = [5 => 'Болезни и расстройства (Disease and Disorder)'];
        $this->_list[] = [6 => 'Продвинутый курс. Часть 2 (DNA 3)'];
        $this->_list[] = [7 => 'Вы и Ваша Замечательный Партнер (Growing Your Relationships I: You and Your Significant Other)'];
        $this->_list[] = [8 => 'Вы и Творец (Growing Your Relationships 2: You and God)'];
        $this->_list[] = [9 => 'Вы и Ваш Внутренний Круг (You and Your Inner Circle)'];
        $this->_list[] = [10 => 'Вы и Земля (You and the Earth)'];
        $this->_list[] = [11 => 'Интуитивная анатомия (Intuitive Anatomy)'];
        $this->_list[] = [12 => 'Манифестация и Изобилие (Manifesting and Abundance)'];
        $this->_list[] = [13 => 'Планы бытия (Planes of Existence)'];
        $this->_list[] = [14 => 'Дети Радуги (Rainbow Children)'];
        $this->_list[] = [15 => 'Растения (Plant Seminar)'];
        $this->_list[] = [16 => 'РИТМ – Ваш идеальный вес (RHYTHM to a Perfect Weight)'];
        $this->_list[] = [17 => 'Друг Души (Soul Mate)'];
        $this->_list[] = [18 => 'Мировые отношения (World Relations)'];
        $this->_list[] = [19 => 'Игра Жизни (Game of Life)'];
    }

//Планы бытия. Часть 2 (Plane of Existence 2)
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
     * @return
     */
    public function itemLogo($id)
    {
        return $id . '.png';
    }

    /**
     *
     * @return
     */
    public function itemName($id)
    {
        return $this->_list[$id-1][$id];
    }

    /**
     *
     * @return
     */
    public function id($name)
    {
        foreach ($this->_list as $key => $item) {
            if (!strcmp($name, $item[$key+1])) {
                return $key+1;
            }
        }
        return 0;
    }


}
