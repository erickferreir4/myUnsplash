
# [MyUnsplash](#)


### Simple photo url gallery

#### with myunsplash you can store image links all in one place


![MyUnsplash](https://github.com/erickferreir4/myUnsplash/blob/master/app/assets/imgs/myUnsplash.png?raw=true)


#### This gallery was created, thinking about database storage with php sqlite, with a focus on learning.

some techniques that were applied in the development

```
- Factory Method
    
    ConnectionFactory.php with switch in PDO


- Log

    LoggerHTML.php and LoggerTXT.php for logging transactions in /tmp
    

- Gateways

    TableDataMapper
        FileController.php FileModel.php domain
        AuthController.php AuthModel.php domain


- Transaction

    Transaction.php for greater control of database persistence


- Interface

    to have a contract with the following classes:
        ILogger.php for LoggerHTML.php and LoggerTXT.php
        IAssets.php for Assets.php and AssetsCdn.php


- Dependency Injection

    TemplateTrait.php created the setAssets method to inject similar Assets classes
    

- Trait

    TemplateTrait.php was created to have the same methods in view controllers
    
```
