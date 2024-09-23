<?php
    /**
     * Interface de modelo DAO para dados da tabela 'Usuario'
     * @author Eduardo Pereira Moreira - eduardopereiramoreira1995+code@gmail.com
     */
    interface IUsuarioDAO {
        /**
         * Método que recebe 'login' e 'senha', procura na tabela 'Usuario' do banco um login correspondente e compara a senha com a registrada.
         * @param string $login - Login para pesquisa
         * @param string $senha - Senha exposta para comparação
         * @return UsuarioVO|bool|null - Retorna um objeto 'UsuarioVO' se login e senha forem corretos, 'false' se o login estiver correto mas a senha não estiver e 'null' se ocorrer algum erro durante a execução do script
         */
        public function login(string $login, string $senha) : UsuarioVO | bool | null;

        /**
         * Método que recebe um objeto 'UsuarioVO' e o registra no banco de dados
         * @param UsuarioVO $uVO
         * @return bool
         */
        public function insert(UsuarioVO $uVO) : bool;

        /**
         * Método que pesquisa e retorna todas as linhas na tabela 'Usuario' do banco de dados como um array.
         * @return void
         */
        public function selectAll() : ?array;

        /**
         * Método que recebe um objeto 'UsuarioVO', pesquisa na tabela 'Usuario' do banco de dados um registro que contenha todos os dados inicializados dentro do objeto e os retorna em um array.
         * @param UsuarioVO $uVO
         * @return void
         */
        public function selectWhere(UsuarioVO $uVO) : ?array;

        /**
         * Método que recebe um objeto 'UsuarioVO' e atualiza seus dados em uma linha da tabela 'Usuario' no banco que contenha um ID correspondente.
         * @param UsuarioVO $uVO
         * @return bool
         */
        public function update(UsuarioVO $uVO) : bool;

        /**
         * Método que recebe um ID de um registro na tabela 'Usuario' e o exclui do banco de dados.
         * @param int $id
         * @return bool
         */
        public function delete(int $id) : bool;
    }
?>