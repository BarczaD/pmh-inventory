<?php

namespace app\controllers;

use app\models\forms\ContactForm;
use app\models\forms\LoginForm;
use app\models\forms\SignupForm;
use app\models\forms\WorkstationForm;
use app\models\Maintenance;
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
        if ($model->load(Yii::$app->request->post())) {
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

    public function actionNewMaintenance()
    {
        $model = new Maintenance();

        if ($model->load(Yii::$app->request->post())) {
            $model = MaintenanceController::processNewMaintenance(Yii::$app->request->post());

            if ($model) {
                return $this->actionManageData();
            }
            return false;
        }

        return $this->render('new-maintenance', [
            'model' => $model,
        ]);
    }

    public function actionManageData()
    {

        $hostname = null;
        $colleagueName = null;
        $searchOffice = null;

        if (Yii::$app->request->get('hostname') || Yii::$app->request->get('searchColleague') || Yii::$app->request->get('searchOffice')) {
            $hostname = Yii::$app->request->get('hostname');
            $colleagueName = Yii::$app->request->get('searchColleague');
            $searchOffice = Yii::$app->request->get('searchOffice');

            $query = Workstation::find()->joinWith('colleague')->joinWith('office');

            if ($hostname) {
                $query->andFilterWhere(['like', 'hostname', $hostname]);
            }

            if ($colleagueName) {
                $query->andFilterWhere(['like', 'colleague.name', $colleagueName]);
            }

            if ($searchOffice) {
                $query->andFilterWhere(['like', 'office.name', $searchOffice]);
            }

            $workstationProvider = new ActiveDataProvider([
                'query' => $query,
                'sort' => ['defaultOrder' => ['hostname' => SORT_ASC]],
            ]);
        } else {
            $workstationProvider = new ActiveDataProvider([
                'query' => WorkstationController::getWorkstations(),
                'pagination' => [],
                'sort' => ['defaultOrder' => ['hostname' => SORT_ASC]],
            ]);
        }

        $cpuProvider = new ActiveDataProvider([
           'query' => CpuController::getCpus(),
           'pagination' => [],
           'sort' => ['defaultOrder' => ['brand' => SORT_ASC, 'model' => SORT_ASC]],
        ]);

        $monitorProvider = new ActiveDataProvider([
            'query' => MonitorController::getMonitors(),
            'pagination' => [],
            'sort' => ['defaultOrder' => ['brand' => SORT_ASC, 'model' => SORT_ASC]],
        ]);

        $officeProvider = new ActiveDataProvider([
           'query' => OfficeController::getOffices(),
           'pagination' => [],
           'sort' => ['defaultOrder' => ['name' => SORT_ASC]],
        ]);
        $colleagueProvider = new ActiveDataProvider([
            'query' => ColleagueController::getColleagues(),
            'pagination' => [],
            'sort' => ['defaultOrder' => ['archived' => SORT_ASC, 'name' => SORT_ASC]],
        ]);

        $brandProvider = new ActiveDataProvider([
            'query' => BrandController::getBrands(),
            'pagination' => [],
            'sort' => ['defaultOrder' => ['name' => SORT_ASC]],
        ]);

        return $this->render('manage-data', [
            'workstationProvider' => $workstationProvider,
            'cpuProvider' => $cpuProvider,
            'monitorProvider' => $monitorProvider,
            'officeProvider' => $officeProvider,
            'colleagueProvider' => $colleagueProvider,
            'brandProvider' => $brandProvider,
            'searchHostname' => $hostname,
            'searchColleague' => $colleagueName,
            'searchOffice' => $searchOffice,
        ]);
    }
}
