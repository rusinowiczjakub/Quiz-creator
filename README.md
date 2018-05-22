#Test_generator
======

It's very simple project, created with educational needs.
Frontend is made with angular 5 and server-side with Symfony 3.4


## HOW IT WORKS

You can upload a file with a structure:

1. Question: \n
Answer1, \n
Answer2,\n
Answer3,\n
...
\n

2. <>: \n
...,\n
...,\n

on route /upload

Questions and answers are uploaded to MySQL database

#### IF YOU WANT TO SET CORRECT ANSWER FOR QUESTION IN FILE INSERT "|" at the beginning of answer line;

## RUN APP

```
$ php bin/console doctrine:database:create
```

```
$ php bin/console doctrine:schema:update --force
```

```
$ php bin/console server:start
```

cd into /frontend and then: 

```
$ ng serve
