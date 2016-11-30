<?php

class SiteController extends Controller
{
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        echo 123;
        exit;
        $this->render('index');
    }
}