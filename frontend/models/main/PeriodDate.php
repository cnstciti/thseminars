<?php

namespace frontend\models\main;

use Yii;
use yii\base\Model;

/**
 * @property date $dateFrom Дата начала периода
 * @property date $dateTo   Дата окончания периода
 */

class PeriodDate extends Model
{
    public $dateFrom;
    public $dateTo;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'dateFrom',
                    'dateTo',
                ],
                'safe'
            ],
//            ['dateFrom', 'compare', 'compareAttribute' => 'dateTo', 'operator' => '>='],
        ];
    }
}
