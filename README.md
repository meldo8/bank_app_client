1. Install all dependecies:
`composer install`
2. There are 5 possible commands to run:

`bin/console bank:balance <acc_source>` -> returning balance of selected account

`bin/console bank:depsoit <acc_source> <amount>` -> ordering the deposit of selected amount to provided account

`bin/console bank:transfer <acc_source> <acc_target> <amount>` -> ordering transfer of provided amount between selected account numbers

`bin/console bank:withdraw <acc_source> <amount>` -> ordering the withdraw of selected amount from provided account

`bin/console bank:mimic` -> mimic of client behaviour


