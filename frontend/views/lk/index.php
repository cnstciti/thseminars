<?php
use yii\bootstrap\Tabs;

$this->title = 'Личный кабинет инструктора';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div id="lk" class="mt-4 mb-4">

<?
    $contentProfile = $this->render('parts/profile', ['instructor' => $instructor]);
    $contentAbout   = $this->render('parts/about', ['instructor' => $instructor]);
    $contentSeminar = $this->render('parts/seminar', ['seminars' => $seminars]);
//    $contentAccount = $this->render('parts/account', ['user' => $user]);
    $activeProfile  = false;
    $activeAbout    = false;
    $activeSeminar  = false;
//    $activeAccount  = false;
    switch ($action) {
        case 'edit-profile':
            $contentProfile = $this->render('parts/edit-profile', ['instructor' => $instructor]);
            $activeProfile = true;
            break;
        case 'edit-about':
            $contentAbout = $this->render('parts/edit-about', ['instructor' => $instructor]);
            $activeAbout = true;
            break;
        case 'create-seminar':
        case 'edit-seminar':
            $contentSeminar = $this->render('parts/form-seminar', [
                'model'       => $model,
                'cities'      => $cities,
                'instructor'  => $instructor,
                'instructors' => $instructors,
                'mode'        => $mode,
            ]);
            $activeSeminar = true;
            break;
        case 'publish-seminar':
            $contentSeminar = $this->render('parts/form-seminar', [
                'model'         => $model,
                'cities'        => $cities,
                'instructor'    => $instructor,
                'instructors'   => $instructors,
                'mode'          => $mode,
                'numPubSeminar' => $numPubSeminar,
                'maxPubSeminar' => $maxPubSeminar,
            ]);
            $activeSeminar = true;
            break;
        case 'nopublish-seminar':
            $contentSeminar = $this->render('parts/nopublish-seminar', ['maxPubSeminar' => $maxPubSeminar]);
            $activeSeminar  = true;
            break;
            /*
        case 'edit-password':
            $contentAccount  = $this->render('parts/edit-password', ['user' => $user]);
            $activeAccount   = true;
            break;
        case 'edit-email':
            $contentAccount  = $this->render('parts/edit-email', ['user' => $user]);
            $activeAccount   = true;
            break;
            */
    }
    switch ($tab) {
        case 'about':
            $activeAbout   = true;
            break;
        case 'seminar':
            $activeSeminar = true;
            break;
            /*
        case 'account':
            $activeAccount = true;
            break;
            */
        default:
            $activeProfile = true;
            break;
    }
    echo Tabs::widget([
        'items' => [
            [
                'label'   => 'Мой профиль',
                'content' => $contentProfile,
                'active'  => $activeProfile,
            ],
            [
                'label'   => 'Обо мне',
                'content' => $contentAbout,
                'active'  => $activeAbout,
            ],
            [
                'label'   => 'Мои семинары',
                'content' => $contentSeminar,
                'active'  => $activeSeminar,
            ],
            /*
            [
                'label'   => 'Учётная запись',
                'content' => $contentAccount,
                'active'  => $activeAccount,
            ],
            */
        ],
        'options' => ['tag' => 'div'],
    ]);
?>

</div>
