<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BirthdayItems Model
 *
 * @property \App\Model\Table\BirthdaysTable&\Cake\ORM\Association\BelongsTo $Birthdays
 *
 * @method \App\Model\Entity\BirthdayItem newEmptyEntity()
 * @method \App\Model\Entity\BirthdayItem newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\BirthdayItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BirthdayItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\BirthdayItem findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\BirthdayItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BirthdayItem[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BirthdayItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BirthdayItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BirthdayItem[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\BirthdayItem[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\BirthdayItem[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\BirthdayItem[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BirthdayItemsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('birthday_items');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Birthdays', [
            'foreignKey' => 'birthday_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->integer('units')
            ->requirePresence('units', 'create')
            ->notEmptyString('units');

        $validator
            ->integer('birthday_id')
            ->notEmptyString('birthday_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('birthday_id', 'Birthdays'), ['errorField' => 'birthday_id']);

        return $rules;
    }
}
