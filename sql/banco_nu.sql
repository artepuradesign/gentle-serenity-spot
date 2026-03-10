-- =====================================================
-- BANCO NU - ESTRUTURA COMPLETA DO BANCO DE DADOS
-- MySQL 8.0+
-- =====================================================

CREATE DATABASE IF NOT EXISTS banco_nu CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE banco_nu;

-- =====================================================
-- TABELA: usuarios (login e autenticação)
-- =====================================================
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    pin_hash VARCHAR(255) NULL COMMENT 'Senha de 4 dígitos para transações e login alternativo',
    tipo_conta ENUM('PF', 'PJ') NOT NULL,
    status ENUM('pendente', 'ativo', 'bloqueado', 'encerrado') NOT NULL DEFAULT 'pendente',
    is_admin TINYINT(1) NOT NULL DEFAULT 0,
    ultimo_acesso DATETIME NULL,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_status (status)
) ENGINE=InnoDB;

-- =====================================================
-- TABELA: pessoas_fisicas
-- =====================================================
CREATE TABLE pessoas_fisicas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL UNIQUE,
    nome_completo VARCHAR(200) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    data_nascimento DATE NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    rg VARCHAR(20) NULL,
    nome_mae VARCHAR(200) NULL,
    genero ENUM('M', 'F', 'O', 'NI') DEFAULT 'NI',
    estado_civil ENUM('solteiro', 'casado', 'divorciado', 'viuvo', 'outro') DEFAULT 'solteiro',
    profissao VARCHAR(100) NULL,
    renda_mensal DECIMAL(15,2) NULL,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    INDEX idx_cpf (cpf)
) ENGINE=InnoDB;

-- =====================================================
-- TABELA: pessoas_juridicas
-- =====================================================
CREATE TABLE pessoas_juridicas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL UNIQUE,
    razao_social VARCHAR(255) NOT NULL,
    nome_fantasia VARCHAR(255) NULL,
    cnpj VARCHAR(18) NOT NULL UNIQUE,
    inscricao_estadual VARCHAR(30) NULL,
    inscricao_municipal VARCHAR(30) NULL,
    telefone VARCHAR(20) NOT NULL,
    data_abertura DATE NULL,
    natureza_juridica VARCHAR(100) NULL,
    porte ENUM('MEI', 'ME', 'EPP', 'MEDIO', 'GRANDE') DEFAULT 'ME',
    faturamento_mensal DECIMAL(15,2) NULL,
    responsavel_nome VARCHAR(200) NOT NULL,
    responsavel_cpf VARCHAR(14) NOT NULL,
    responsavel_telefone VARCHAR(20) NOT NULL,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    INDEX idx_cnpj (cnpj)
) ENGINE=InnoDB;

-- =====================================================
-- TABELA: enderecos
-- =====================================================
CREATE TABLE enderecos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    tipo ENUM('residencial', 'comercial', 'correspondencia') NOT NULL DEFAULT 'residencial',
    cep VARCHAR(10) NOT NULL,
    logradouro VARCHAR(255) NOT NULL,
    numero VARCHAR(20) NOT NULL,
    complemento VARCHAR(100) NULL,
    bairro VARCHAR(100) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    estado CHAR(2) NOT NULL,
    pais VARCHAR(50) NOT NULL DEFAULT 'Brasil',
    principal TINYINT(1) NOT NULL DEFAULT 1,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    INDEX idx_usuario (usuario_id)
) ENGINE=InnoDB;

-- =====================================================
-- TABELA: contas (conta bancária)
-- =====================================================
CREATE TABLE contas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    numero_conta VARCHAR(20) NOT NULL UNIQUE,
    agencia VARCHAR(10) NOT NULL DEFAULT '0001',
    tipo_conta ENUM('corrente', 'poupanca', 'salario') NOT NULL DEFAULT 'corrente',
    saldo DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    saldo_bloqueado DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    limite_credito DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    limite_pix_diario DECIMAL(15,2) NOT NULL DEFAULT 20000.00,
    limite_ted_diario DECIMAL(15,2) NOT NULL DEFAULT 50000.00,
    status ENUM('ativa', 'bloqueada', 'encerrada') NOT NULL DEFAULT 'ativa',
    data_abertura DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    data_encerramento DATETIME NULL,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    INDEX idx_numero_conta (numero_conta),
    INDEX idx_usuario (usuario_id)
) ENGINE=InnoDB;

