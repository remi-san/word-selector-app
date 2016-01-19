parameters:

    orm.doctrine.yml.paths: [ "../config/orm" ]
    orm.doctrine.devmode:   false
    orm.doctrine.db:
        driver:   "pdo_pgsql"
        host:     "pghost"
        user:     "postgres"
        password: "postgres"
        dbname:   "games"