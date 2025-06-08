# Sistema Clínico — Médico e Paciente

Este projeto é um sistema clínico composto por dois sites distintos:  
- **Site do Médico** (`/medico`)  
- **Site do Paciente** (`/paciente`)  

Ambos são hospedados localmente usando **XAMPP** e compartilham um banco de dados MySQL.  
O sistema permite cadastros, login e consulta de exames para pacientes, e acesso restrito para médicos.

---

## 🚀 Tecnologias Utilizadas

- HTML, CSS e JavaScript
- PHP
- MySQL
- [XAMPP](https://www.apachefriends.org/index.html) (Apache + MySQL)
- Git + GitHub

---

## 📁 Estrutura do Projeto

/sistema_clinico/
├── medico/ # Site do médico
│ ├── index.html
│ ├── styles.css
│ ├── login.php
│ └── ...
├── paciente/ # Site do paciente
│ ├── index.html
│ ├── styles.css
│ ├── cadastro.php
│ ├── login.php
│ └── ...


## ✅ Pré-requisitos

- [XAMPP](https://www.apachefriends.org/index.html) instalado
- Git instalado
- Navegador moderno (Chrome, Firefox, Edge)
- Editor de código (recomendado: VSCode)

---

## ⚙️ Como Executar o Projeto

### 1. Clone o repositório

```bash
git clone https://github.com/0RichardSales0/sistema_clinico.git
2. Mova as pastas para o diretório do XAMPP
bash
Copy
Edit
C:\xampp\htdocs\sistema_clinico
Ou acesse via terminal:

bash
Copy
Edit
cd C:\xampp\htdocs\sistema_clinico
3. Inicie o XAMPP
Abra o XAMPP Control Panel

Inicie os serviços:

Apache ✅

MySQL ✅

4. Crie o banco de dados MySQL
Acesse: http://localhost/phpmyadmin

Crie o banco (ex: clinica)

Execute o script SQL para criar a tabela paciente:

sql
Copy
Edit
CREATE TABLE paciente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100),
    cpf VARCHAR(14),
    senha VARCHAR(255)
);
Se houver outras tabelas como exames, crie-as também conforme a lógica do projeto.

🔑 Principais Funcionalidades
🧍 Cadastro de Paciente (paciente/cadastro.php)
php
Copy
Edit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $cpf = $_POST["cpf"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    $conn = new mysqli("localhost", "root", "", "clinica");
    $sql = "INSERT INTO paciente (nome, email, cpf, senha) VALUES ('$nome', '$email', '$cpf', '$senha')";
    $conn->query($sql);
}
🔐 Login do Paciente (paciente/login.php)
php
Copy
Edit
$cpf = $_POST["cpf"];
$senha = $_POST["senha"];

$conn = new mysqli("localhost", "root", "", "clinica");
$sql = "SELECT * FROM paciente WHERE cpf='$cpf'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    if (password_verify($senha, $usuario["senha"])) {
        // Login com sucesso
    }
}
🔎 Buscar Exames (Paciente Logado)
php
Copy
Edit
$sql = "SELECT * FROM exames WHERE paciente_id = $id_paciente";
$result = $conn->query($sql);

while ($exame = $result->fetch_assoc()) {
    echo "<li>" . $exame["descricao"] . "</li>";
}
🌐 Como Acessar no Navegador
Site do paciente:
👉 http://localhost/sistema_clinico/paciente

Site do médico:
👉 http://localhost/sistema_clinico/medico
