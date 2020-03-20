<?php
namespace frontend\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\BadRequestHttpException;
use frontend\models\geo\City;
use frontend\models\instructor\Instructor;
use frontend\models\seminar\Seminar;
use frontend\models\seminar\SertSeminar;
//use common\models\User;

/**
 *  controller
 */
class LkController extends Controller
{
    /**
     * Личный кабинет инструктора
     *
     * @return mixed
     */
    public function actionIndex($tab = '')
    {
        return $this->render('index', [
            'instructor' => $this->authorizedInstructor(),
            'seminars'   => $this->seminarsInstructor(),
//            'user'       => User::find()->where(['id' => Yii::$app->user->id])->one(),
            'action'     => '',
            'tab'        => $tab,
        ]);
    }

    /**
     * Редактирование профиля инструктора
     *
     * @return mixed
     */
    public function actionEditProfile()
    {
        $tab        = 'profile';
        $instructor = $this->authorizedInstructor();

        if ($instructor->load(Yii::$app->request->post()) && $instructor->validate()) {
            $instructor->avatar      = $this->uploadFile($instructor, 'avatar', '@avatarInstructorWWW');
            $instructor->certificate = serialize($instructor->certificate);
            $instructor->language    = serialize($instructor->language);
            if ($instructor->save()) {
                return $this->redirect(['lk/index', 'tab' => $tab]);
            }
            throw new BadRequestHttpException('Ошибка сохранения профиля инструктора!');
        }

        return $this->render('index', [
            'instructor' => $instructor,
            'seminars'   => $this->seminarsInstructor(),
//            'user'       => User::find()->where(['id' => Yii::$app->user->id])->one(),
            'action'     => 'edit-profile',
            'tab'        => $tab,
        ]);
    }

    /**
     * Редактирование информации "Обо мне" инструктора
     *
     * @return mixed
     */
    public function actionEditAbout()
    {
        $tab        = 'about';
        $instructor = $this->authorizedInstructor();

        if ($instructor->load(Yii::$app->request->post()) && $instructor->validate()) {
            if ($instructor->save()) {
                return $this->redirect(['lk/index', 'tab' => $tab]);
            }
            throw new BadRequestHttpException('Ошибка сохранения информации "Обо мне"!');
        }

        return $this->render('index', [
            'instructor' => $instructor,
            'seminars'   => $this->seminarsInstructor(),
//            'user'       => User::find()->where(['id' => Yii::$app->user->id])->one(),
            'action'     => 'edit-about',
            'tab'        => $tab,
        ]);
    }

    /**
     * Создание семинара
     *
     * @return mixed
     */
    public function actionCreateSeminar()
    {
        $tab         = 'seminar';
        $seminar     = new Seminar;
        $sertSeminar = new SertSeminar;

        if ($seminar->load(Yii::$app->request->post()) && $seminar->validate()) {
            if ($seminar->sertSeminar) {
                $seminar->logo = $sertSeminar->itemLogo($seminar->name);
                $seminar->name = $sertSeminar->itemName($seminar->name);
            }
            if ($seminar->authSeminar) {
                $seminar->logo = $this->uploadFile($seminar, 'logo', '@logoAuthWWW');
            }
            $seminar->language  = serialize($seminar->language);
            $seminar->startDate = date('Y-m-d', strtotime($seminar->startDate));
            if ($seminar->save()) {
                return $this->redirect(['lk/index', 'tab' => $tab]);
            }
            throw new BadRequestHttpException('Ошибка создания семинара!');
        }

        $instructor         = $this->authorizedInstructor();
        if ($seminar->sertSeminar) {
            $seminar->name = $sertSeminar->id($seminar->name);
        }
        $seminar->startDate = date('Y-m-d');

        return $this->render('index', [
            'instructor'    => $instructor,
            'seminars'      => $this->seminarsInstructor(),
//            'user'          => User::find()->where(['id' => Yii::$app->user->id])->one(),
            'action'        => 'create-seminar',
            'tab'           => $tab,
            'model'         => $seminar,
            'cities'        => ArrayHelper::map(City::find()->all(), 'id', 'name'),
            'instructors'   => ArrayHelper::map(Instructor::find()->where('fkUserId != :fkUserId', ['fkUserId' => Yii::$app->user->id])->all(), 'fkUserId', 'name'),
            'mode'          => 'create',
        ]);
    }

