<?php

namespace app\models;

use Yii;
use yii\base\Model;

class MFilterForm extends Model
{
    public $iMaxArea;
    public $iMinArea;
    public $iMaxPricePerYear;
    public $iMinPricePerYear;
    public $iMaxFloor;
    public $iMinFloor;
    public $aRanges;
    
	public function rules()
    {
		return [
			[[
				'iMaxArea', 
				'iMinArea', 
				'iMaxPricePerYear', 
				'iMinPricePerYear', 
				'iMaxFloor',
				'iMinFloor',
			], 'required'],
			['iMaxArea', 'integer', 'min' => 1],
			['iMinArea', 'integer', 'min' => 1],
			['iMaxPricePerYear', 'integer', 'min' => 1],
			['iMinPricePerYear', 'integer', 'min' => 1],
			['iMaxFloor', 'integer', 'min' => 1],
			['iMinFloor', 'integer', 'min' => 1],
		];
	}
}