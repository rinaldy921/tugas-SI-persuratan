<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "surat_masuk".
 *
 * @property int $no_agenda
 * @property string $tangggal_agenda
 * @property string $no_surat
 * @property string $tanggal_surat
 * @property string $asal_surat
 * @property string $perihal_surat
 * @property int|null $id_staf
 *
 * @property SuratKeluar[] $suratKeluars
 * @property StafPengolah $staf
 */
class SuratMasuk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'surat_masuk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tangggal_agenda', 'no_surat', 'tanggal_surat', 'asal_surat', 'perihal_surat'], 'required'],
            [['tangggal_agenda', 'tanggal_surat'], 'safe'],
            [['id_staf'], 'integer'],
            [['no_surat'], 'string', 'max' => 20],
            [['asal_surat'], 'string', 'max' => 50],
            [['perihal_surat'], 'string', 'max' => 100],
            [['id_staf'], 'exist', 'skipOnError' => true, 'targetClass' => StafPengolah::className(), 'targetAttribute' => ['id_staf' => 'id_staf']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'no_agenda' => 'No Agenda',
            'tangggal_agenda' => 'Tangggal Agenda',
            'no_surat' => 'No Surat',
            'tanggal_surat' => 'Tanggal Surat',
            'asal_surat' => 'Asal Surat',
            'perihal_surat' => 'Perihal Surat',
            'id_staf' => 'Daftar Staf Berdasarkan Kinerja',
        ];
    }

    /**
     * Gets query for [[SuratKeluars]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSuratKeluars()
    {
        return $this->hasMany(SuratKeluar::className(), ['no_agenda' => 'no_agenda']);
    }

    /**
     * Gets query for [[Staf]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStaf()
    {
        return $this->hasOne(StafPengolah::className(), ['id_staf' => 'id_staf']);
    }
}
