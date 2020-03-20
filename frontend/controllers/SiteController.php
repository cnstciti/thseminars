<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\data\Pagination;
use common\models\LoginForm;
use frontend\models\auth\SignupForm;
use frontend\models\auth\PasswordResetRequestForm;
use frontend\models\auth\ResendVerificationEmailForm;
use frontend\models\auth\VerifyEmailForm;
use frontend\models\instructor\Instructor;
use frontend\models\seminar\Seminar;
use frontend\models\geo\City;
use frontend\models\main\PeriodDate;

/**
 * Site controller
 */
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
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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
        ];
    }

    /**
     * Главная страница
     *
     * @return mixed
     */
    public function actionIndex($city='', $type='', $page=0)
    {
        $tabSeminar = new Seminar;
        $periodDate = new PeriodDate;
        $numItems   = 10;
        $cityId     = (int)(new City)->idByNameEnglish($city);
        $dateFrom   = '';
        $dateTo     = '';

        if ($periodDate->load(Yii::$app->request->post())) {
            if ($periodDate->dateFrom) {
                $dateFrom = date('Y-m-d', strtotime($periodDate->dateFrom));
            }
            if ($periodDate->dateTo) {
                $dateTo = date('Y-m-d', strtotime($periodDate->dateTo));
            }
            $cityId = 0;
            $type = '';
            $page = 0;
        }

        $countActiveSeminars = $tabSeminar->countActive($cityId, $type, $dateFrom, $dateTo);
        $countActiveCities   = $tabSeminar->countActive(0, '', '', '');
        $cities              = $tabSeminar->activeCities();
        $types               = $tabSeminar->activeTypes();

        $page     = $this->convertPage($page, ceil($countActiveSeminars / $numItems));
        $seminars = $tabSeminar->active($cityId, $type, ($page-1)*$numItems, $numItems, $dateFrom, $dateTo);

        $pagination = new Pagination([
            'defaultPageSize' => $numItems,
            'totalCount'      => $countActiveSeminars,
        ]);

        return $this->render('index', [
            'countActiveSeminars' => $countActiveSeminars,
            'countActiveCities'   => $countActiveCities,
            'cities'              => $cities,
            'types'               => $types,
            'periodDate'          => $periodDate,
            'seminars'            => $seminars,
            'pagination'          => $pagination,
        ]);
    }

    /**
     * Страница семинара
     *
     * @return mixed
     */
    public function actionSeminar($id)
    {
        $seminar = new Seminar;

        if (!$seminar->isExistById($id)) {
            throw new BadRequestHttpException('Ошибка доступа!');
        }

        $model = $seminar->oneById($id);
        $instructor1 = Instructor::find()->where(['fkUserId' => $model['fkInstructorId1']])->one();
        $instructor2 = Instructor::find()->where(['fkUserId' => $model['fkInstructorId2']])->one();
        $instructor3 = Instructor::find()->where(['fkUserId' => $model['fkInstructorId3']])->one();

        return $this->render('seminar', [
            'model' => $model,
            'instructor1' => $instructor1,
            'instructor2' => $instructor2,
            'instructor3' => $instructor3,
        ]);
    }

    /**
     * Страница инструктора
     *
     * @return mixed
     */
    public function actionInstructor($id)
    {
        $instructor = new Instructor;

        if (!$instructor->isExistById($id)) {
            throw new BadRequestHttpException('Ошибка доступа!');
        }

        $model = Instructor::find()->where(['fkUserId' => $id])->one();
        $seminars = (new Seminar)->seminarsInstructor($id);

        return $this->render('instructor', [
            'instructor' => $model,
            'seminars'   => $seminars,
        ]);
    }

    /**
     * Регистрация
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            $userId = Yii::$app->db->lastInsertID;
            $instructor = new Instructor();
            $instructor->fkUserId = $userId;
            $instructor->name = 'Нет имени';
            $instructor->save();
            $dir = Yii::getAlias('@uploadUser') . $userId;
            if (!is_dir($dir)) {
                mkdir($dir);
            }
            Yii::$app->session->setFlash('success', 'Вы зарегистрированы. Пожалуйста, проверьте Ваш электронный почтовый ящик.');
            return $this->redirect(['index']);
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Авторизация
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['index']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['lk/index']);
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['index']);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Проверьте свою электронную почту для получения дальнейших инструкций.');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'К сожалению, мы не можем сбросить пароль для указанного адреса электронной почты.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * овторная отправка письма регистрации
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Проверьте свою электронную почту для получения дальнейших инструкций.');
                return $this->redirect(['index']);
            }
            Yii::$app->session->setFlash('error', 'К сожалению, мы не можем повторно отправить письмо с подтверждением для указанного адреса электронной почты.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Ваш Email подтвержден!');
                return $this->redirect(['index']);
            }
        }

        Yii::$app->session->setFlash('error', 'К сожалению, мы не можем подтвердить вашу учетную запись.');
        return $this->goHome();
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Новый пароль сохранен.');

            return $this->redirect(['index']);
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Конвертирует значение "№ страницы" в диапозон от 1 до максимального кол-ва страниц
     *
     * @return int - сконвертированный номер страницы.
     */
    private function convertPage($page, $countPage)
    {
        $intPage = (int)$page;
        if ($intPage<1) {
            return 1;
        }
        if ($countPage && $intPage>$countPage) {
            return $countPage;
        }
        return $intPage;
    }

}
