# hangman
hangman game

## How to install

* Git clone
* Composer install
* Doctrine schema update
* Add 2 roles to the database USER_ROLE and USER_ADMIN
* Launch and Play

### Default Controller 

#### indexAction()

renders the homepage

#### adminIndexAction()

renders admin homepage

## Controllers

### Category controller

Defines all CRUD operations for managing categories

### Word Controller

Defines all CRUD operations for managing words


### Security Controller

Registration, login process


### Game Controller

#### indexAction()

renders the default game page, loads or creates a new game

#### letterAction()

Used to test if the current word in play contains a certain letter

#### wordAction()

Used to test if the gussed word is correct. If true wonAction() is called, if false hangedAction is called()

#### wonAction()

Checks is the user has won the game and renders winner index page

#### hangedAction()

Checks if the user has lost the game and renders looser index page

#### resetAction()

Resets the game context

