<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "surat_keluar".
 *
 * @property int $no_surat_keluar
 * @property string $tanggal_surat_keluar
 * @property string $perihal_surat_keluar
 * @property int $no_agenda
 *
 * @property SuratMasuk $noAgenda
 */
class SuratKeluar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'surat_keluar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal_surat_keluar', 'perihal_surat_keluar', 'no_agenda'], 'required'],
            [['tanggal_surat_keluar'], 'safe'],
            [['no_agenda'], 'integer'],
            [['perihal_surat_keluar'], 'string', 'max' => 50],
            [['no_agenda'], 'exist', 'skipOnError' => true, 'targetClass' => SuratMasuk::className(), 'targetAttribute' => ['no_agenda' => 'no_agenda']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'no_surat_keluar' => 'No Surat Keluar',
            'tanggal_surat_keluar' => 'Tanggal Surat Keluar',
            'perihal_surat_keluar' => 'Perihal Surat Keluar',
            'no_agenda' => 'No Agenda',
        ];
    }

    /**
     * Gets query for [[NoAgenda]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNoAgenda()
    {
        return $this->hasOne(SuratMasuk::className(), ['no_agenda' => 'no_agenda']);
    }
}
