<?php
    /**
     * Um objeto que contém os dados necessários para todas as tabelas no banco de dados
     * Estes dados são:
     * - ID (INT)
     * - Data de Criação (DATE)
     * - Ativo (TINYINT(1))
     */
    abstract class ObjetoVO {
        private $id;
        private $dataCriacao;
        private $ativo;

        protected function __construct() {
            $this->id = null;
            $this->dataCriacao = null;
            $this->ativo = null;
        }

        public function getId() : ?int {return $this->id;}
        public function setId(int $id) : void {$this->id = $id;}

        public function getDataCriacao() : ?string {return $this->dataCriacao;}
        public function setDataCriacao(String $dataCriacao) : void {$this->dataCriacao = $dataCriacao;}

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
        final private static $nomeTabela = "Usuario";
        final private static $nomesColunasTabela = [
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

        private $idImagem;
        private $idTipoUsuario;
        private $login;
        private $senha;
        private $nome;
        private $email;
        private $dataAniversario;
        private $descricao;

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

        public static function getNomeTabela() {return self::$nomeTabela;}
        public static function getNomesColunasTabela() {return self::$nomesColunasTabela;}

        public function getIdImagem(): ?int {return $this->idImagem;}
        public function setIdImagem(int $idImagem): void {$this->idImagem = $idImagem;}

        public function getIdTipoUsuario(): ?int {return $this->idTipoUsuario;}
        public function setIdTipoUsuario(int $idTipoUsuario): void {$this->idTipoUsuario = $idTipoUsuario;}

        public function getLogin(): ?string {return $this->login;}
        public function setLogin(string $login): void {$this->login = $login;}

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

        public function getNome(): ?string {return $this->nome;}
        public function setNome(string $nome): void {$this->nome = $nome;}

        public function getEmail(): ?string {return $this->email;}
        public function setEmail(string $email): void {$this->email = $email;}

        public function getDataAniversario(): ?string {return $this->dataAniversario;}
        public function setDataAniversario(string $dataAniversario): void {$this->dataAniversario = $dataAniversario;}

        public function getDescricao(): ?string {return $this->descricao;}
        public function setDescricao(string $descricao): void {$this->descricao = $descricao;}
    }

    /**
     * Implementação de IUsuarioDAO
     * @implements IUsuarioDAO
     */
    class UsuarioDAOMySQL implements IUsuarioDAO {
        private $nomeTabela = UsuarioVO::getNomeTabela();
        private $nomesColunasTabela = UsuarioVO::getNomesColunasTabela();
        private $quantColunasTabela = count($nomesColunasTabela);

        public function login(string $login, string $senha) : UsuarioVO | bool | null {
            $query = "SELECT * FROM $this->nomeTabela WHERE $this->nomesColunasTabela[3] = ?";

            $con = getConexaoBancoMySQL();
            if(isset($con) && $con != false) {

                $stmt = $con->prepare($query);
                if(isset($stmt) && $stmt != false) {

                    $stmt->bind_param("ss", $login);
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
                                $uVOsaida->setAtivo($linha[$this->nomesColunasTabela[10]]);
                
                                return $uVOsaida;
                            }
                            else
                                return false;
                        }
                        else
                            return null;
                    }
                    else
                        exit("Erro ao definir ResultSet em UsuarioDAOMySQL->login()");
                }
                else
                    exit("Erro ao definir PreparedStatement em UsuarioDAOMySQL->login()");
            }
            else
                exit("Erro ao definir Connection em UsuarioDAOMySQL->login()");
        }
        public function insert(UsuarioVO $uVO): bool {

            $sqlInsertInto = "INSERT INTO $this->nomeTabela(";
            $sqlValues = "VALUES (";

            for ($i = 1; $i < $this->quantColunasTabela; $i++) { 
                if($i < $this->quantColunasTabela - 1) {
                    $sqlInsertInto .= $this->nomesColunasTabela[$i] . ", ";
                    $sqlValues .= "?, ";
                }
                else {
                    $sqlInsertInto .= $this->nomesColunasTabela[$i] . ") ";
                    $sqlValues .= "?)";
                }
            }

            $con = getConexaoBancoMySQL();
            $query = "$sqlInsertInto $sqlValues";
            $stmt = $con->prepare($query);
            $dadosUsuario = [$uVO->getId(),
                $uVO->getIdImagem(),
                $uVO->getIdTipoUsuario(),
                $uVO->getLogin(),
                $uVO->getSenha(),
                $uVO->getNome(),
                $uVO->getEmail(),
                $uVO->getDataAniversario(),
                $uVO->getDescricao(),
                $uVO->getDataCriacao(),
                $uVO->isAtivo()
            ];

            $stmt->bind_param("iissssssss",
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
        public function selectAll(): ?UsuarioVO {

        }
        public function selectWhere(UsuarioVO $uVO): ?UsuarioVO {

        }
        public function update(UsuarioVO $uVO): bool {

        }
        public function delete(UsuarioVO $uVO): bool {

        }
    }

    
?>