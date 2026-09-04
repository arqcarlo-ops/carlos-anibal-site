# Carlos Aníbal — Treinamento e Desenvolvimento Infantil

Projeto completo para hospedagem PHP compartilhada. Inclui site público, WhatsApp, painel administrativo, cadastro de alunos, frequência, avaliações, relatórios, declarações e certificados.

## 1. Arquivos principais

- `index.php` — site público.
- `preview.html` — prévia estática para abrir no VS Code/Live Server.
- `assets/css/style.css` — visual do site.
- `assets/js/script.js` — menu, animações e formulário do WhatsApp.
- `admin/` — painel do professor.
- `config/config.php` — telefone, CREF, Instagram e banco de dados.
- `storage/database.sqlite` — criado automaticamente quando usar SQLite.
- `database.sql` — estrutura para MySQL/phpMyAdmin.
- `verificar.php` — verifica o número de um documento registrado.

## 2. Dados já configurados

- Professor: Carlos Aníbal
- CREF: 015760-BA
- Instagram: @anibal_erudilho
- WhatsApp: (75) 98313-1424
- Região: Feira de Santana - BA

Revise estes dados em `config/config.php` antes de publicar.

## 3. Teste rápido no computador

O painel usa PHP, portanto o Live Server sozinho não executa a parte administrativa.

### Opção A — PHP instalado

Na pasta do projeto:

```bash
php -S localhost:8000
```

Abra:

```text
http://localhost:8000
```

Painel:

```text
http://localhost:8000/admin/login.php
```

### Acesso inicial

### Acesso administrativo

O acesso ao painel administrativo deve ser configurado diretamente no ambiente de produção.


**Troque a senha em Painel > Configurações antes de publicar.**

O modo padrão usa SQLite e cria o banco automaticamente no primeiro acesso.

## 4. Colocar em hospedagem compartilhada

A hospedagem precisa ter PHP 8.1+ e pelo menos uma destas opções:

- PDO SQLite; ou
- MySQL/MariaDB + PDO MySQL.

### Forma mais simples — SQLite

1. Envie todo o conteúdo da pasta para `public_html`.
2. Garanta permissão de escrita na pasta `storage` (normalmente 755 ou 775).
3. Acesse `/admin/login.php`.
4. Troque a senha inicial.

### Usando MySQL / phpMyAdmin

1. Crie um banco e usuário MySQL no painel da hospedagem.
2. Importe `database.sql` no phpMyAdmin.
3. Edite `config/config.php`:

```php
'driver' => 'mysql',
'host' => 'localhost',
'database' => 'NOME_DO_BANCO',
'username' => 'USUARIO_DO_BANCO',
'password' => 'SENHA_DO_BANCO',
```

4. Acesse `https://seu-dominio.com.br/install.php`.
5. Crie o e-mail e a senha do administrador.
6. Teste o painel e **apague `install.php` do servidor**.

Se preferir criar o usuário manualmente, gere o hash com `password_hash()` e insira-o na tabela `users`.

## 5. WhatsApp

O número fica em:

```text
config/config.php
```

O formulário da página não envia dados para servidor. Ele monta uma mensagem e abre diretamente o WhatsApp do professor.

## 6. Programas incluídos

1. Movimento Kids — ciclo inicial de 12 semanas.
2. Pequenos Atletas — evolução e afinidade esportiva.
3. Pequenas Atitudes, Grandes Conquistas — continuidade, autonomia e hábitos ativos.

O painel também permite selecionar Preparação Esportiva e Retorno ao Movimento.

## 7. Documentos e PDF

No painel:

`Alunos > abrir aluno > Documentos`

É possível gerar:

- Declaração de frequência.
- Declaração de participação.
- Relatório de evolução com gráficos.
- Certificado de conclusão.

O botão **Registrar emissão e imprimir / salvar PDF** registra o documento no banco e abre a impressão do navegador. Selecione **Salvar como PDF**.

Os relatórios usam os dados lançados em `Avaliações` e comparam avaliação inicial e atual.

## 8. Segurança antes da publicação

- Troque a senha inicial.
- Use HTTPS/SSL da hospedagem.
- Faça backup periódico do banco.
- Não publique cópias do arquivo SQLite fora da pasta protegida.
- Revise a política de privacidade/LGPD, especialmente porque há dados de menores.
- Evite registrar informações clínicas desnecessárias no campo de observações.

## 9. Fotos

O projeto utiliza imagens fornecidas na conversa e composições criadas para a apresentação. Antes da publicação definitiva, confirme a autorização de uso de imagem das crianças e substitua imagens provisórias quando necessário.

## 10. Próximas melhorias possíveis

- Portal do responsável.
- QR Code nos documentos.
- Agenda de aulas.
- Controle financeiro.
- Backup automático.
- Exportação Excel/CSV.
- Integração com gateway de pagamento.
