# Classifier BBC News Articles

Classifier articles of BBC News from 2004 to 2005, in PHP

First, install all dependencies of project:

```
composer install
```

To call the command, open your bash and type:

```
php app classification 'url-article'
```

Replace 'url-article' with a url of an article on the [BBC News website](https://www.bbc.com/news), as in this example:

```
php app classification https://www.bbc.com/news/technology-46108083
```

Categories of articles available for this project:

- Business
- Entertainment
- Politics
- Sport
- Tech
