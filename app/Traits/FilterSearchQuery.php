<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

trait FilterSearchQuery
{
    protected $search_fields = [];
    protected $search_exactly_fields = [];
    protected $sort_fields = [];

    /**
     * @param Builder $query
     * @param $filters
     */
    protected function filterQuery(&$query, $filters = [])
    {
        if (is_string($filters)) {
            $filters = json_decode($filters, true);
        }
        if (is_object($filters)) {
            $filters = (array)$filters;
            if ($filters['rules'] &&
                is_array($filters['rules'])) {
                foreach ($filters['rules'] as $i => $rule) {
                    if (is_object($rule)) {
                        $filters['rules'][$i] = (array)$rule;
                    }
                }
            }
        }

        if (empty($filters)) {
            return;
        }

        $query->where(function (Builder $buider) use ($filters) {
            $this->makeRulesQuery($buider, $filters);
        });
    }

    protected function makeRulesQuery(&$query, array $rule, string $whereMatch = 'where')
    {
        $modelQuery = $query->getModel();
        $tableQuery = $modelQuery->getTable();
        $filterRelationAttributes = $query->getModel()->filterRelationAttributes;
        $tableRelationship = null;

        if (
            isset($rule['match']) &&
            isset($rule['rules'])
        ) {

            $whereMatchChild = $rule['match'] == 'and' ? 'where' : 'orWhere';

            if ($filterRelationAttributes) {
                foreach ($rule['rules'] as $j => $childRule) {
                    $relationship = '';
                    $column = '';
                    $relationAttribute = null;
                    if (collect($filterRelationAttributes)->keys()->search($childRule['field']) !== false) {
                        $relationAttribute = $filterRelationAttributes[$childRule['field']];
                        if (is_array($relationAttribute)) {
                            $newSubRules = [
                                'match' => 'or',
                                'rules' => []
                            ];
                            foreach ($relationAttribute as $attr) {
                                $newSubRules['rules'][] = [
                                    'field' => $attr,
                                    'operator' => $childRule['operator'],
                                    'value' => $childRule['value']
                                ];
                            }
                            $childRule = $newSubRules;
                        } else {
                            if (strpos($relationAttribute, '.') !== false) {
                                list($relationship, $column) = explode('.', $relationAttribute);
                                $modelRelationship = $modelQuery->{$relationship}()->getModel();
                                $tableRelationship = $modelRelationship ? $modelRelationship->getTable() : null;
                            } else {
                                $rule['rules'][$j]['field'] = $relationAttribute;
                            }
                        }
                    }

                    if (
                        !empty($relationship) &&
                        !empty($column)
                    ) {
                        $query->{$whereMatchChild . 'Has'}($relationship, function ($query) use ($childRule, $tableRelationship, $column) {
                            $childRule['field'] = $tableRelationship ? ($tableRelationship . '.' . $column) : $column;
                            $this->makeRulesQuery($query, $childRule);
                        });
                    } else if ($relationAttribute && is_array($relationAttribute)) {
                        $query->{$whereMatch}(function (Builder $query) use ($childRule, $whereMatchChild) {
                            $this->makeRulesQuery($query, $childRule, $whereMatchChild);
                        });
                    } else {
                        $childRule['field'] = $tableQuery . '.' . $childRule['field'];
                        $this->makeRulesQuery($query, $childRule, $whereMatchChild);
                    }
                }
            } else {
                $query->{$whereMatch}(function (Builder $query) use ($rule, $whereMatchChild) {
                    foreach ($rule['rules'] as $childRule) {
                        $this->makeRulesQuery($query, $childRule, $whereMatchChild);
                    }
                });
            }
        } else {
            if ($filterRelationAttributes) {
                foreach ($filterRelationAttributes as $key => $item) {
                    if ($key === str_replace($tableQuery . '.', '', $rule['field'])) {
                        $relationshipAttribute = $item;
                        if (strpos($relationshipAttribute, '.') !== false) {
                            list($relationship, $column) = explode('.', $relationshipAttribute);
                            $modelRelationship = $modelQuery->{$relationship}()->getModel();
                            $tableRelationship = $modelRelationship ? $modelRelationship->getTable() : null;
                        } else {
                            $rule['field'] = $tableQuery . '.' . $relationshipAttribute;
                        }
                        break;
                    }
                }
            }


            if (
                isset($relationship) &&
                isset($column)
            ) {
                $query->{$whereMatch . 'Has'}($relationship, function ($query) use ($rule, $tableRelationship, $column) {
                    $rule['field'] = $column ? ($tableRelationship . '.' . $column) : $column;
                    $this->makeRulesQuery($query, $rule);
                });
            } else {
                $query->{$whereMatch}(...array_values($rule));
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function searchQuery(&$query, $term)
    {
        $modelQuery = $query->getModel();
        $tableQuery = $modelQuery->getTable();
        $filterRelationAttributes = $query->getModel()->filterRelationAttributes;

        if ($term && (!empty($this->search_fields) || !empty($this->search_exactly_fields))) {
            $query->where(function (Builder $query) use ($term, $filterRelationAttributes, $modelQuery) {
                foreach ($this->search_fields as $search_field) {
                    if (collect($filterRelationAttributes)->keys()->search($search_field) !== false) {
                        $relationAttribute = $filterRelationAttributes[$search_field];
                        if (strpos($relationAttribute, '.') !== false) {
                            list($relationship, $relationship_field) = explode('.', $relationAttribute);
                            $modelRelationship = $modelQuery->{$relationship}()->getModel();
                            $tableRelationship = $modelRelationship ? $modelRelationship->getTable() : null;

                            $query->{'orWhereHas'}($relationship, function ($q) use ($term, $tableRelationship, $relationship_field) {
                                $q->where($tableRelationship . '.' . $relationship_field, 'LIKE', "%$term%");
                            });
                        } else {
                            $query->orWhere($relationAttribute, 'LIKE', "%$term%");
                        }
                    } else {
                        $query->orWhere($search_field, 'LIKE', "%$term%");
                    }
                }
                foreach ($this->search_exactly_fields as $search_exactly_fields) {
                    $query->orWhere($search_exactly_fields, '=', $term);
                }
            });
        }
    }

    /**
     * @inheritDoc
     */
    public function sortQuery(&$query, $order_by, $order)
    {
        $order_by = isset($order_by) ? $order_by : null;
        $order = isset($order) ? strtolower($order) : 'asc';

        if ($order_by && $order && !empty($this->sort_fields)) {
            if (collect($this->sort_fields)->contains($order_by)) {
                $this->buildSortQuery($query, $query->getModel(), $order_by, $order);
            }
        }

        // default : created_at, desc
        $model = $query->getModel();
        if ($model) {
            $sortDefaultAttributes = $model->sortDefaultAttributes;
            if ($sortDefaultAttributes && count($sortDefaultAttributes) > 0) {
                foreach ($sortDefaultAttributes as $orderBy => $order)
                    $query->orderBy($orderBy, $order);
            }
        }
    }

    protected function buildSortQuery(&$query, $model, $order_by, $order)
    {
        $sortRelationAttributes = isset($model->sortRelationAttributes) ? $model->sortRelationAttributes : [];

        if (collect($sortRelationAttributes)->keys()->contains($order_by)) {
            if (strpos($sortRelationAttributes[$order_by], '.') !== false) {
                list($relationship, $relationColumn) = explode('.', $sortRelationAttributes[$order_by]);
                $relation = $model->{$relationship}();

                $modelRelationship = $relation->getModel();
                $tableRelationship = $modelRelationship ? $modelRelationship->getTable() : null;

                $join = 'join';
                $one = $relation->getQualifiedParentKeyName();
                if ($relation instanceof HasOne) {
                    // $two = $tableRelationship . '.' . (Str::singular($model->getTable()) . '_id');
                    $two = $tableRelationship . '.' . $relation->getForeignKeyName();

                    $join = 'leftJoin';
                } elseif ($relation instanceof BelongsTo) {
                    $one = $model->getTable() . '.' . $relation->getForeignKeyName();
                    $two = $tableRelationship . '.id';
                } else {
                    $two = $tableRelationship . '.' . (Str::singular($model->getTable()) . '_id');
                    // $two = $relation->getForeignKey();
                    $join = 'leftJoin';
                }

                $query->{$join}($tableRelationship, $one, '=', $two);

                // group by
                $query->groupBy($query->getModel()->getTable() . '.id');

                $this->buildSortQuery($query, $modelRelationship, $relationColumn, $order);
            } else {
                $order_by = $sortRelationAttributes[$order_by];
                if (Schema::connection('mysql')->hasColumn($model->getTable(), $order_by)) {
                    $query
                        ->select($query->getModel()->getTable() . '.*')
                        ->selectRaw($model->getTable() . '.' . $order_by . ' as sortable_field')
                        ->orderBy('sortable_field', $order);
                }
            }
        } else {
            if (Schema::connection('mysql')->hasColumn($model->getTable(), $order_by)) {
                $query
                    ->select($query->getModel()->getTable() . '.*')
                    ->selectRaw($model->getTable() . '.' . $order_by . ' as sortable_field')
                    ->orderBy('sortable_field', $order);
            }
        }
    }
}
