<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mtamu extends CI_Model {

  //menampilkan seluruh data pada table tb_tamu
  public function view(){
    return $this->db->get('tb_tamu')->result();
  }

  //menampilkan waktu
  public function jml_tamu(){
    return $this->db->query('SELECT date(waktu) AS wkt, COUNT(waktu) AS jumlah FROM `tb_tamu` GROUP BY date(waktu)')->result();
  }
  
  //melakukan validasi data sebelum dilakukan insert dan update
  public function validation($mode){
    $this->load->library('form_validation');
    if($mode == "save"){
      $this->form_validation->set_rules('input_nama', 'Nama', 'required|max_length[50]');
      $this->form_validation->set_rules('input_jeniskelamin', 'Jenis Kelamin', 'required');
      $this->form_validation->set_rules('input_alamat', 'Alamat', 'required');
      $this->form_validation->set_rules('input_no', 'no_hp', 'required|max_length[13]');
    }else if($mode == "update"){
      $this->form_validation->set_rules('edit_nama', 'Nama', 'required|max_length[50]');
      $this->form_validation->set_rules('edit_jeniskelamin', 'Jenis Kelamin', 'required');
      $this->form_validation->set_rules('edit_alamat', 'Alamat', 'required');
      $this->form_validation->set_rules('edit_nomor', 'no_hp', 'required|max_length[13]');
    }
    if($this->form_validation->run()){return true;}
    else{return false;}
  }

  //menampung data dalam array dan menginsert ke dalam table
  public function save(){
    $data = array(
      "nama" => $this->input->post('input_nama'),
      "jenis_kelamin" => $this->input->post('input_jeniskelamin'),
      "alamat" => $this->input->post('input_alamat'),
      "No_Hp" => $this->input->post('input_no'),
      "waktu" => $this->input->post('input_waktu')
    );
    $this->db->insert('tb_tamu', $data);
  }

  //mengupdate data dalam array dan mengubah data pada table
  public function edit($id){
    $data = array(
      "nama" => $this->input->post('edit_nama'),
      "jenis_kelamin" => $this->input->post('edit_jeniskelamin'),
      "alamat" => $this->input->post('edit_alamat'),
      "No_Hp" => $this->input->post('edit_nomor'),
      "waktu" => $this->input->post('edit_waktu')
    );
    $this->db->where('id_tamu', $id);
    $this->db->update('tb_tamu', $data);
  }

  //menghapus data pada table
  public function delete($id){
    $this->db->where('id_tamu', $id);
    $this->db->delete('tb_tamu');
  }
}