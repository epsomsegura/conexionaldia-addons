<?php

namespace Epsomsegura\ConexionaldiaAddons\Features\Shared\Infrastructure;

use ReflectionClass;
use ReflectionProperty;

/***
 * 
 * TODO: 
 * - whereRaw
 * - createOrUpdate method
 * - firstOrCreate method
 * - updateOrCreate method
 * - joins
 */

class DomainModel
{
    protected $field_id;
    protected $model;
    protected $schema;
    protected $statement;
    private $selectColumns = [];
    /**
     * Summary of __construct
     * @param mixed $model
     */
    public function __construct($model)
    {
        global $wpdb;
        $this->model = $model;
        $this->field_id = ((isset($this->model->field_id)) ? $this->model->field_id : 'id');
        $this->schema = $wpdb->prefix . $this->model->table;
        $this->statement = "SELECT {$this->schema}.* FROM {$this->schema} ";
    }
    /**
     * Summary of count
     * 
     * Get the number of elements from statement
     * 
     * @return int
     */
    public function count()
    {
        global $wpdb;
        $pattern = '/SELECT\s+.*?\s+FROM/i';
        $replacement = 'SELECT COUNT(*) FROM';
        $statement = preg_replace($pattern, $replacement, $this->statement);
        return $wpdb->get_var("{$statement}");
    }
    /**
     * Summary of create
     * 
     * Apply insert statement to selected schema using given array of fields-values
     * 
     * @param mixed $fields
     * @return object
     */
    public function create($fields)
    {
        global $wpdb;
        $wpdb->insert($this->schema, $fields);
        return $this->find($wpdb->insert_id);
    }
    /**
     * Summary of exists
     * 
     * Statement to verify if resultset exists or not
     * 
     * @return bool
     */
    public function delete($id)
    {
        global $wpdb;
        return $wpdb->delete($this->schema, array('id' => $id));
    }
    /**
     * Summary of exists
     * 
     * Statement to verify if resultset exists or not
     * 
     * @return bool
     */
    public function exists()
    {
        return ($this->count() > 0);
    }
    /**
     * Summary of find
     * 
     * Return the specific model founded by identifier column
     * 
     * @param mixed $id
     * @return object
     */
    public function find($id)
    {
        global $wpdb;
        $this->statement = "{$this->statement}";
        $this->where($this->field_id, "=", $id);
        return $this->set_model_values($wpdb->get_row($this->statement, OBJECT));
    }
    /**
     * Summary of first
     * 
     * Return the first element from statement
     * 
     * @return object
     */
    public function first()
    {
        global $wpdb;
        $this->statement = "{$this->statement} LIMIT 1";
        return $this->set_model_values($wpdb->get_row($this->statement, ARRAY_A));
    }
    /**
     * Summary of get
     * 
     * Return all elements from statement
     * 
     * @return object[]
     */
    public function get()
    {
        global $wpdb;
        $resultset = $wpdb->get_results($this->statement, ARRAY_A);
        $collection = [];
        foreach ($resultset as $row) {
            $collection[] = $this->set_model_values($row);
        }
        return $collection;
    }
    /**
     * 
     */
    public function orderBy($field, $direction = 'ASC')
    {
        $this->statement = $this->statement . " order by {$field} {$direction}";
        return $this;
    }
    /**
     * Summary of orWhere
     * 
     * Add to query WHERE or OR conjunction  given field has condition with given value
     * 
     * @param mixed $field
     * @param mixed $condition
     * @param mixed $value
     * @return static
     */
    public function orWhere($field, $condition, $value)
    {
        $this->statement .= "OR {$field} {$condition} {$value} ";
        return $this;
    }
    /**
     * Summary of paginate
     * 
     * Get paginated array from model: 
     * 
     * `page` parameter is used to show the specific page 
     * 
     * `perPage` parameter is used to limit the number of elements per page 
     * 
     * Returned array get this values: 
     * 
     * `items` key is used to show all paginated elements 
     * 
     * `total` key is used to show total paginated elements 
     * 
     * `pages` key is used to show total pages 
     * 
     * `current_page` key is used to show current page 
     * 
     * `per_page` key is used to show number of elements per page 
     * 
     * @param mixed $params
     * @return array
     */
    public function paginate($params = [])
    {
        global $wpdb;
        $total = $this->count();
        $page = (array_key_exists('page', $params) ? $params['page'] : 1);
        $perPage = (array_key_exists('perPage', $params) ? $params['perPage'] : 10);
        $pages = ceil($total / $perPage);
        $offset = (($page - 1) * $perPage);
        $this->statement = $this->statement . " LIMIT {$offset}, {$perPage}";
        $items = [];
        foreach ($wpdb->get_results($this->statement, ARRAY_A) as $result) {
            $items[] = $this->set_model_values($result);
        }
        return [
            "items" => $items,
            "total" => (int)$total,
            "pages" => (int)$pages,
            "current_page" => (int)$page,
            "per_page" => (int)$perPage
        ];
    }
    /**
     * Summary of pluck
     * 
     * Get an array of values from given field
     * 
     * @param mixed $field
     * @return array
     */
    public function pluck($field)
    {
        $plucked = [];
        foreach ($this->select([$field])->get() as $row) {
            $plucked[] = $row->$field;
        }
        return $plucked;
    }
    /**
     * Summary of replace
     * 
     * Execute replace statement on model
     * 
     * @param mixed $fields
     * @return object
     */
    public function replace($fields)
    {
        global $wpdb;
        $wpdb->replace($this->schema, $fields);
        return $this->find($wpdb->insert_id);
    }
    /**
     * Summary of save
     * 
     * Execute insert or replace statement on model
     * 
     * @return object
     */
    public function save()
    {
        $fields = $this->get_model_values();
        return (is_null($fields['id']) || $fields['id'] == "") ? $this->create($fields) : $this->replace($fields);
    }
    /**
     * Summary of select
     * 
     * Prepare return fields to statement
     * 
     * @param mixed $fields
     * @return static
     */
    public function select($fields)
    {
        $this->selectColumns = implode(", ", $fields);
        $this->statement = str_replace("{$this->schema}.*", $this->selectColumns, $this->statement);
        return $this;
    }
    /**
     * Summary of tableAlias
     * 
     * Assign an alias to schema
     * 
     * @param mixed $alias
     * @return static
     */
    public function tableAlias($alias)
    {
        $alias = "FROM {$this->schema} as {$alias}";
        $this->statement = str_replace("FROM {$this->schema}", $alias, $this->statement);
        return $this;
    }
    /**
     * Summary of update
     * 
     * Apply update statement to selected schema using given array of fields-values
     * 
     * @param mixed $fields
     * @return static
     */
    public function update($fields)
    {
        global $wpdb;
        $fieldIds = $this->pluck($this->field_id);
        $ids = implode(", ", $fieldIds);
        $settedValues = "";
        foreach ($fields as $key => $field) {
            $settedValues .= "{$key} = '{$field}', ";
        }
        $settedValues = substr($settedValues, 0, strlen($settedValues) - 2);
        $updateQuery = "UPDATE {$this->schema} SET {$settedValues} WHERE {$this->field_id} IN ({$ids})";
        if (!empty($fieldIds)) {
            $wpdb->query($wpdb->prepare($updateQuery));
        }
        return $this;
    }
    /**
     * Summary of where
     * 
     * Add to query WHERE or AND conjunction  given field has condition with given value
     * 
     * @param mixed $field
     * @param mixed $condition
     * @param mixed $value
     * @return static
     */
    public function where($field, $condition, $value)
    {
        $value = (string)$value;
        $whereString = (string_contains($this->statement, "WHERE ") ? "AND" : "WHERE");
        $this->statement .= "{$whereString} {$field} {$condition} {$value} ";
        return $this;
    }
    /**
     * Summary of whereFalse
     * 
     * Add to query WHERE given field is FALSE value
     * 
     * @param mixed $field
     * @return static
     */
    public function whereFalse($field)
    {
        $whereString = (string_contains($this->statement, "WHERE ") ? "AND" : "WHERE");
        $this->statement .= "{$whereString} {$field} = 0 ";
        return $this;
    }
    /**
     * Summary of whereIn
     * 
     * Add to query WHERE given field has values from array of values
     * 
     * @param mixed $field
     * @param mixed $values
     * @return static
     */
    public function whereIn($field, $values)
    {
        $values = implode(', ', $values);
        $whereString = (string_contains($this->statement, "WHERE ") ? "AND" : "WHERE");
        $this->statement .= "{$whereString} {$field} IN ({$values}) ";
        return $this;
    }
    /**
     * Summary of whereNull
     * 
     * Add to query WHERE given field is null
     * 
     * @param mixed $field
     * @return static
     */
    public function whereNull($field)
    {
        $whereString = (string_contains($this->statement, "WHERE ") ? "AND" : "WHERE");
        $this->statement .= "{$whereString} {$field} IS NULL ";
        return $this;
    }
    /**
     * Summary of whereNotNull
     * 
     * Add to query WHERE given field is not null
     * 
     * @param mixed $field
     * @return static
     */
    public function whereNotNull($field)
    {
        $whereString = (string_contains($this->statement, "WHERE ") ? "AND" : "WHERE");
        $this->statement .= "{$whereString} {$field} IS NOT NULL ";
        return $this;
    }
    /**
     * Summary of whereTrue
     * 
     * Add to query WHERE given field has TRUE value
     * 
     * @param mixed $field
     * @return static
     */
    public function whereTrue($field)
    {
        $whereString = (string_contains($this->statement, "WHERE ") ? "AND" : "WHERE");
        $this->statement .= "{$whereString} {$field} = 1 ";
        return $this;
    }

    #region PRIVATE METHODS
    /**
     * Summary of get_model_values
     * @param mixed $row
     * @return array
     */
    private function get_model_values()
    {
        $fields = [];
        $properties = (new ReflectionClass($this->model))->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $property) {
            if (!in_array($property->getName(), ["field_id", "table"])) {
                $field = $property->getName();
                $fields[$field] = $this->$field;
            }
        }
        return $fields;
    }
    /**
     * Summary of set_model_values
     * @param mixed $row
     * @return object
     */
    private function set_model_values($row)
    {
        $model = (count((array)$this->selectColumns) > 0 ? (object)[] : new $this->model);
        foreach ($row as $field => $value) {
            if (property_exists($this->model, $field)) {
                $model->$field = $value;
            }
        }
        return $model;
    }
    #endregion
}
