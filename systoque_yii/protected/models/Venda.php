<?php

/**
 * This is the model class for table "venda".
 *
 * The followings are the available columns in table 'venda':
 * @property integer $codvenda
 * @property integer $matricula
 * @property string $data
 * @property string $datapreventrega
 * @property string $totalvenda
 * @property string $status
 */
class Venda extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'venda';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('matricula, data, datapreventrega, totalvenda, status', 'required'),
			array('matricula', 'numerical', 'integerOnly'=>true),
			array('totalvenda', 'length', 'max'=>10),
			array('status', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codvenda, matricula, data, datapreventrega, totalvenda, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codvenda' => 'Codvenda',
			'matricula' => 'Matricula',
			'data' => 'Data',
			'datapreventrega' => 'Datapreventrega',
			'totalvenda' => 'Totalvenda',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('codvenda',$this->codvenda);
		$criteria->compare('matricula',$this->matricula);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('datapreventrega',$this->datapreventrega,true);
		$criteria->compare('totalvenda',$this->totalvenda,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Venda the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
