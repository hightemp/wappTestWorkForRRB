<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class MObject extends ActiveRecord
{
	public static function tableName()
    {
        return '{{objects}}';
    }
    
    public function getBlocks($oFilterForm)
    {
	    return $this
	    	->hasMany(MBlock::className(), ['iMObjectID' => 'iMObjectID'])
	    	->andOnCondition("
	    		iArea >= {$oFilterForm->iMinArea} 
	    		AND iArea <= {$oFilterForm->iMaxArea}
	    		AND iPricePerYear >= {$oFilterForm->iMinPricePerYear}
	    		AND iPricePerYear <= {$oFilterForm->iMaxPricePerYear}
	    		AND iFloor >= {$oFilterForm->iMinFloor}
	    		AND iFloor <= {$oFilterForm->iMaxFloor}
		    ")->all();
    }
}