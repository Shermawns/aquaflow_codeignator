<?php

    class LoginCadastro_model extends CI_Model{
        public function get_usuarios($login){
            $this->db->where('usuario', $login);
            return $this->db->get('tabela_usuarios')->row();
        }
    }
?>