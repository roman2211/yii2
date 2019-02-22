<?php

namespace app\models\tables;

use Yii;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $responsible_id
 * @property string $date
 * @property int $status_id
 *
 * @property Users $responsible
 */
class Tasks extends \yii\db\ActiveRecord
{
     
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'date'], 'required'],
            [['description'], 'string'],
            [['responsible_id', 'status_id'], 'integer'],
            [['date'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['responsible_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['responsible_id' => 'id']],
            [['created_at', 'updated_at'], 'date'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name of task',
            'description' => 'Task description',
            'responsible_id' => 'Responsible',
            'date' => 'Deadline',
            'status_id' => 'Status ID',
        ];
    }

    public function behaviors()
     {
         return [
             [
                 'class' => TimestampBehavior::className(),
                 'value' => time(),
             ],
        ];
     }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsible()
    {
        return $this->hasOne(Users::className(), ['id' => 'responsible_id']);
    }

}
