<?php

class OpenLayers extends CApplicationComponent {

    public $enableCdn = false;
    public $cs;
    public $_assetsUrl;
    public $version = 3;
    public $theme = 'default';
    private static $_instance;

    function __construct($config = array()) {
        if (!empty($config)) {
            $this->enableCdn = isset($config['enableCdn']) ? $config['enableCdn'] : $this->enableCdn;
            $this->version = isset($config['version']) ? $config['version'] : $this->version;
            $this->theme = isset($config['theme']) ? $config['theme'] : $this->theme;
        }
        if ($this->version === 3) {
            Yii::setPathOfAlias('openlayers', dirname(__FILE__) . '/../../statics/ol3');
        } else {
            Yii::setPathOfAlias('openlayers', dirname(__FILE__) . '/../../statics/openlayers');
        }
    }

    public function init() {
        self::setOpenlayers($this);
        $this->setRootAliasIfUndefined();
        $this->setAssetsRegistryIfNotDefined();
        parent::init();
    }

    public static function getOpenLayers() {

        if (null === self::$_instance) {
            $module = Yii::app()->getController()->getModule();
            if ($module) {
                if ($module->hasComponent('openlayers')) {
                    self::$_instance = $module->getComponent('openlayers');
                }
            }
            if (null === self::$_instance) {
                if (Yii::app()->hasComponent('openlayers')) {
                    self::$_instance = Yii::app()->getComponent('openlayers');
                }
            }
        }
        return self::$_instance;
    }

    public static function setOpenlayers($value) {
        if ($value instanceof Openlayers) {
            self::$_instance = $value;
        }
    }

    protected function setRootAliasIfUndefined() {
        if (Yii::getPathOfAlias('openlayers') === false) {
            Yii::setPathOfAlias('openlayers', realpath(dirname(__FILE__) . '/..'));
        }
    }

    protected function setAssetsRegistryIfNotDefined() {
        if (!$this->cs) {
            $this->cs = Yii::app()->getClientScript();
        }
    }

    public function registerAssets() {
        if ($this->version === 3) {
            $this->cs->registerCssFile($this->getAssetsUrl() . '/ol.css');
            $this->cs->registerScriptFile($this->getAssetsUrl() . '/ol.js');
        } else {
            $this->cs->registerCssFile($this->getAssetsUrl() . '/theme/'.$this->theme.'/style.css');
            $this->cs->registerScriptFile($this->getAssetsUrl() . '/OpenLayers.js');
        }
    }

    public function renderJsCode($code = "") {
        if (!empty($code)) {
            $this->registerAssets();
        }
        $this->cs->registerScript($this->getUniqueScriptId(), $code);
    }

    public function getUniqueScriptId() {
        return uniqid(__CLASS__ . '#', true);
    }

    public function getAssetsUrl() {
        if (isset($this->_assetsUrl)) {
            return $this->_assetsUrl;
        } else {
            return $this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('openlayers'), false, -1, false);
        }
    }

}
