<?php

namespace yiix\commands;

use common\models\User;
use yii\console\Controller;

class UserController extends Controller
{

    public $id;

    public function options($actionID)
    {
        return ['id'];
    }

    public function actionList()
    {
        echo "\nUsers list:\n";
        foreach (User::find()->orderBy("id")->all() as $user) {
            echo $user->id . "\t" . $user->username . "\t" . $user->email . "\n";
        }
    }

    public function actionPassword()
    {
        if (!$this->id) {
            echo "Please, enter user ID:\n";
            $this->id = trim(fgets(STDIN));
        }

        $user = User::find()->where(["id" => $this->id])->one();
        if (!$user) {
            echo "User no found\n";
            return;
        }
        echo "Enter new password:\n";
        $password = trim(fgets(STDIN));
        $user->setPassword($password);
        if ($user->save()) {
            echo "Success\n";
        } else {
            print_r($user->getErrors());
        }
    }

}