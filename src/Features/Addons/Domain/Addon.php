<?php

namespace Epsomsegura\ConexionaldiaAddons\Features\Addons\Domain;

use Epsomsegura\ConexionaldiaAddons\Features\Shared\Infrastructure\DomainModel;

class Addon extends DomainModel
{
    protected $table = "conexionaldia_addons";
    protected $field_id = "id";
    public $id;
    public $start_date;
    public $end_date;
    public $status;
    public $payload;
    public $created_at;
    public $updated_at;

    public function __construct(
        $id = null,
        $start_date = null,
        $end_date = null,
        $status = TRUE,
        $payload = null,
        $created_at = null,
        $updated_at = null
    ) {
        parent::__construct($this);
        $this->id = $id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->status = $status;
        $this->payload = $payload;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public function create_schema()
    {
        global $wpdb;
        $query = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}conexionaldia_addons (
            `id` INT NOT NULL AUTO_INCREMENT,
            `start_date` TIMESTAMP NULL,
            `end_date` TIMESTAMP NULL,
            `status` TINYINT(1) DEFAULT 1,
            `payload` LONGTEXT,
            `created_at` TIMESTAMP NULL,
            `updated_at` TIMESTAMP NULL,
            PRIMARY KEY(`id`))";

        $wpdb->query($query);
    }

    public function inactivate_all()
    {
        $query1 = (new self)->whereNull('updated_at')->update(["updated_at" => date('Y-m-d H:i:s')]);
        $query2 = (new self)->whereTrue('status')->update(["status" => 0]);
    }
}
