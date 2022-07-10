<?php

namespace app\controllers;

use app\models\search\HistorySearch;
use Yii;
use yii\web\Controller;

class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * @param string $exportType
     * @return string
     */
    public function actionExport($exportType)
    {
        $model = Yii::$container->get(HistorySearch::class);

        return $this->render('export', [
            'dataProvider' => $model->search(Yii::$app->request->queryParams, true),
            'exportType' => $exportType,
            'model' => $model
        ]);
    }
}
