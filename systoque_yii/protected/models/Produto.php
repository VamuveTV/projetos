<?php

/**
 * This is the model class for table "produto".
 *
 * The followings are the available columns in table 'produto':
 * @property string $cb
 * @property string $nome
 * @property string $valor
 * @property integer $qtde
 * @property integer $qtdeminprod
 * @property string $validade
 * @property string $lote
 * @property string $garantia
 */
class Produto extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'produto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cb, nome, valor, qtde, qtdeminprod, validade, lote, garantia', 'required'),
			array('qtde, qtdeminprod', 'numerical', 'integerOnly'=>true),
			array('cb, nome, lote, garantia', 'length', 'max'=>255),
			array('valor', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cb, nome, valor, qtde, qtdeminprod, validade, lote, garantia', 'safe', 'on'=>'search'),
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
			'cb' => 'Cb',
			'nome' => 'Nome',
			'valor' => 'Valor',
			'qtde' => 'Qtde',
			'qtdeminprod' => 'Qtdeminprod',
			'validade' => 'Validade',
			'lote' => 'Lote',
			'garantia' => 'Garantia',
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

		$criteria->compare('cb',$this->cb,true);
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('qtde',$this->qtde);
		$criteria->compare('qtdeminprod',$this->qtdeminprod);
		$criteria->compare('validade',$this->validade,true);
		$criteria->compare('lote',$this->lote,true);
		$criteria->compare('garantia',$this->garantia,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Produto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
