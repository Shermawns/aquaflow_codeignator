<?php

    class Usuarios_model extends CI_Model{


        public function get_usuarios($login){
            $this->db->where('usuario', $login);
            return $this->db->get('tabela_usuarios')->row();
        }

        public function list_all_users(){
            $query = $this->db->get('tabela_usuarios');
            return $query->result();
        }

        public function insert_user($dados){
            $query = $this->db->insert('tabela_usuarios', $dados);
            return $query;
        }

        public function delete_user($id){
            $this->db->where('id', $id);
            return $this->db->delete('tabela_usuarios');
        }

        public function edit_user($id, $dados){
            $this->db->where('id', $id);
            return $this->db->update('tabela_usuarios', $dados);
        }
    }

    


?>