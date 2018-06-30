<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use app\models\MFilterForm;
use app\models\MObject;
use app\models\MBlock;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
	    $oRequest = Yii::$app->request;
	    $oFilterForm = new MFilterForm();
	    
		$aRanges = MBlock::getRangeValues();

		$oFilterForm->load($oRequest->post());
	    
	    $aObjects = MObject::find();

	    if ($oFilterForm->validate()) {
		    $aObjects
		    	->innerJoin(
		    		'blocks AS b',
		    		"
		    			b.iMObjectID = objects.iMObjectID 
			    		AND b.iArea >= {$oFilterForm->iMinArea} 
			    		AND b.iArea <= {$oFilterForm->iMaxArea}
			    		AND b.iPricePerYear >= {$oFilterForm->iMinPricePerYear}
			    		AND b.iPricePerYear <= {$oFilterForm->iMaxPricePerYear}
			    		AND b.iFloor >= {$oFilterForm->iMinFloor}
			    		AND b.iFloor <= {$oFilterForm->iMaxFloor}
			    	"
		    	);
		} else {

		    $oFilterForm->iMinArea = $oRequest->post('iMinArea', $aRanges['MIN(iArea)']);
		    $oFilterForm->iMaxArea = $oRequest->post('iMaxArea', $aRanges['MAX(iArea)']);
		    $oFilterForm->iMinPricePerYear = $oRequest->post('iMinPricePerYear', $aRanges['MIN(iPricePerYear)']);
		    $oFilterForm->iMaxPricePerYear = $oRequest->post('iMaxPricePerYear', $aRanges['MAX(iPricePerYear)']);
		    $oFilterForm->iMinFloor = $oRequest->post('iFloor', $aRanges['MIN(iFloor)']);
		    $oFilterForm->iMaxFloor = $oRequest->post('iFloor', $aRanges['MAX(iFloor)']);
		}

		$oFilterForm->aRanges = $aRanges;
		
		$aObjects
			->groupBy('iMObjectID');
		$oPages = new Pagination([
			'pageSize' => 5,
			'totalCount' => $aObjects->count(),
		]);
		$aObjects
			->offset($oPages->offset)
	        ->limit($oPages->limit)
			->orderBy('iMObjectID');
		
		$aObjects = $aObjects->all();
				
		if ($oRequest->isAjax) {
	        return $this->renderPartial(
	        	'objects', 
	        	[
	        		'aObjects' => $aObjects,
	        		'oFilterForm' => $oFilterForm,
	        		'oPages' => $oPages,
	        	]
	        );
		} else {
	        return $this->render(
	        	'index', 
	        	[
	        		'aObjects' => $aObjects,
	        		'aRanges' => $aRanges,
	        		'oFilterForm' => $oFilterForm,
	        		'oPages' => $oPages,
	        	]
	        );
	    }
    }
}
