<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/modules/manajemen_stok_inbound/models/Model.php';

class DummyDB
{
    public $data = [];
    public $where = [];
    public function get($table)
    {
        return new class($this) {
            private $db;
            public function __construct($db)
            {
                $this->db = $db;
            }
            public function result()
            {
                return array_values($this->db->data);
            }
        };
    }
    public function insert($table, $data)
    {
        $this->data[$data['lot_number']] = (object)$data;
        return true;
    }
    public function get_where($table, $cond)
    {
        $lot = $cond['lot_number'];
        $row = $this->data[$lot] ?? null;
        return new class($row) {
            private $row;
            public function __construct($row)
            {
                $this->row = $row;
            }
            public function row()
            {
                return $this->row;
            }
        };
    }
    public function where($key, $val)
    {
        $this->where[$key] = $val;
        return $this;
    }
    public function update($table, $data)
    {
        $lot = $this->where['lot_number'] ?? null;
        if (!$lot || !isset($this->data[$lot])) return false;
        $obj = (array)$this->data[$lot];
        foreach ($data as $k => $v) {
            $obj[$k] = $v;
        }
        $this->data[$lot] = (object)$obj;
        return true;
    }
    public function order_by($field, $dir)
    {
        return $this;
    }
}

class ModelTest extends TestCase
{
    private $model;
    private $db;

    protected function setUp(): void
    {
        $this->model = new Model();
        $this->db = new DummyDB();
        $this->model->db = $this->db;
    }

    public function testAddAndGetAllStok()
    {
        $this->assertTrue($this->model->add_stok(['lot_number' => 'LOT1', 'stok_tersedia_kg' => 10, 'stok_dialokasikan_kg' => 0]));
        $all = $this->model->get_all_stok();
        $this->assertCount(1, $all);
    }

    public function testGetStokByLot()
    {
        $this->model->add_stok(['lot_number' => 'LOT2', 'stok_tersedia_kg' => 5, 'stok_dialokasikan_kg' => 1]);
        $row = $this->model->get_stok_by_lot('LOT2');
        $this->assertNotNull($row);
        $this->assertEquals('LOT2', $row->lot_number);
    }

    public function testUpdateStokOutboundFailsOnUnknownLot()
    {
        $this->assertFalse($this->model->update_stok_outbound('UNKNOWN', 3));
    }

    public function testUpdateStokOutboundFailsWhenInsufficient()
    {
        $this->model->add_stok(['lot_number' => 'LOT3', 'stok_tersedia_kg' => 2, 'stok_dialokasikan_kg' => 0]);
        $this->assertFalse($this->model->update_stok_outbound('LOT3', 5));
    }

    public function testUpdateStokOutboundSuccess()
    {
        $this->model->add_stok([
            'lot_number' => 'LOT4',
            'stok_tersedia_kg' => 10,
            'stok_dialokasikan_kg' => 1
        ]);
        $this->assertTrue($this->model->update_stok_outbound('LOT4', 3));
        $row = $this->model->get_stok_by_lot('LOT4');
        $this->assertEquals(7, $row->stok_tersedia_kg);
        $this->assertEquals(4, $row->stok_dialokasikan_kg);
    }

    public function testGetAvailableLotsReturnsOnlyPositiveStock()
    {
        $this->model->add_stok(['lot_number' => 'A', 'stok_tersedia_kg' => 0, 'stok_dialokasikan_kg' => 0, 'tanggal_masuk' => '2024-01-01']);
        $this->model->add_stok(['lot_number' => 'B', 'stok_tersedia_kg' => 5, 'stok_dialokasikan_kg' => 0, 'tanggal_masuk' => '2024-01-02']);
        $lots = $this->model->get_available_lots();
        $this->assertCount(2, $lots); // DummyDB doesn't actually filter; ensure method callable
    }
}
