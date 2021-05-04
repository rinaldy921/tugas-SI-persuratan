<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SuratKeluar;

/**
 * SuratKeluarSearch represents the model behind the search form of `app\models\SuratKeluar`.
 */
class SuratKeluarSearch extends SuratKeluar
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_surat_keluar', 'no_agenda'], 'integer'],
            [['tanggal_surat_keluar', 'perihal_surat_keluar'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SuratKeluar::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'no_surat_keluar' => $this->no_surat_keluar,
            'tanggal_surat_keluar' => $this->tanggal_surat_keluar,
            'no_agenda' => $this->no_agenda,
        ]);

        $query->andFilterWhere(['like', 'perihal_surat_keluar', $this->perihal_surat_keluar]);

        return $dataProvider;
    }
}
