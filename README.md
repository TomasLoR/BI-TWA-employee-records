# Evidence zaměstnanců - BI-TWA

Webová aplikace pro správu a evidenci zaměstnanců vytvořená pomocí Symfony frameworku. Aplikace poskytuje jak webové rozhraní pro interakci s uživateli, tak RESTful API pro programový přístup k datům.

## Popis projektu

Aplikace slouží k evidenci zaměstnanců a jejich snadnému vyhledávání. Umožňuje kompletní správu zaměstnaneckých záznamů včetně osobních informací, kontaktních údajů a rolí v organizaci.

## Technické specifikace

### Použité technologie

- **Framework**: Symfony 6.4
- **Backend**: PHP 8.1+
- **ORM**: Doctrine ORM 3.3
- **Database**: PostgreSQL (produkce) / SQLite (vývoj)
- **API**: FOSRestBundle pro RESTful API
- **Serialization**: JMS Serializer
- **Frontend**: Twig templates, CSS, JavaScript
- **Container**: Docker & Docker Compose
- **Testing**: PHPUnit

### Architektura

Aplikace je postavena na **MVC (Model-View-Controller)** architektuře s následující strukturou:

```
src/
├── Api/                    # REST API kontrolery a DTO
│   ├── Controller/         # API kontrolery
│   ├── Dto/               # Data Transfer Objects
│   └── Utils.php          # API utility funkce
├── Controller/            # Web kontrolery
├── Entity/               # Doctrine entity (modely)
├── Form/                 # Symfony formuláře
├── Repository/           # Doctrine repozitáře
└── Services/             # Business logika a služby
```

## Funkcionalita

### Webové rozhraní
- **Domovská stránka** - přehled aplikace a vyhledávací panel
- **Seznam zaměstnanců** - stránkovaný přehled s filtrováním
- **Detail zaměstnance** - kompletní informace o zaměstnanci
- **Správa zaměstnanců** - vytváření, editace a mazání záznamů
- **Správa rolí** - definice a přiřazování rolí
- **Správa účtů** - uživatelské účty a autentifikace

### REST API
API poskytuje kompletní CRUD operace pro všechny entity:

#### Endpoints pro zaměstnance
```http
GET    /api/employees/           # Seznam všech zaměstnanců
GET    /api/employees?search=X   # Filtrované vyhledávání
GET    /api/employees/{id}       # Detail konkrétního zaměstnance
POST   /api/employees/           # Vytvoření nového zaměstnance
PUT    /api/employees/{id}       # Kompletní aktualizace zaměstnance
PATCH  /api/employees/{id}       # Částečná aktualizace zaměstnance
DELETE /api/employees/{id}       # Smazání zaměstnance
```

#### Endpoints pro role a účty
```http
GET    /api/roles/              # Seznam rolí
POST   /api/roles/              # Vytvoření nové role
GET    /api/accounts/           # Seznam účtů
POST   /api/accounts/           # Vytvoření nového účtu
```

### Datové modely

#### Employee (Zaměstnanec)
- **Základní údaje**: jméno, email, telefon, website
- **Popis**: detailní popis pozice a zodpovědností
- **Metadata**: datum nástupu, fotografie
- **Vztahy**: role, účet

#### Role (Role)
- **Název**: identifikace role
- **Popis**: detailní popis role
- **Vztahy**: přiřazení k zaměstnancům

#### Account (Účet)
- **Přihlašovací údaje**: username, password
- **Metadata**: typ účtu, aktivní stav
- **Vztahy**: propojení se zaměstnancem

## Instalace a spuštění

### Předpoklady
- PHP 8.1 nebo vyšší
- Composer
- Docker & Docker Compose (doporučeno)
- Git

### Spuštění s Dockerem (doporučeno)

1. **Klonování repozitáře**
```bash
git clone https://github.com/username/BI-TWA-employee-records.git
cd BI-TWA-employee-records
```

2. **Spuštění databáze**
```bash
docker-compose up -d
```

3. **Instalace závislostí**
```bash
composer install
```

4. **Spuštění vývojového serveru**
```bash
php -S localhost:8080 -t public/
```
