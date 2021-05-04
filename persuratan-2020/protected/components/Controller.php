<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public function wp_trim($str, $width = 60, $break = "|") {
        $formatted = '';
        $position = -1;
        $prev_position = 0;
        $last_line = -1;
        while ($position = mb_stripos($str, " ", ++$position, 'utf-8')) {
            if ($position > $last_line + $width + 1) {
                $formatted.= mb_substr($str, $last_line + 1, $prev_position - $last_line - 1, 'utf-8') . $break;
                $last_line = $prev_position;
            }
            $prev_position = $position;
        }
        $formatted.= mb_substr($str, $last_line + 1, mb_strlen($str), 'utf-8');
        $words = explode('|', $formatted);
        return (count($words) > 1) ? trim($words[0]) . " ..." : trim($words[0]);
    } 

    public function init() {
        $action = array('site');
        if(!Yii::app()->user->isGuest) {
            if (in_array(Yii::app()->controller->id, $action)) {
                Yii::app()->theme = 'public';
            } else {
                Yii::app()->theme = 'ebro';
            }
        } else {
            Yii::app()->theme = 'public';
        }
        parent::init();
        $locale = (Yii::app()->language == 'en' || Yii::app()->language == 'en_us') ? $this->getLocaleOS("en") : $this->getLocaleOS();
        setlocale(LC_ALL, $locale);
    }

    protected function getLocaleOS($loc = "id") {
        $os = (php_uname()) ? php_uname() : PHP_OS;
        if ($loc == "en") {
            $locale = (strtoupper(substr($os, 0, 3)) === 'WIN') ? "American" : "en_EN";
        } else {
            $locale = (strtoupper(substr($os, 0, 3)) === 'WIN') ? "Indonesian" : "id_ID";
        }
        return $locale;
    }

    public function getDateMonth($date) {
        return strftime("%d %B %Y", strtotime($date));
    }
    
    public function getDateTime($date) {
        return strftime("%d %B %Y, %H:%M:%S", strtotime($date));
    }

    public function getKPH($data, $row) {
        $row = Kabupaten::model()->findByPk($data->kph);
        if ($row) {
            return $row->nama;
        } else {
            return "";
        }
    }

    public function getBKPH($data, $row) {
        $row = Kabupaten::model()->findByPk($data->bkph);
        if ($row) {
            return $row->nama;
        } else {
            return "";
        }
    }

    public function getRPH($data, $row) {
        $row = Kecamatan::model()->findByPk($data->rph);
        if ($row) {
            return $row->nama;
        } else {
            return "";
        }
    }

    protected function generateReport($id_perusahaan, $rkt) {

        $model = new PenilaianKinerja;
        $model->id_perusahaan = $id_perusahaan;
        $model->id_rkt = $rkt->id;
        $model->tahun = $rkt->tahun_mulai;

        // //cek tata batas
        // $modelTataBatas = new RktTataBatas;
        // $modelTataBatas->unsetAttributes();
        // $modelTataBatas->id_rkt = $rkt->id;

        // $tata_batas = RktTanam::model()->getTotalPersen($modelTataBatas->search()->getData(), 'persentase');

        // if ($tata_batas > 50) {
        //     $model->aspek_1 = 14;
        // } elseif ($tata_batas >= 1 && $tata_batas <= 50) {
        //     $model->aspek_1 = 13;
        // } else {
        //     $model->aspek_1 = 12;
        // }

        // $status_batas = ProgresTataBatas::model()->find(array('condition' => 'id_rkt = ' . $rkt->id));
        // if ($status_batas) {
        //     if ($status_batas->status == 1) {
        //         $model->aspek_1 = 1;
        //     } elseif ($status_batas->status == 2) {
        //         $model->aspek_1 = 2;
        //     } else {
        //         $model->aspek_1 = 3;
        //     }
        // } else {
        //     $p_tb = new ProgresTataBatas;
        //     $p_tb->id_rkt = $rkt->id;
        //     $p_tb->status = 1;
        //     $p_tb->save();
        //     $model->aspek_1 = 1;
        // }
        // proses tata batas
        $model->aspek_2 = 6;
        $model->aspek_3 = 8;

        //cek ganis
        $modelGanis = new RktGanis;
        $modelGanis->unsetAttributes();
        $modelGanis->id_rkt = $rkt->id;

        // $ganis = RktTanam::model()->getTotalPersen($modelGanis->search()->getData(), 'persentase');

        // if ($ganis > 50) {
        //     $model->aspek_4 = 11;
        // } elseif ($ganis >= 1 && $ganis <= 50) {
        //     $model->aspek_4 = 10;
        // } else {
        //     $model->aspek_4 = 9;
        // }

        //cek penanaman
        $modelPenanaman = new RktTanam;
        $modelPenanaman->unsetAttributes();
        $modelPenanaman->id_rkt = $rkt->id;

        // $penanaman = RktTanam::model()->getTotalPersen($modelPenanaman->search()->getData(), 'persentase');

        // if ($penanaman > 50) {
        //     $model->aspek_5 = 14;
        // } elseif ($penanaman >= 1 && $penanaman <= 50) {
        //     $model->aspek_5 = 13;
        // } else {
        //     $model->aspek_5 = 12;
        // }

        //cek sertifikasi
        if (date('Y') == $rkt->tahun_mulai) {
            $condition_phpl = 'id_perusahaan = ' . $id_perusahaan . ' AND tanggal_mulai <= "' . date('Y-m-d') . '" AND tanggal_berakhir >= "' . date('Y-m-d') . '"';
            $condition_vlk = 'id_perusahaan = ' . $id_perusahaan . ' AND year(berlaku) <= "' . date('Y-m-d') . '" AND year(berakhir) >= "' . date('Y-m-d') . '"';
        } else {
            $condition_phpl = 'id_perusahaan = ' . $id_perusahaan . ' AND year(tanggal_mulai) <= ' . $rkt->tahun_mulai . ' AND year(tanggal_berakhir) >= ' . $rkt->tahun_mulai;
            $condition_vlk = 'id_perusahaan = ' . $id_perusahaan . ' AND year(berlaku) <= ' . $rkt->tahun_mulai . ' AND year(berakhir) >= ' . $rkt->tahun_mulai;
        }

        $phpl = SertifikasiPhpl::model()->find(array(
            'condition' => $condition_phpl
        ));
        if ($phpl) {
            $model->aspek_6 = 17;
        } else {
            $vlk = SertifikasiVlk::model()->find(array(
                'condition' => $condition_vlk
            ));
            if ($vlk) {
                $model->aspek_6 = 16;
            } else {
                $model->aspek_6 = 15;
            }
        }

        $model->save();
    }

    protected function updateReport($model, $rkt) {

        // //cek tata batas
        // $modelTataBatas = new RktTataBatas;
        // $modelTataBatas->unsetAttributes();
        // $modelTataBatas->id_rkt = $rkt->id;

        // $tata_batas = RktTanam::model()->getTotalPersen($modelTataBatas->search()->getData(), 'persentase');

        // if ($tata_batas > 50) {
        //     $model->aspek_1 = 14;
        // } elseif ($tata_batas >= 1 && $tata_batas <= 50) {
        //     $model->aspek_1 = 13;
        // } else {
        //     $model->aspek_1 = 12;
        // }

        $status_batas = ProgresTataBatas::model()->find(array('condition' => 'id_rkt = ' . $rkt->id));
        if ($status_batas) {
            if ($status_batas->status == 1) {
                $model->aspek_1 = 1;
            } elseif ($status_batas->status == 2) {
                $model->aspek_1 = 2;
            } else {
                $model->aspek_1 = 3;
            }
        } else {
            $p_tb = new ProgresTataBatas;
            $p_tb->id_rkt = $rkt->id;
            $p_tb->status = 1;
            $p_tb->save();
            $model->aspek_1 = 1;
        }
//        $model->aspek_2 = isset($data2->aspek_2) ? $data2->aspek_2 : 6;
//        $model->aspek_3 = isset($data2->aspek_3) ? $data2->aspek_3 : 8;
        //cek ganis
        $modelGanis = new RktGanis;
        $modelGanis->unsetAttributes();
        $modelGanis->id_rkt = $rkt->id;

        $ganis = RktTanam::model()->getTotalPersen($modelGanis->search()->getData(), 'persentase');

        if ($ganis > 50) {
            $model->aspek_4 = 11;
        } elseif ($ganis >= 1 && $ganis <= 50) {
            $model->aspek_4 = 10;
        } else {
            $model->aspek_4 = 9;
        }

        //cek penanaman
        $modelPenanaman = new RktTanam;
        $modelPenanaman->unsetAttributes();
        $modelPenanaman->id_rkt = $rkt->id;

        $penanaman = RktTanam::model()->getTotalPersen($modelPenanaman->search()->getData(), 'persentase');

        if ($penanaman > 50) {
            $model->aspek_5 = 14;
        } elseif ($penanaman >= 1 && $penanaman <= 50) {
            $model->aspek_5 = 13;
        } else {
            $model->aspek_5 = 12;
        }

        //cek sertifikasi
        if (date('Y') == $rkt->tahun_mulai) {
            $condition_phpl = 'id_perusahaan = ' . $rkt->id_perusahaan . ' AND tanggal_mulai <= "' . date('Y-m-d') . '" AND tanggal_berakhir >= "' . date('Y-m-d') . '"';
            $condition_vlk = 'id_perusahaan = ' . $rkt->id_perusahaan . ' AND year(berlaku) <= "' . date('Y-m-d') . '" AND year(berakhir) >= "' . date('Y-m-d') . '"';
        } else {
            $condition_phpl = 'id_perusahaan = ' . $rkt->id_perusahaan . ' AND year(tanggal_mulai) <= ' . $rkt->tahun_mulai . ' AND year(tanggal_berakhir) >= ' . $rkt->tahun_mulai;
            $condition_vlk = 'id_perusahaan = ' . $rkt->id_perusahaan . ' AND year(berlaku) <= ' . $rkt->tahun_mulai . ' AND year(berakhir) >= ' . $rkt->tahun_mulai;
        }

        $phpl = SertifikasiPhpl::model()->find(array(
            'condition' => $condition_phpl
        ));
        if ($phpl) {
            $model->aspek_6 = 17;
        } else {
            $vlk = SertifikasiVlk::model()->find(array(
                'condition' => $condition_vlk
            ));
            if ($vlk) {
                $model->aspek_6 = 16;
            } else {
                $model->aspek_6 = 15;
            }
        }

        $model->save();

        return $model;
    }

    protected function updateProgresTataBatas($id_rkt) {
        $model = PenilaianKinerja::model()->find(array(
            'condition' => 'id_rkt=' . $id_rkt. ' AND id_perusahaan=' . Yii::app()->user->idPerusahaan()
        ));

        $status_batas = ProgresTataBatas::model()->find(array('condition' => 'id_rkt = ' . $rkt->id));
        if ($status_batas) {
            if ($status_batas->status == 1) {
                $model->aspek_1 = 1;
            } elseif ($status_batas->status == 2) {
                $model->aspek_1 = 2;
            } else {
                $model->aspek_1 = 3;
            }
        } else {
            $p_tb = new ProgresTataBatas;
            $p_tb->id_rkt = $rkt->id;
            $p_tb->status = 1;
            $p_tb->save();
            $model->aspek_1 = 1;
        }

        $model->save();
    }

    function titleize($word) {
        $output = ucwords(str_replace('_', ' ', preg_replace('/_id$/', '', $word)));
        return ucwords($output);
    }

    function generateRandomString($length = 2) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function redirectx($status, $arr, $arr2 = null) {
        $message = ($status == 'success') ? Yii::t('app', 'Data berhasil disimpan.') : Yii::t('app', 'Data tidak berhasil disimpan.');
        Yii::app()->user->setFlash($status, $message);
        if (Yii::app()->request->isAjaxRequest) {
            $redirection = CJSON::encode($arr2);
            echo $redirection;
        } else {
            $this->redirect($arr);
        }
    }
}
