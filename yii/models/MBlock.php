<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;

class MBlock extends ActiveRecord
{
	public static function tableName()
    {
        return '{{blocks}}';
    }
    
    public function getObject() 
    {
	    return $this->hasOne(MObject::className(), ['iMObjectID' => 'iMObjectID']);
    }
    
    public static function getRangeValues() 
    {
		$aRow = (new Query())
			->select([
				'MAX(iArea)', 
				'MIN(iArea)', 
				'MAX(iPricePerYear)', 
				'MIN(iPricePerYear)',
				'MAX(iFloor)',
				'MIN(iFloor)',
			])
			->from('{{blocks}}')
			->one();
		
		return $aRow;
    }
}