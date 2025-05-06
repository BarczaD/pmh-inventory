<?php

namespace app\controllers;

use app\models\forms\ContactForm;
use app\models\forms\LoginForm;
use app\models\forms\SignupForm;
use app\models\forms\WorkstationForm;
use app\models\Workstation;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
                'class' => VerbFilter::class,
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
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->actionLogin();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->goBack();
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionNewWorkstation()
    {
        $model = new Workstation();
        if ($model->load(Yii::$app->request->post())) {  // && $model->validate()
            $model->processPost(Yii::$app->request->post());
            if ($model->saveWorkstation()) {
                return $this->actionManageData();
            }
            return false;
        }

        return $this->render('new-workstation', [
            'model' => $model,
        ]);
    }

    public function actionManageData()
    {
        $workstationProvider = new ActiveDataProvider([
            'query' => WorkstationController::getWorkstations(),
            'pagination' => [],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $cpuProvider = new ActiveDataProvider([
           'query' => CpuController::getCpus(),
           'pagination' => [],
           'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $monitorProvider = new ActiveDataProvider([
            'query' => MonitorController::getMonitors(),
            'pagination' => [],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $officeProvider = new ActiveDataProvider([
           'query' => OfficeController::getOffices(),
           'pagination' => [],
           'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);
        $colleagueProvider = new ActiveDataProvider([
            'query' => ColleagueController::getColleagues(),
            'pagination' => [],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        return $this->render('manage-data', [
            'workstationProvider' => $workstationProvider,
            'cpuProvider' => $cpuProvider,
            'monitorProvider' => $monitorProvider,
            'officeProvider' => $officeProvider,
            'colleagueProvider' => $colleagueProvider,
        ]);
    }
}