    /**
     * Редактирование семинара
     *
     * @return mixed
     */
    public function actionEditSeminar($id)
    {
        $this->accessError($id);

        $tab         = 'seminar';
        $seminar     = Seminar::find()->where(['id' => $id])->one();
        $sertSeminar = new SertSeminar;

        if ($seminar->load(Yii::$app->request->post()) && $seminar->validate()) {
            if ($seminar->sertSeminar) {
                $seminar->logo = $sertSeminar->itemLogo($seminar->name);
                $seminar->name = $sertSeminar->itemName($seminar->name);
            }
            if ($seminar->authSeminar) {
                $seminar->logo = $this->uploadFile($seminar, 'logo', '@logoAuthWWW');
            }
            $seminar->language  = serialize($seminar->language);
            $seminar->startDate = date('Y-m-d', strtotime($seminar->startDate));
            if ($seminar->save()) {
                return $this->redirect(['lk/index', 'tab' => $tab]);
            }
            throw new BadRequestHttpException('Ошибка редактирования семинара!');
        }

        $instructor = $this->authorizedInstructor();
        if ($seminar->sertSeminar) {
            $seminar->name = $sertSeminar->id($seminar->name);
        }

        return $this->render('index', [
            'instructor'    => $instructor,
            'seminars'      => $this->seminarsInstructor(),
//            'user'          => User::find()->where(['id' => Yii::$app->user->id])->one(),
            'action'        => 'edit-seminar',
            'tab'           => $tab,
            'model'         => $seminar,
            'cities'        => ArrayHelper::map(City::find()->all(), 'id', 'name'),
            'instructors'   => ArrayHelper::map(Instructor::find()->where('fkUserId != :fkUserId', ['fkUserId' => Yii::$app->user->id])->all(), 'fkUserId', 'name'),
            'mode'          => 'edit',
        ]);
    }

    /**
     * Копирование семинара
     *
     * @return mixed
     */
    public function actionCopySeminar($id)
    {
        $this->accessError($id);

        $tab         = 'seminar';
        $seminar     = new Seminar;
        $sertSeminar = new SertSeminar;

        if ($seminar->load(Yii::$app->request->post()) && $seminar->validate()) {
            if ($seminar->sertSeminar) {
                $seminar->logo = $sertSeminar->itemLogo($seminar->name);
                $seminar->name = $sertSeminar->itemName($seminar->name);
            }
            if ($seminar->authSeminar) {
                $seminar->logo = $this->uploadFile($seminar, 'logo', '@logoAuthWWW');
            }
            $seminar->language  = serialize($seminar->language);
            $seminar->startDate = date('Y-m-d', strtotime($seminar->startDate));
            if ($seminar->save()) {
                return $this->redirect(['lk/index', 'tab' => $tab]);
            }
            throw new BadRequestHttpException('Ошибка копирования семинара!');
        }

        $instructor = $this->authorizedInstructor();
        $seminar     = Seminar::find()->where(['id' => $id])->one();
        if ($seminar->sertSeminar) {
            $seminar->name = $sertSeminar->id($seminar->name);
        }

        return $this->render('index', [
            'instructor'    => $instructor,
            'seminars'      => $this->seminarsInstructor(),
//            'user'          => User::find()->where(['id' => Yii::$app->user->id])->one(),
            'action'        => 'edit-seminar',
            'tab'           => $tab,
            'model'         => $seminar,
            'cities'        => ArrayHelper::map(City::find()->all(), 'id', 'name'),
            'instructors'   => ArrayHelper::map(Instructor::find()->where('fkUserId != :fkUserId', ['fkUserId' => Yii::$app->user->id])->all(), 'fkUserId', 'name'),
            'mode'          => 'copy',
        ]);
    }

