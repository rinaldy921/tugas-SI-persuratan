<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    private $_id;
    private $name;

    public function authenticate() {
        $record = AppUsers::model()->findByAttributes(array('username' => $this->username));
        if ($record === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        // else if ($record != null && $this->password == "admin") {
        //     $this->_id = $record->id;
        //     $this->name = $record->idRole->nama_role;
        //     $record->last_login = new CDbExpression("NOW()");
        //     $record->update(array('last_login'));
        //     Yii::app()->user->setState('type', $record->id_role);
        //     Yii::app()->user->setState('id_bphp', $record->id_bphp);
        //     $this->errorCode = self::ERROR_NONE;
        // }
        else if (!$record->validatePassword($this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else {
            $this->_id = $record->id;
            $this->name = $record->idRole->nama_role;
            $record->last_login = new CDbExpression("NOW()");
            $record->update(array('last_login'));
            Yii::app()->user->setState('type', $record->id_role);
            Yii::app()->user->setState('id_bphp', $record->id_bphp);
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    public function getId() {
        return $this->_id;
    }

    public function getName() {
        return $this->name;
    }

}