-- =====================================================
-- TABELA: transacoes (movimentações financeiras)
-- =====================================================
CREATE TABLE transacoes (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    conta_id INT NOT NULL,
    tipo ENUM('entrada', 'saida') NOT NULL,
    categoria ENUM('PIX', 'TED', 'DOC', 'BOLETO', 'ESTORNO', 'RENDIMENTO', 'TARIFA', 'DEPOSITO', 'SAQUE', 'OUTROS') NOT NULL,
    descricao VARCHAR(255) NOT NULL,
    valor DECIMAL(15,2) NOT NULL,
    saldo_anterior DECIMAL(15,2) NOT NULL,
    saldo_posterior DECIMAL(15,2) NOT NULL,
    data_transacao DATETIME NOT NULL,
    data_efetivacao DATETIME NULL,
    -- Dados do beneficiário/pagador
    beneficiario_nome VARCHAR(200) NULL,
    beneficiario_documento VARCHAR(20) NULL,
    beneficiario_banco VARCHAR(100) NULL,
    beneficiario_banco_codigo VARCHAR(10) NULL,
    beneficiario_agencia VARCHAR(10) NULL,
    beneficiario_conta VARCHAR(20) NULL,
    -- Controle
    codigo_autenticacao VARCHAR(64) NULL,
    id_transacao_externa VARCHAR(100) NULL,
    observacao TEXT NULL,
    status ENUM('pendente', 'efetivada', 'cancelada', 'estornada') NOT NULL DEFAULT 'efetivada',
    admin_id INT NULL,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (conta_id) REFERENCES contas(id) ON DELETE CASCADE,
    FOREIGN KEY (admin_id) REFERENCES usuarios(id) ON DELETE SET NULL,
    INDEX idx_conta (conta_id),
    INDEX idx_data (data_transacao),
    INDEX idx_tipo (tipo),
    INDEX idx_categoria (categoria),
    INDEX idx_status (status)
) ENGINE=InnoDB;

-- =====================================================
-- TABELA: chaves_pix
-- =====================================================
CREATE TABLE chaves_pix (
    id INT AUTO_INCREMENT PRIMARY KEY,
    conta_id INT NOT NULL,
    tipo_chave ENUM('cpf', 'cnpj', 'email', 'telefone', 'aleatoria') NOT NULL,
    chave VARCHAR(255) NOT NULL UNIQUE,
    status ENUM('ativa', 'inativa') NOT NULL DEFAULT 'ativa',
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (conta_id) REFERENCES contas(id) ON DELETE CASCADE,
    INDEX idx_chave (chave)
) ENGINE=InnoDB;

-- =====================================================
-- TABELA: extratos_gerados (PDF/relatórios)
-- =====================================================
CREATE TABLE extratos_gerados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    conta_id INT NOT NULL,
    periodo_inicio DATE NOT NULL,
    periodo_fim DATE NOT NULL,
    saldo_inicial DECIMAL(15,2) NOT NULL,
    total_entradas DECIMAL(15,2) NOT NULL,
    total_saidas DECIMAL(15,2) NOT NULL,
    rendimento_liquido DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    saldo_final DECIMAL(15,2) NOT NULL,
    arquivo_path VARCHAR(500) NULL,
    gerado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (conta_id) REFERENCES contas(id) ON DELETE CASCADE,
    INDEX idx_conta_periodo (conta_id, periodo_inicio, periodo_fim)
) ENGINE=InnoDB;

-- =====================================================
-- TABELA: notificacoes
-- =====================================================
CREATE TABLE notificacoes (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    titulo VARCHAR(200) NOT NULL,
    mensagem TEXT NOT NULL,
    tipo ENUM('transacao', 'seguranca', 'sistema', 'marketing') NOT NULL DEFAULT 'sistema',
    lida TINYINT(1) NOT NULL DEFAULT 0,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    INDEX idx_usuario (usuario_id),
    INDEX idx_lida (lida)
) ENGINE=InnoDB;

-- =====================================================
-- TABELA: logs_acesso (auditoria)
-- =====================================================
CREATE TABLE logs_acesso (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NULL,
    acao VARCHAR(100) NOT NULL,
    detalhes TEXT NULL,
    ip VARCHAR(45) NULL,
    user_agent VARCHAR(500) NULL,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL,
    INDEX idx_usuario (usuario_id),
    INDEX idx_acao (acao),
    INDEX idx_data (criado_em)
) ENGINE=InnoDB;

-- =====================================================
-- TABELA: configuracoes_sistema
-- =====================================================
CREATE TABLE configuracoes_sistema (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chave VARCHAR(100) NOT NULL UNIQUE,
    valor TEXT NOT NULL,
    descricao VARCHAR(255) NULL,
    atualizado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================
-- DADOS INICIAIS
-- =====================================================

-- Admin padrão (senha: password - hash bcrypt)
-- IMPORTANTE: Após inserir, use o script api/reset_admin.php para definir uma nova senha
INSERT INTO usuarios (email, senha_hash, tipo_conta, status, is_admin) VALUES
('admin@nu.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PF', 'ativo', 1);

-- Configurações padrão
INSERT INTO configuracoes_sistema (chave, valor, descricao) VALUES
('nome_banco', 'NU', 'Nome do banco'),
('codigo_banco', '0260', 'Código do banco no SPB'),
('agencia_padrao', '0001', 'Agência padrão'),
('limite_pix_padrao', '20000.00', 'Limite PIX diário padrão'),
('limite_ted_padrao', '50000.00', 'Limite TED diário padrão'),
('taxa_rendimento_diario', '0.000329', 'Taxa de rendimento diário (CDI)');