    /**
     * Удаление семинара
     *
     * @return mixed
     */
    public function actionDeleteSeminar($id)
    {
        $this->accessError($id);

        $tab         = 'seminar';
        $seminar     = Seminar::find()->where(['id' => $id])->one();
        $sertSeminar = new SertSeminar;

        if ($seminar->load(Yii::$app->request->post())) {
            $seminar->delete();
            return $this->redirect(['lk/index', 'tab' => $tab]);
        }

        $instructor = $this->authorizedInstructor();
        if ($seminar->sertSeminar) {
            $seminar->name = $sertSeminar->id($seminar->name);
        }

        return $this->render('index', [
            'instructor'    => $instructor,
            'seminars'      => $this->seminarsInstructor(),
//            'user'          => User::find()->where(['id' => Yii::$app->user->id])->one(),
            'action'        => 'edit-seminar',
            'tab'           => $tab,
            'model'         => $seminar,
            'cities'        => ArrayHelper::map(City::find()->all(), 'id', 'name'),
            'instructors'   => ArrayHelper::map(Instructor::find()->where('fkUserId != :fkUserId', ['fkUserId' => Yii::$app->user->id])->all(), 'fkUserId', 'name'),
            'mode'          => 'delete',
        ]);
    }

    /**
     * Публикация семинара
     *
     * @return mixed
     */
    public function actionPublishSeminar($id)
    {
        $this->accessError($id);

        $tab           = 'seminar';
        $instructor    = $this->authorizedInstructor();
        $maxPubSeminar = 5;
        $numPubSeminar = (int)$instructor->numPubSeminar;
        $sertSeminar   = new SertSeminar;

        if ($numPubSeminar >= $maxPubSeminar) {
            return $this->render('index', [
                'instructor'    => $instructor,
                'seminars'      => $this->seminarsInstructor(),
//                'user'          => User::find()->where(['id' => Yii::$app->user->id])->one(),
                'action'        => 'nopublish-seminar',
                'tab'           => $tab,
                'maxPubSeminar' => $maxPubSeminar,
            ]);
        }

        $seminar = Seminar::find()->where(['id' => $id])->one();

        if ($seminar->load(Yii::$app->request->post()) && $seminar->validate()) {
            if ($seminar->sertSeminar) {
                $seminar->logo = $sertSeminar->itemLogo($seminar->name);
                $seminar->name = $sertSeminar->itemName($seminar->name);
            }
            if ($seminar->authSeminar) {
                $seminar->logo = $this->uploadFile($seminar, 'logo', '@logoAuthWWW');
            }
            $seminar->language  = serialize($seminar->language);
            $seminar->startDate = date('Y-m-d', strtotime($seminar->startDate));
            $seminar->publish = 1;
            if ($seminar->save()) {
                // если семинар платный
                if ($seminar->costDeposit + $seminar->costSeminar) {
                    $instructor->numPubSeminar += 1;
                    $instructor->save();
                }
                return $this->redirect(['lk/index', 'tab' => $tab]);
            }
            throw new BadRequestHttpException('Ошибка публикации семинара!');
        }

        if ($seminar->sertSeminar) {
            $seminar->name = $sertSeminar->id($seminar->name);
        }

        return $this->render('index', [
            'instructor'    => $instructor,
            'seminars'      => $this->seminarsInstructor(),
//            'user'          => User::find()->where(['id' => Yii::$app->user->id])->one(),
            'action'        => 'publish-seminar',
            'tab'           => $tab,
            'model'         => $seminar,
            'cities'        => ArrayHelper::map(City::find()->all(), 'id', 'name'),
            'instructors'   => ArrayHelper::map(Instructor::find()->where('fkUserId != :fkUserId', ['fkUserId' => Yii::$app->user->id])->all(), 'fkUserId', 'name'),
            'mode'          => 'publish',
            'numPubSeminar' => $numPubSeminar,
            'maxPubSeminar' => $maxPubSeminar,
        ]);
    }

