<?php

    interface IUsuarioDAO {
        public function login(string $login, string $senha) : UsuarioVO;
        public function insert(UsuarioVO $uVO) : void;
        public function selectAll() : UsuarioVO;
        public function selectWhere(UsuarioVO $uVO) : UsuarioVO;
        public function update(UsuarioVO $uVO) : UsuarioVO;
        public function delete(UsuarioVO $uVO) : UsuarioVO;
    }
?>