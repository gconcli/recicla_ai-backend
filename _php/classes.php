<?php
    /**
     * Um objeto que contém os dados necessários para todas as tabelas no banco de dados
     * Estes dados são:
     * - ID (INT)
     * - Data de Criação (DATE)
     * - Ativo (TINYINT(1))
     */
    abstract class ObjetoVO {
        // Atributos do objeto
        private $id;
        private $dataCriacao;
        private $ativo;

        // Construtor
        protected function __construct() {
            $this->id = null;
            $this->dataCriacao = null;
            $this->ativo = null;
        }

        // Getter e Setter para 'id'
        public function getId() : ?int {return $this->id;}
        public function setId(int $id) : void {$this->id = $id;}

        // Getter e Setter para 'dataCriacao'
        public function getDataCriacao() : ?string {return $this->dataCriacao;}
        public function setDataCriacao(String $dataCriacao) : void {$this->dataCriacao = $dataCriacao;}

        // Getter e Setter para 'ativo'
        public function isAtivo() : ?bool {return $this->ativo;}
        public function setAtivo(bool $ativo) : void {$this->ativo = $ativo;}
    }

    /**
     * Um objeto que contém os dados necessários para a tabela 'Usuario' no banco de dados
     * Estes dados são os dados de "ObjetoVO", mais:
     * - ID da Imagem do Usuário (INT)
     * - ID do Tipo de Usuário (INT)
     * - Login VARCHAR(50)
     * - Senha CHAR(60)
     * - Nome VARCHAR(50)
     * - E-mail VARCHAR(70)
     * - Data de Aniversário (DATE)
     * - Descrição VARCHAR(500)
     * @extends ObjetoVO
     */
    class UsuarioVO extends ObjetoVO {
        // Atributos finais estáticos da classe
        private static $nomeTabela = "Usuario";
        private static $nomesColunasTabela = [
            "idUsuario",

            "idImagemUsuario",
            "idTipoUsuario",
            "loginUsuario",
            "senhaUsuario",
            "nomeUsuario",
            "emailUsuario",
            "dataAniversarioUsuario",
            "descricaoUsuario",

            "dataCriacaoUsuario",
            "usuarioAtivo"
        ];

        // Atributos do objeto
        private $idImagem;
        private $idTipoUsuario;
        private $login;
        private $senha;
        private $nome;
        private $email;
        private $dataAniversario;
        private $descricao;

        // Construtor
        public function __construct() {
            parent::__construct();
            $this->idImagem = null;
            $this->idTipoUsuario = null;
            $this->login = null;
            $this->senha = null;
            $this->nome = null;
            $this->email = null;
            $this->dataAniversario = null;
            $this->descricao = null;
        }

        // Getter estático para 'nomeTabela'
        public static function getNomeTabela() {return self::$nomeTabela;}

        // Getter estático para 'nomesColunasTabela'
        public static function getNomesColunasTabela() {return self::$nomesColunasTabela;}

        // Getter e Setter para 'idImagem'
        public function getIdImagem(): ?int {return $this->idImagem;}
        public function setIdImagem(int $idImagem): void {$this->idImagem = $idImagem;}

        // Getter e Setter para 'idTipoUsuario'
        public function getIdTipoUsuario(): ?int {return $this->idTipoUsuario;}
        public function setIdTipoUsuario(int $idTipoUsuario): void {$this->idTipoUsuario = $idTipoUsuario;}

        // Getter e Setter para 'login'
        public function getLogin(): ?string {return $this->login;}
        public function setLogin(string $login): void {$this->login = $login;}

        // Getter e Setter para 'senha'
        // Recebe uma senha exposta e a salva como um hash criado a partir do algoritmo bcrypt
        public function getSenha(): ?string {return $this->senha;}
        public function setSenha(string $senha): void {
            $hash = false;
            $opcoesHash = ['cost' => 12];
            
            do {
                $hash = password_hash($senha, PASSWORD_BCRYPT, $opcoesHash);
            }
            while($hash === false);

            $this->senha = $hash;
        }

        // Getter e Setter para 'nome'
        public function getNome(): ?string {return $this->nome;}
        public function setNome(string $nome): void {$this->nome = $nome;}

        // Getter e Setter para 'email'
        public function getEmail(): ?string {return $this->email;}
        public function setEmail(string $email): void {$this->email = $email;}

        // Getter e Setter para 'dataAniversario'
        public function getDataAniversario(): ?string {return $this->dataAniversario;}
        public function setDataAniversario(string $dataAniversario): void {$this->dataAniversario = $dataAniversario;}

        // Getter e Setter para 'descricao'
        public function getDescricao(): ?string {return $this->descricao;}
        public function setDescricao(string $descricao): void {$this->descricao = $descricao;}
    }

    /**
     * Implementação de IUsuarioDAO para MySQL
     * @implements IUsuarioDAO
     */
    final class UsuarioDAOMySQL implements IUsuarioDAO {
        // Variáveis para evitar múltiplos acessos de métodos estáticos
        private $nomeTabela = UsuarioVO::getNomeTabela();
        private $nomesColunasTabela = UsuarioVO::getNomesColunasTabela();
        private $quantColunasTabela = count($nomesColunasTabela);

        public function login(string $login, string $senha) : UsuarioVO | bool | null {
            $query = "SELECT * FROM $this->nomeTabela WHERE " . $this->nomesColunasTabela[3] . " = ?";

            $con = getConexaoBancoMySQL();
            if(isset($con) && $con != false) {

                $stmt = $con->prepare($query);
                if(isset($stmt) && $stmt != false) {

                    $stmt->bind_param("s", $login);
                    $rs = $stmt->get_result();
                    if(isset($rs) && $rs != false) {

                        $linha = $rs->fetch_assoc();
                        if(isset($linha) && $linha != false) {

                            $hash = $linha[$this->nomesColunasTabela[4]];
                            if(password_verify($senha, $hash)) {
                                $uVOsaida = new UsuarioVO();
                                $uVOsaida->setId($linha[$this->nomesColunasTabela[0]]);
                                $uVOsaida->setIdImagem($linha[$this->nomesColunasTabela[1]]);
                                $uVOsaida->setIdTipoUsuario($linha[$this->nomesColunasTabela[2]]);
                                $uVOsaida->setLogin($linha[$this->nomesColunasTabela[3]]);
                                $uVOsaida->setSenha($hash);
                                $uVOsaida->setNome($linha[$this->nomesColunasTabela[5]]);
                                $uVOsaida->setEmail($linha[$this->nomesColunasTabela[6]]);
                                $uVOsaida->setDataAniversario($linha[$this->nomesColunasTabela[7]]);
                                $uVOsaida->setDescricao($linha[$this->nomesColunasTabela[8]]);
                                $uVOsaida->setDataCriacao($linha[$this->nomesColunasTabela[9]]);
                                $uVOsaida->setAtivo(boolval($linha[$this->nomesColunasTabela[10]]));
                
                                return $uVOsaida;
                            }
                            else
                                return false;
                        }
                        else
                            return null;
                    }
                    else
                        exit("Erro ao definir ResultSet em UsuarioDAOMySQL->login(...): " . mysqli_connect_error());
                }
                else
                    exit("Erro ao definir PreparedStatement em UsuarioDAOMySQL->login(...): " . mysqli_connect_error());
            }
            else
                exit("Erro ao definir Connection em UsuarioDAOMySQL->login(...): " . mysqli_connect_error());
        }
        public function insert(UsuarioVO $uVO): bool {

            $query1 = "INSERT INTO $this->nomeTabela(" . $this->nomesColunasTabela[0];
            $query2 = "VALUES (null, ";

            for ($i = 1; $i < $this->quantColunasTabela; $i++) { 
                if($i < $this->quantColunasTabela - 1) {
                    $query1 .= $this->nomesColunasTabela[$i] . ", ";
                    $query2 .= "?, ";
                }
                else {
                    $query1 .= $this->nomesColunasTabela[$i] . ") ";
                    $query2 .= "?)";
                }
            }

            $con = getConexaoBancoMySQL();
            if(!empty($con)) {

                $query = "$query1 $query2";
                $stmt = $con->prepare($query);
                if(!empty($stmt)) {
                    $dadosUsuario = [
                        $uVO->getIdImagem(),
                        $uVO->getIdTipoUsuario(),
                        $uVO->getLogin(),
                        $uVO->getSenha(),
                        $uVO->getNome(),
                        $uVO->getEmail(),
                        $uVO->getDataAniversario(),
                        $uVO->getDescricao(),
                        $uVO->getDataCriacao(),
                        intval($uVO->isAtivo())
                    ];
    
                $stmt->bind_param("iisssssssi",
                    $dadosUsuario[1],
                    $dadosUsuario[2],
                    $dadosUsuario[3],
                    $dadosUsuario[4],
                    $dadosUsuario[5],
                    $dadosUsuario[6],
                    $dadosUsuario[7],
                    $dadosUsuario[8],
                    $dadosUsuario[9],
                    $dadosUsuario[10]
                );
                return $stmt->execute();
                
                }
                else
                    exit("Erro ao definir PreparedStatement em UsuarioDAOMySQL->insert(...): " . mysqli_connect_error());
            }
            else
                exit("Erro ao definir Connection em UsuarioDAOMySQL->insert(...): " . mysqli_connect_error());
            
            
        }
        public function selectAll(): ?array {
            $query = "SELECT * FROM $this->nomeTabela";

            $con = getConexaoBancoMySQL();
            if(!empty($con)) {

                $stmt = $con->prepare($query);
                if(!empty($stmt)) {
                    $rs = $stmt->get_result();
                    if(isset($rs) && $rs != false) {

                        $linha = $rs->fetch_assoc();
                        if($linha != false) {

                            $arrayRetorno = [];
                            while(isset($linha)) {
                                $uVOsaida = new UsuarioVO();
                                $uVOsaida->setId($linha[$this->nomesColunasTabela[0]]);
                                $uVOsaida->setIdImagem($linha[$this->nomesColunasTabela[1]]);
                                $uVOsaida->setIdTipoUsuario($linha[$this->nomesColunasTabela[2]]);
                                $uVOsaida->setLogin($linha[$this->nomesColunasTabela[3]]);
                                $uVOsaida->setSenha($linha[$this->nomesColunasTabela[4]]);
                                $uVOsaida->setNome($linha[$this->nomesColunasTabela[5]]);
                                $uVOsaida->setEmail($linha[$this->nomesColunasTabela[6]]);
                                $uVOsaida->setDataAniversario($linha[$this->nomesColunasTabela[7]]);
                                $uVOsaida->setDescricao($linha[$this->nomesColunasTabela[8]]);
                                $uVOsaida->setDataCriacao($linha[$this->nomesColunasTabela[9]]);
                                $uVOsaida->setAtivo(boolval($linha[$this->nomesColunasTabela[10]]));

                                $arrayRetorno[] = $uVOsaida;
                            }

                            return (count($arrayRetorno) == 0) ? null : $arrayRetorno;
                        }
                        else
                            return null;
                    }
                    else
                        exit("Erro ao definir ResultSet em UsuarioDAOMySQL->selectAll(...): " . mysqli_connect_error());
                }
                else
                    exit("Erro ao definir PreparedStatement em UsuarioDAOMySQL->selectAll(...): " . mysqli_connect_error());
            }
            else
                exit("Erro ao definir Connection em UsuarioDAOMySQL->selectAll(...): " . mysqli_connect_error());
        }
        public function selectWhere(UsuarioVO $uVO): ?array {
            $query = "SELECT * FROM $this->nomeTabela WHERE ";

            $tiposAtributos = "";
            $arrayAtributosFiltro = [];
            for ($i = 0; $i < $this->quantColunasTabela; $i++) { 
                switch($i) {
                    case 0:
                        $id = $uVO->getId();
                        if(isset($id)) {
                            $tiposAtributos .= "i";
                            $arrayAtributosFiltro[] = $id;
                        }
                            
                        break;
                    case 1:
                        $idImagem = $uVO->getIdImagem();
                        if(isset($idImagem)){
                            $tiposAtributos .= "i";
                            $arrayAtributosFiltro[] = $idImagem;
                        }

                        break;
                    case 2:
                        $idTipo = $uVO->getIdTipoUsuario();
                        if(isset($idTipo)){
                            $tiposAtributos .= "i";
                            $arrayAtributosFiltro[] = $idTipo;
                        }
                            
                        break;
                    case 3:
                        $login = $uVO->getLogin();
                        if(isset($login)){
                            $tiposAtributos .= "s";
                            $arrayAtributosFiltro[] = $login;
                        }
                            
                        break;
                    case 4:
                        $senha = $uVO->getSenha();
                        if(isset($senha)){
                            $tiposAtributos .= "s";
                            $arrayAtributosFiltro[] = $senha;
                        }
                            
                        break;
                    case 5:
                        $nome = $uVO->getNome();
                        if(isset($nome)){
                            $tiposAtributos .= "s";
                            $arrayAtributosFiltro[] = $nome;
                        }
                            
                        break;
                    case 6:
                        $email = $uVO->getEmail();
                        if(isset($email)){
                            $tiposAtributos .= "s";
                            $arrayAtributosFiltro[] = $email;
                        }
                            
                        break;
                    case 7:
                        $dataAniversario = $uVO->getDataAniversario();
                        if(isset($dataAniversario)){
                            $tiposAtributos .= "s";
                            $arrayAtributosFiltro[] = $dataAniversario;
                        }
                            
                        break;
                    case 8:
                        $descricao = $uVO->getDescricao();
                        if(isset($descricao)){
                            $tiposAtributos .= "s";
                            $arrayAtributosFiltro[] = $descricao;
                        }
                            
                        break;
                    case 9:
                        $dataCriacao = $uVO->getDataCriacao();
                        if(isset($dataCriacao)){
                            $tiposAtributos .= "s";
                            $arrayAtributosFiltro[] = $dataCriacao;
                        }
                            
                        break;
                    case 10:
                        $ativo = intval($uVO->isAtivo());
                        if(isset($ativo)){
                            $tiposAtributos .= "i";
                            $arrayAtributosFiltro[] = $ativo;
                        }
                            
                        break;
                }

                if($i < ($this->quantColunasTabela - 1))
                    $query .= $this->nomesColunasTabela[$i] . " = ? AND ";
                else
                    $query .= $this->nomesColunasTabela[$i] . " = ?";
            }

            $con = getConexaoBancoMySQL();
            if(!empty($con)) {

                $stmt = $con->prepare($query);
                if(!empty($stmt)) {
                    switch(count($arrayAtributosFiltro)){
                        case 1:
                            $stmt->bind_param($tiposAtributos,
                            $arrayAtributosFiltro[0]
                            );

                            break;
                        case 2:
                            $stmt->bind_param($tiposAtributos,
                            $arrayAtributosFiltro[0],
                            $arrayAtributosFiltro[1]
                            );
                                
                            break;
                        case 3:
                            $stmt->bind_param($tiposAtributos,
                            $arrayAtributosFiltro[0],
                            $arrayAtributosFiltro[1],
                            $arrayAtributosFiltro[2]
                            );
                                
                            break;
                        case 4:
                            $stmt->bind_param($tiposAtributos,
                            $arrayAtributosFiltro[0],
                            $arrayAtributosFiltro[1],
                            $arrayAtributosFiltro[2],
                            $arrayAtributosFiltro[3]
                            );
                                
                            break;
                        case 5:
                            $stmt->bind_param($tiposAtributos,
                            $arrayAtributosFiltro[0],
                            $arrayAtributosFiltro[1],
                            $arrayAtributosFiltro[2],
                            $arrayAtributosFiltro[3],
                            $arrayAtributosFiltro[4]
                            );
                                
                            break;
                        case 6:
                            $stmt->bind_param($tiposAtributos,
                            $arrayAtributosFiltro[0],
                            $arrayAtributosFiltro[1],
                            $arrayAtributosFiltro[2],
                            $arrayAtributosFiltro[3],
                            $arrayAtributosFiltro[4],
                            $arrayAtributosFiltro[5]
                            );
                                
                            break;
                        case 7:
                            $stmt->bind_param($tiposAtributos,
                            $arrayAtributosFiltro[0],
                            $arrayAtributosFiltro[1],
                            $arrayAtributosFiltro[2],
                            $arrayAtributosFiltro[3],
                            $arrayAtributosFiltro[4],
                            $arrayAtributosFiltro[5],
                            $arrayAtributosFiltro[6]
                            );
                                
                            break;
                        case 8:
                            $stmt->bind_param($tiposAtributos,
                            $arrayAtributosFiltro[0],
                            $arrayAtributosFiltro[1],
                            $arrayAtributosFiltro[2],
                            $arrayAtributosFiltro[3],
                            $arrayAtributosFiltro[4],
                            $arrayAtributosFiltro[5],
                            $arrayAtributosFiltro[6],
                            $arrayAtributosFiltro[7]
                            );
                                
                            break;
                        case 9:
                            $stmt->bind_param($tiposAtributos,
                                $arrayAtributosFiltro[0],
                                $arrayAtributosFiltro[1],
                                $arrayAtributosFiltro[2],
                                $arrayAtributosFiltro[3],
                                $arrayAtributosFiltro[4],
                                $arrayAtributosFiltro[5],
                                $arrayAtributosFiltro[6],
                                $arrayAtributosFiltro[7],
                                $arrayAtributosFiltro[8]
                            );
                                
                            break;
                        case 10:
                            $stmt->bind_param($tiposAtributos,
                                $arrayAtributosFiltro[0],
                                $arrayAtributosFiltro[1],
                                $arrayAtributosFiltro[2],
                                $arrayAtributosFiltro[3],
                                $arrayAtributosFiltro[4],
                                $arrayAtributosFiltro[5],
                                $arrayAtributosFiltro[6],
                                $arrayAtributosFiltro[7],
                                $arrayAtributosFiltro[8],
                                $arrayAtributosFiltro[9]
                            );
                                
                            break;
                        case 11:
                            $stmt->bind_param($tiposAtributos,
                                $arrayAtributosFiltro[0],
                                $arrayAtributosFiltro[1],
                                $arrayAtributosFiltro[2],
                                $arrayAtributosFiltro[3],
                                $arrayAtributosFiltro[4],
                                $arrayAtributosFiltro[5],
                                $arrayAtributosFiltro[6],
                                $arrayAtributosFiltro[7],
                                $arrayAtributosFiltro[8],
                                $arrayAtributosFiltro[9],
                                $arrayAtributosFiltro[10]
                            );
                                
                            break;
                    }

                    $rs = $stmt->get_result();
                    if(isset($rs) && $rs != false) {

                        $linha = $rs->fetch_assoc();
                        if($linha != false) {

                            $arrayRetorno = [];
                            while(isset($linha)) {
                                $uVOsaida = new UsuarioVO();
                                $uVOsaida->setId($linha[$this->nomesColunasTabela[0]]);
                                $uVOsaida->setIdImagem($linha[$this->nomesColunasTabela[1]]);
                                $uVOsaida->setIdTipoUsuario($linha[$this->nomesColunasTabela[2]]);
                                $uVOsaida->setLogin($linha[$this->nomesColunasTabela[3]]);
                                $uVOsaida->setSenha($linha[$this->nomesColunasTabela[4]]);
                                $uVOsaida->setNome($linha[$this->nomesColunasTabela[5]]);
                                $uVOsaida->setEmail($linha[$this->nomesColunasTabela[6]]);
                                $uVOsaida->setDataAniversario($linha[$this->nomesColunasTabela[7]]);
                                $uVOsaida->setDescricao($linha[$this->nomesColunasTabela[8]]);
                                $uVOsaida->setDataCriacao($linha[$this->nomesColunasTabela[9]]);
                                $uVOsaida->setAtivo($linha[$this->nomesColunasTabela[10]]);

                                $arrayRetorno[] = $uVOsaida;
                            }

                            return (count($arrayRetorno) == 0) ? null : $arrayRetorno;
                        }
                        else
                            return null;
                    }
                    else
                        exit("Erro ao definir ResultSet em UsuarioDAOMySQL->selectWhere(...): " . mysqli_connect_error());
                }
                else
                    exit("Erro ao definir PreparedStatement em UsuarioDAOMySQL->selectWhere(...): " . mysqli_connect_error());
            }
            else
                exit("Erro ao definir Connection em UsuarioDAOMySQL->selectWhere(...): " . mysqli_connect_error());
        }
        public function update(UsuarioVO $uVO): bool {
            $query = "UPDATE $this->nomeTabela SET ";

            for ($i = 1; $i < $this->quantColunasTabela; $i++) { 
                if($i < $this->quantColunasTabela - 1) {
                    $query .= $this->nomesColunasTabela[$i] . " = ?, ";
                }
                else {
                    $query .= $this->nomesColunasTabela[$i] . " = ? ";
                }
            }

            $query .= "WHERE " . $this->nomesColunasTabela[0] . " = ?";

            $con = getConexaoBancoMySQL();
            if(!empty($con)) {
                
                $stmt = $con->prepare($query);
                if(!empty($stmt)) {
                    $dadosUsuario = [
                        $uVO->getIdImagem(),
                        $uVO->getIdTipoUsuario(),
                        $uVO->getLogin(),
                        $uVO->getSenha(),
                        $uVO->getNome(),
                        $uVO->getEmail(),
                        $uVO->getDataAniversario(),
                        $uVO->getDescricao(),
                        $uVO->getDataCriacao(),
                        intval($uVO->isAtivo()),
                        $uVO->getId()
                    ];
    
                $stmt->bind_param("isssssssii",
                    $dadosUsuario[0],
                    $dadosUsuario[1],
                    $dadosUsuario[2],
                    $dadosUsuario[3],
                    $dadosUsuario[4],
                    $dadosUsuario[5],
                    $dadosUsuario[6],
                    $dadosUsuario[7],
                    $dadosUsuario[8],
                    $dadosUsuario[9],
                    $dadosUsuario[10]
                );
                return $stmt->execute();
                
                }
                else
                    exit("Erro ao definir PreparedStatement em UsuarioDAOMySQL->update(...): " . mysqli_connect_error());
            }
            else
                exit("Erro ao definir Connection em UsuarioDAOMySQL->update(...): " . mysqli_connect_error());
        }
        public function delete(int $id): bool {
            $idUsuario = $id;
            $query = "DELETE FROM $this->nomeTabela WHERE " . $this->nomesColunasTabela[0] . " = ?";

            $con = getConexaoBancoMySQL();
            if(!empty($con)) {
                
                $stmt = $con->prepare($query);
                if(!empty($stmt)) {
                    $stmt->bind_param("i", $idUsuario);
                    return $stmt->execute();
                }
                else
                    exit("Erro ao definir PreparedStatement em UsuarioDAOMySQL->delete(...): " . mysqli_connect_error());
            }
            else
                exit("Erro ao definir Connection em UsuarioDAOMySQL->delete(...): " . mysqli_connect_error());
        }
    }

    
?>