    /**
     * Редактирование пароля инструктора
     *
     * @return mixed
     * /
    public function actionEditPassword()
    {
        $tab        = 'account';
        $instructor = $this->authorizedInstructor();

        if ($instructor->load(Yii::$app->request->post()) && $instructor->validate()) {
            /*
            $instructor->avatar      = $this->uploadFile($instructor, 'avatar', '@avatarInstructorWWW');
            $instructor->certificate = serialize($instructor->certificate);
            $instructor->language    = serialize($instructor->language);
            if ($instructor->save()) {
                return $this->redirect(['lk/index', 'tab' => $tab]);
            }
            throw new BadRequestHttpException('Ошибка сохранения профиля инструктора!');
            * /
        }

        return $this->render('index', [
            'instructor' => $instructor,
            'seminars'   => $this->seminarsInstructor(),
            'user'       => User::find()->where(['id' => Yii::$app->user->id])->one(),
            'action'     => 'edit-password',
            'tab'        => $tab,
        ]);
    }

    /**
     * Редактирование email инструктора
     *
     * @return mixed
     * /
    public function actionEditEmail()
    {
        $tab        = 'account';
        $instructor = $this->authorizedInstructor();

        if ($instructor->load(Yii::$app->request->post()) && $instructor->validate()) {
            /*
            $instructor->avatar      = $this->uploadFile($instructor, 'avatar', '@avatarInstructorWWW');
            $instructor->certificate = serialize($instructor->certificate);
            $instructor->language    = serialize($instructor->language);
            if ($instructor->save()) {
                return $this->redirect(['lk/index', 'tab' => $tab]);
            }
            throw new BadRequestHttpException('Ошибка сохранения профиля инструктора!');
            * /
        }

        return $this->render('index', [
            'instructor' => $instructor,
            'seminars'   => $this->seminarsInstructor(),
            'user'       => User::find()->where(['id' => Yii::$app->user->id])->one(),
            'action'     => 'edit-email',
            'tab'        => $tab,
        ]);
    }

    /**
     * Возвращает уникальное имя файла
     *
     * @param $path string Путь, где будет файл
     * @param $extension string Расширение файла
     * @return string
     */
    private function getRandomFileName($path, $extension = '')
    {
        $extension = $extension ? '.' . $extension : '';
        $path      = $path ? $path . '/' : '';

        do {
            $name = md5(microtime() . rand(0, 9999));
            $file = $path . $name . $extension;
        } while (file_exists($file));

        return $name . $extension;
    }

    /**
     * Авторизированный инструктор
     *
     * @return frontend\models\instructor\Instructor
     */
    private function authorizedInstructor()
    {
        return Instructor::find()->where(['fkUserId' => Yii::$app->user->id])->one();
    }

    /**
     * Семинары авторизированного инструктора
     *
     * @return yii\data\ArrayDataProvider
     */
    private function seminarsInstructor()
    {
        return (new Seminar)->allByUserId(Yii::$app->user->id);
        /*
        return new ArrayDataProvider([
            'allModels' => (new Seminar)->allByUserId(Yii::$app->user->id),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        */
    }

    /**
     * Проверка наличия семинара у инструктора
     *
     * @return BadRequestHttpException
     */
    private function accessError($id)
    {
        if (!(new Seminar)->isExist($id, Yii::$app->user->id)) {
            throw new BadRequestHttpException('Ошибка доступа!');
        }
    }

    /**
     *
     *
     * @return string
     */
    private function uploadFile($model, $attribute, $alias)
    {
        if (!empty($file = UploadedFile::getInstance($model, $attribute))) {
            // store the source file name
            $ext     = explode('.', $file->name);
            $ext     = end($ext);
            $newName = $this->getRandomFileName(Yii::getAlias($alias), $ext);
            $path    = Yii::getAlias($alias) . '/' . $newName;
            $file->saveAs($path);
            return $newName;
        }
        return '';
    }

}
