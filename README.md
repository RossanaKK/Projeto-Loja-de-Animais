# 🐾 Loja de Animais — Projeto Final (Laravel)

Aplicação web desenvolvida no âmbito da unidade curricular de **Aplicações Centradas em Redes** do **CTeSP em Tecnologias e Programação de Sistemas de Informação (TPSI)** da **Universidade da Madeira (UMa)**.

## 🚀 Sobre o Projeto
A **Loja de Animais** é uma plataforma de e-commerce e gestão de animais de estimação que implementa o modelo **MVC (Model-View-Controller)** utilizando a framework **Laravel 11**. A aplicação conta com áreas distintas para visitantes, clientes registados e administradores, oferecendo um catálogo completo com pesquisa, ordenação, destaques aleatórios e gestão de encomendas e animais.

---

## 🛠️ Tecnologias e Ferramentas Utilizadas

* **Backend:** PHP 8.2+, Laravel 11
* **Base de Dados:** MySQL (alojada em **Aiven.io**)
* **Armazenamento de Imagens:** **Cloudinary** (API para upload e otimização de imagens)
* **Autenticação:** Laravel Breeze (Gestão de Sessões, Registo e Login)
* **Frontend:** Blade Templates, CSS3 personalizado com design responsivo e efeitos translúcidos (*backdrop-filter*)
* **Deploy e Controlo de Versões:** Git, GitHub e **Render**

---

## ✨ Funcionalidades Principais

### 🌐 Área Pública (Guest)
* **Página Inicial Dinâmica:** Apresenta um sistema de destaques aleatórios de produtos a cada *refresh*.
* **Catálogo e Detalhes:** Listagem completa de produtos com imagens em alta resolução e visualização detalhada.
* **Pesquisa e Ordenação:** Permite filtrar produtos por categoria e ordenar de forma ascendente/descendente.
* **Página de Contactos:** Informações institucionais e canal de comunicação direto.

### 👤 Área Reservada (Clientes Autenticados)
* **Autenticação Segura:** Registo e início de sessão através do Laravel Breeze.
* **Gestão de Animais de Estimação:** Secção dedicada onde os clientes podem registar e gerir o perfil dos seus animais (*Os Meus Animais*).
* **Histórico de Encomendas:** Acompanhamento e registo de compras efetuadas.

### 🛠️ Painel de Administração (Admin)
* **Gestão CRUD Completa:** Criação, leitura, atualização e eliminação de **Produtos** e **Categorias**.
* **Validação de Dados:** Validação robusta de campos obrigatórios, comprimentos mínimos e restrições de formato/tamanho para uploads de imagens, com mensagens de erro personalizadas.
* **Controlo de Acessos:** Restrições rígidas baseadas em papéis (*Guest*, *Auth*, *Admin*).

---

## 🔑 Credenciais de Teste
Para facilitar a avaliação e teste das diferentes permissões da aplicação, podes utilizar as seguintes contas configuradas:

| Perfil / Papel | Email | Password | Permissões e Acessos |
| :--- | :--- | :--- | :--- |
| **Administrador** | `admin@lojaanimais.pt` | `password123` | Acesso ao painel de administração, criação/edição/eliminação de produtos e categorias. |
| **Cliente** | `cliente@lojaanimais.pt` | `password123` | Acesso à compra de produtos, histórico de encomendas e gestão de animais de estimação. |

---

## 📂 Estrutura de Relações (Base de Dados)
O projeto implementa várias relações do tipo **1 para Muitos (1:N)** com base no modelo conceptual:
1. **`users` (1) ➔ `pets` (N):** Um utilizador pode possuir vários animais de registados.
2. **`users` (1) ➔ `orders` (N):** Um utilizador pode efetuar várias encomendas ao longo do tempo.
3. **`categories` (1) ➔ `products` (N):** Uma categoria agrupa vários produtos do catálogo.
4. **`products` (1) ➔ `orders` (N):** Um produto pode estar presente em várias linhas de encomendas diferentes.

---

## ⚙️ Instalação e Execução Local

Se pretenderes executar o projeto localmente no teu ambiente de desenvolvimento (ex: **Laragon**):

1. **Clonar o repositório:**
   ```bash
   git clone [https://github.com/RossanaKK/Projeto-Loja-de-Animais.git](https://github.com/RossanaKK/Projeto-Loja-de-Animais.git)
   cd Projeto-Loja-de-Animais
