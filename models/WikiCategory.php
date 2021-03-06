<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "wiki_categories".
 *
 * @property integer $id
 * @property string $name
 * @property integer $sequence
 *
 * @property Wiki[] $wikis
 */
class WikiCategory extends \yii\db\ActiveRecord
{
    public $count;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wiki_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['sequence'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'sequence' => 'Sequence',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWikis()
    {
        return $this->hasMany(Wiki::className(), ['category_id' => 'id']);
    }

    public static function getSelectData()
    {
        return ArrayHelper::map(static::find()->orderBy(['name' => SORT_ASC])->asArray()->all(), 'id', 'name');
    }

    /**
     * @return ActiveQuery
     */
    public static function findWithCountData()
    {
        return static::find()->alias('c')->joinWith('wikis')
            ->select(['c.id', 'c.name', 'COUNT(*) AS count'])
            ->groupBy(['c.id', 'c.name']);
    }
}
