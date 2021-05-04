<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "staf_pengolah".
 *
 * @property int $id_staf
 * @property string $nama
 * @property int $kinerja
 *
 * @property SuratMasuk[] $suratMasuks
 */
class StafPengolah extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'staf_pengolah';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'lama_proses', 'kinerja'], 'required'],
            [['lama_proses', 'kinerja'], 'integer'],
            [['nama'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_staf' => 'Id Staf',
            'nama' => 'Nama',
            'lama_proses' => 'Lama Proses',
            'kinerja' => 'Kinerja',
        ];
    }

    /**
     * Gets query for [[SuratMasuks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSuratMasuks()
    {
        return $this->hasMany(SuratMasuk::className(), ['id_staf' => 'id_staf']);
    }
}
