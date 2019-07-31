# ZF Mail MVC Integration Demo

## Introduction

This introduces the integration of ZF\Mail into the sample ZF3 Application.

## Installating Dependencies using Composer

The easiest way to install dependencies is to use
[Composer](https://getcomposer.org/).  If you don't have it already installed,
then please install as per the [documentation](https://getcomposer.org/doc/00-intro.md).

To install dependencies:

```bash
$ composer install
```

## Starting the demo

This demo utilizes make for common actions, and docker-compose for running the sample. It assumes you're on a MacOS
desktop development system.

```bash
$ make up
```

Once complete, this will pop two browser tabs, one for MailHog and one for the application.

Just loading the application will send an e-mail that can be seen in MailHog.

## Stopping the demo

This demo utilizes make for common actions, and docker-compose for running the sample. It assumes you're on a MacOS
desktop development system.

```bash
$ make down
```
