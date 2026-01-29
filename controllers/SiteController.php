<?php

namespace app\controllers;

use app\models\forms\ContactForm;
use app\models\forms\LoginForm;
use app\models\forms\SignupForm;
use app\models\forms\WorkstationForm;
use app\models\Log;
use app\models\Maintenance;
use app\models\forms\PasswordChangeForm;
use app\models\User;
use app\models\Workstation;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use app\models\Cpu;
use app\models\Monitor;
use app\models\Office;
use app\models\Colleague;
use app\models\Brand;

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
                // Add 'error' to the 'only' array so it is governed by these rules
                'only' => ['logout', 'error'],
                'rules' => [
                    [
                        // This rule allows ANYONE (guests and logged-in users)
                        // to see the error page without a DB-reliant permission check.
                        'actions' => ['error'],
                        'allow' => true,
                    ],
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

        return $this->actionIndex();
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
        return $this->redirect(['workstation/create']);
    }

    public function actionNewMaintenance()
    {
        $model = new Maintenance();
        if ($model->load(Yii::$app->request->post())) {
            $model->processPost(Yii::$app->request->post());
            if ($model->saveMaintenance())
            {
                return $this->actionManageData();
            }

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
        // 1. Capture search parameters
        $hostname = Yii::$app->request->get('hostname');
        $colleagueName = Yii::$app->request->get('searchColleague');
        $searchOffice = Yii::$app->request->get('searchOffice');

        // 2. Build Workstation Query with relations
        $workstationQuery = Workstation::find()->joinWith(['colleague', 'office']);

        // andFilterWhere is "smart": it only adds the condition if the value is not empty
        $workstationQuery->andFilterWhere(['like', 'workstation.hostname', $hostname])
            ->andFilterWhere(['like', 'colleague.name', $colleagueName])
            ->andFilterWhere(['like', 'office.name', $searchOffice]);

        $workstationProvider = new ActiveDataProvider([
            'query' => $workstationQuery,
            'pagination' => false, // Set to false to show all as per your '[]' intent
            'sort' => ['defaultOrder' => ['hostname' => SORT_ASC]],
        ]);

        // 3. Initialize other Providers directly from Models
        // This fixes the "Undefined method ...Controller::get..." errors

        $cpuProvider = new ActiveDataProvider([
            'query' => Cpu::find(),
            'pagination' => false,
            'sort' => ['defaultOrder' => ['brand' => SORT_ASC, 'model' => SORT_ASC]],
        ]);

        $monitorProvider = new ActiveDataProvider([
            'query' => Monitor::find(),
            'pagination' => false,
            'sort' => ['defaultOrder' => ['brand' => SORT_ASC, 'model' => SORT_ASC]],
        ]);

        $officeProvider = new ActiveDataProvider([
            'query' => Office::find(),
            'pagination' => false,
            'sort' => ['defaultOrder' => ['name' => SORT_ASC]],
        ]);

        $colleagueProvider = new ActiveDataProvider([
            'query' => Colleague::find(),
            'pagination' => false,
            'sort' => ['defaultOrder' => ['archived' => SORT_ASC, 'name' => SORT_ASC]],
        ]);

        $brandProvider = new ActiveDataProvider([
            'query' => Brand::find(),
            'pagination' => false,
            'sort' => ['defaultOrder' => ['name' => SORT_ASC]],
        ]);

        // 4. Render view with all providers and search terms
        return $this->render('manage-data', [
            'workstationProvider' => $workstationProvider,
            'cpuProvider'         => $cpuProvider,
            'monitorProvider'     => $monitorProvider,
            'officeProvider'      => $officeProvider,
            'colleagueProvider'   => $colleagueProvider,
            'brandProvider'       => $brandProvider,
            'searchHostname'      => $hostname,
            'searchColleague'     => $colleagueName,
            'searchOffice'        => $searchOffice,
        ]);
    }

    public function actionChangePassword()
    {
        $user = User::findOne(Yii::$app->user->id);
        if (!$user) {
            throw new \yii\web\NotFoundHttpException("Felhasználó nem található.");
        }

        $model = new PasswordChangeForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($user->changePassword($model->new_password)) {
                Yii::$app->session->setFlash('success', 'Jelszó sikeresen megváltoztatva.');
                return $this->redirect(["site/manage-data"]);
            }
        }

        return $this->render('change-password', [
            'model' => $model,
        ]);
    }

    public function actionLog()
    {
        $searchDescription = Yii::$app->request->get('event_description', '');
        $searchDate = Yii::$app->request->get('log_date', '');
        $searchUser = Yii::$app->request->get('triggered_by', '');

        $query = \app\models\Log::find()->joinWith('user');

        if ($searchDescription !== '') {
            $query->andWhere(['like', 'event_description', $searchDescription]);
        }

        // The HTML5 date input returns YYYY-MM-DD
        if ($searchDate !== '') {
            $query->andWhere(['like', 'log_date', $searchDate]);
        }

        if ($searchUser !== '') {
            $query->andWhere(['triggered_by' => $searchUser]);
        }

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 50],
            'sort' => ['defaultOrder' => ['log_date' => SORT_DESC]],
        ]);

        return $this->render('logs', [
            'dataProvider' => $dataProvider,
            'searchDescription' => $searchDescription,
            'searchDate' => $searchDate,
            'searchUser' => $searchUser,
        ]);
    }

    public function actionError()
    {
        // Disabling the layout prevents the app from trying to
        // render menus/user names that might hit the DB.
        $this->layout = false;

        $exception = Yii::$app->errorHandler->exception;

        if ($exception !== null) {
            // If it's a DB error, show the offline page
            if ($exception instanceof \yii\db\Exception ||
                $exception instanceof \PDOException) {

                return $this->render('db-offline', [
                    'exception' => $exception,
                ]);
            }
        }

        // Default error handling for everything else (404, etc.)
        return $this->render('error', ['exception' => $exception]);
    }
}
