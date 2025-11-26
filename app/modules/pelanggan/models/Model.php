<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model extends CI_Model
{

    var $table = 'pelanggan';
    var $idtable = 'id';
    var $column_order = array(
        'id',
        'nama',
        'jenis_kelamin',
        'telepon',
        'alamat',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        's_jenis',
    );
    var $column_search = array(
        'id',
        'nama',
    );
    var $order = array('id' => 'ASC');

    /* Server Side Data */
    /* Modified by : Maulana.code@gmail.com */
    private function _get_datatables_query()
    {
        $this->db->from($this->table);
        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    /* end server side  */

    function getid($id)
    {
        $this->db->where($this->idtable, $id);
        return $this->db->get($this->table)->result();
    }

    function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function edit($data)
    {
        $this->db->where($this->idtable, $this->input->post($this->idtable));
        return $this->db->update($this->table, $data);
    }

    function delete($id)
    {
        $this->db->where($this->idtable, $id);
        return $this->db->delete($this->table);
    }

    function provinsi()
    {


        $this->db->order_by('name', 'ASC');
        $provinces = $this->db->get('provinces');


        return $provinces->result_array();
    }


    function kabupaten($provId)
    {

        $kabupaten = "<option value='0'>--pilih--</pilih>";

        $this->db->order_by('name', 'ASC');
        $kab = $this->db->get_where('regencies', array('province_id' => $provId));

        foreach ($kab->result_array() as $data) {
            $kabupaten .= "<option value='$data[name]'>$data[name]</option>";
        }

        return $kabupaten;
    }

    function kecamatan($kabId)
    {
        $kecamatan = "<option value='0'>--pilih--</pilih>";

        $this->db->order_by('name', 'ASC');
        $kec = $this->db->get_where('districts', array('regency_id' => $kabId));

        foreach ($kec->result_array() as $data) {
            $kecamatan .= "<option value='$data[id]'>$data[name]</option>";
        }

        return $kecamatan;
    }

    function kelurahan($kecId)
    {
        $kelurahan = "<option value='0'>--pilih--</pilih>";

        $this->db->order_by('name', 'ASC');
        $kel = $this->db->get_where('villages', array('district_id' => $kecId));

        foreach ($kel->result_array() as $data) {
            $kelurahan .= "<option value='$data[id]'>$data[name]</option>";
        }

        return $kelurahan;
    }
}
