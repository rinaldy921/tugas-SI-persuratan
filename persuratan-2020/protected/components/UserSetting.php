<?php

class UserSetting extends CWebUser {

    protected $_model;

    protected function loadUser() {
        if ($this->_model === null) {
            $this->_model = AppUsers::model()->with('idRole')->findByPk($this->id);
        }
        return $this->_model;
    }
    

    public function findUser(){
        return $this->loadUser(Yii::app()->user->id);
    }

    public function findRole() {
        $user = $this->loadUser(Yii::app()->user->id);
        if ($user) {
                return $user->id_role;
        }
        return false;
    }
    
    
    public function isAdmin() {
        $user = $this->loadUser(Yii::app()->user->id);
        if ($user) {
            if ($user->id_role == 1) {
                return true;
            }
        }
        return false;
    }

    public function isPerusahaan() {
        $user = $this->loadUser(Yii::app()->user->id);
        if ($user) {
            if ($user->id_role == 2) {
                return true;
            }
        }
        return false;
    }
    
    public function isBPHP() {
        $user = $this->loadUser(Yii::app()->user->id);
        if ($user) {
            if ($user->id_role == 3) {
                return true;
            }
        }
        return false;
    }
    
    public function isDishut(){
         $user = $this->loadUser(Yii::app()->user->id);
        if ($user) {
            if ($user->id_role == 4) {
                return true;
            }
        }
        return false;
    }
    
    public function isUHP(){
         $user = $this->loadUser(Yii::app()->user->id);
        if ($user) {
            if ($user->id_role == 6) {
                return true;
            }
        }
        return false;
    }
    
    public function isPKUHT(){
         $user = $this->loadUser(Yii::app()->user->id);
        if ($user) {
            if ($user->id_role == 6) {
                return true;
            }
        }
        return false;
    }

     public function isKphp(){
         $user = $this->loadUser(Yii::app()->user->id);
        if ($user) {
            if ($user->id_role == 5) {
                return true;
            }
        }
        return false;
    }
    
    
    public function isLvlk(){
         $user = $this->loadUser(Yii::app()->user->id);
        if ($user) {
            if ($user->id_role == 7) {
                return true;
            }
        }
        return false;
    }
    
    public function isPimpinanUM(){
         $user = $this->loadUser(Yii::app()->user->id);
        if ($user) {
            if ($user->id_role == 9) {
                return true;
            }
        }
        return false;
    }
    
    
    public function namaUser() {
        $user = $this->loadUser(Yii::app()->user->id);
        if ($user) {
            return $user->nama_user;
        }
        return "";
    }

    public function idPerusahaan() {
        $user = $this->loadUser(Yii::app()->user->id);
        if ($user) {
            return $user->id_perusahaan;
        }
        return "";
    }

    public function idIuphhk() {
        $id = $this->idPerusahaan();
        $iuphhk = Iuphhk::model()->findByAttributes(
                array('id_perusahaan' => $id)
        );
        if ($iuphhk) {
            return $iuphhk->id_iuphhk;
        } else {
            return NULL;
        }
    }

    public function hasIuphhk() {
        $id = $this->idPerusahaan();
        $iuphhk = Iuphhk::model()->findByAttributes(
                array('id_perusahaan' => $id)
        );
        if ($iuphhk) {
            return true;
        } else {
            return false;
        }
    }
    
    public function adminRole() {
        $user = $this->loadUser(Yii::app()->user->id);
        if ($user) {
            if ($user->id_role == 1 || $user->id_role == 3 || $user->id_role == 4  || $user->id_role == 5 || $user->id_role == 7) {
                return $user->idRole->nama_role;
            }
        }
        return '';
    }

    public function perusahaanRole() {
        $user = $this->loadUser(Yii::app()->user->id);
        if ($user) {
            if ($user->id_role == 2 || $user->id_role == 9) {
                return $user->idRole->nama_role;
            }
        }
        return '';
    }
    
//    public function pimpinanUmRole() {
//        $user = $this->loadUser(Yii::app()->user->id);
//        if ($user) {
//            if ($user->id_role == 9) {
//                return $user->idRole->nama_role;
//            }
//        }
//        return '';
//    }

    public function getRoleName() {
        $user = $this->loadUser(Yii::app()->user->id);
        if ($user) {
            if ($user->id_role == 2) {
                return 'perusahaan';
            } elseif ($user->id_role == 1) {
                return 'admin';
            } else {
                return 'bphp';
            }
        }
        return '';
    }

}
