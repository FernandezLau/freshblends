<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SaleItems Model
 *
 * @property \App\Model\Table\SalesTable&\Cake\ORM\Association\BelongsTo $Sales
 * @property \App\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsTo $Products
 *
 * @method \App\Model\Entity\SaleItem newEmptyEntity()
 * @method \App\Model\Entity\SaleItem newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\SaleItem> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SaleItem get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\SaleItem findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\SaleItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\SaleItem> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SaleItem|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\SaleItem saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\SaleItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SaleItem>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SaleItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SaleItem> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SaleItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SaleItem>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SaleItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SaleItem> deleteManyOrFail(iterable $entities, array $options = [])
 */
class SaleItemsTable extends Table
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

        $this->setTable('sale_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Sales', [
            'foreignKey' => 'sale_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
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
            ->integer('sale_id')
            ->notEmptyString('sale_id');

        $validator
            ->integer('product_id')
            ->notEmptyString('product_id');

        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmptyString('quantity');

        $validator
            ->decimal('price')
            ->requirePresence('price', 'create')
            ->notEmptyString('price');

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
        $rules->add($rules->existsIn(['sale_id'], 'Sales'), ['errorField' => 'sale_id']);
        $rules->add($rules->existsIn(['product_id'], 'Products'), ['errorField' => 'product_id']);

        return $rules;
    }
}
