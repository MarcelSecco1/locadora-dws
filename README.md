# Locadora Prime

CRUD Laravel completo para o tema de locadora de veículos, com autenticação via Laravel Breeze, MySQL e ambiente Docker com Nginx.

## Requisitos atendidos

- Duas tabelas relacionadas: `veiculos` e `locacoes`
- CRUD completo nas duas entidades
- Autenticação com Breeze
- Listagem pública para visitantes
- Inserção, edição e exclusão restritas a usuários autenticados
- Upload de imagem para veículos
- Campo de status em veículos
- Layout próprio e responsivo
- Docker com Nginx, PHP/Node e MySQL

## Ambiente Docker

1. Suba os containers:

```bash
docker compose up -d --build
```

2. Rode as migrations e seeders:

```bash
docker compose exec app php artisan migrate --seed
```

3. Acesse a aplicação:

```text
http://localhost
```

## Acesso inicial

- E-mail: `admin@locadora.test`
- Senha: `password`

## Estrutura principal

- `veiculos`: modelo, marca, ano, placa, status, imagem
- `locacoes`: veiculo_id, cliente, data_retirada, data_devolucao

## Observações

- O Node está instalado dentro do container principal da aplicação.
- A aplicação sobe na porta 80 via Nginx.
- O deploy em AWS EC2 foi intencionalmente não incluído, conforme pedido.
