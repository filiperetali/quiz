CREATE TABLE salas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  codigo_sala VARCHAR(6) UNIQUE,
  status ENUM('aberta', 'em_andamento', 'finalizada') DEFAULT 'aberta'
);

CREATE TABLE perguntas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sala_id INT,
  pergunta TEXT,
  alternativa_a VARCHAR(255),
  alternativa_b VARCHAR(255),
  alternativa_c VARCHAR(255),
  alternativa_d VARCHAR(255),
  correta CHAR(1),
  FOREIGN KEY (sala_id) REFERENCES salas(id)
);

CREATE TABLE participantes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sala_id INT,
  nome VARCHAR(100),
  tempo_total INT DEFAULT 0,
  acertos INT DEFAULT 0,
  FOREIGN KEY (sala_id) REFERENCES salas(id)
);

CREATE TABLE respostas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  participante_id INT,
  pergunta_id INT,
  resposta CHAR(1),
  tempo_resposta INT,
  correta BOOLEAN,
  FOREIGN KEY (participante_id) REFERENCES participantes(id),
  FOREIGN KEY (pergunta_id) REFERENCES perguntas(id)
);
