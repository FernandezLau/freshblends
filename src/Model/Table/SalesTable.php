<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sales Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\SaleItemsTable&\Cake\ORM\Association\HasMany $SaleItems
 *
 * @method \App\Model\Entity\Sale newEmptyEntity()
 * @method \App\Model\Entity\Sale newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Sale> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Sale get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Sale findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Sale patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Sale> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Sale|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Sale saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Sale>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Sale>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Sale>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Sale> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Sale>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Sale>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Sale>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Sale> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SalesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('sales');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('SaleItems', [
            'foreignKey' => 'sale_id',
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
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->decimal('total')
            ->requirePresence('total', 'create')
            ->notEmptyString('total');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
