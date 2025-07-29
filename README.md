# Let's Build an AI-Driven Search on Our Website

[Presented by Frank Berger at TYPO3 Developer Days 2025.](https://code711.de/talks/lets-build-an-ai-driven-search-on-our-website)


## Embeddings
Essentially, embeddings are points in a multi-dimensional space, represented as vectors. They encode both semantic and contextual information of a word, phrase, or text, making them highly significant in AI and language processing.


## Tools used
Our examples depend heavily on OpenAI's embedding models. In particular, the 'text-embedding-ada-002' model with its 1536 dimensions normalized to unit length (ranging from 0 and 1) serves our purpose well.

> The examples expect an OpenAI key in the environment variable OPENAIKEY

Redis with JSON and Vector Sets plugins enabled

Feel free to explore the code examples and learn more about embeddings.

## Notes

running redis-stack-server in docker:

```shell
docker run --name my-redis-container -p 6378:6379 -v `pwd`/dockerredisdata:/data  -d redis/redis-stack-server:latest
```

I chose the port 6378 because developers often have already a redis server running on the default port.

> ## ATTENTION
>
>none of these tools and scripts are production-ready!!! There is no boundary checking, no maintenance. This is a proof-of-concept and a boilerplate at best!

## searchdemo subtree

This contains the website shown in the demo of the talk. It has a separate composer.json, and the following 'commandline' tools (not symfony-commands, just php scripts):
- redis-create-index.php : to create the index, usage `php redis-create-index.php`. **Check the script before executing and adapt it to your setup and needs!! It makes assumptions about your setup!!**
- redis-load-data-from-database.php - this will load the contents of a table from your TYPO3 style database. **Check the script before executing and adapt it to your setup and needs!! It makes assumptions about your setup and database connection!!** This is a raw PDO connection. Usage: `DBUSER=db DBPASS=db php redis-load-data-from-database.php myt3db 123 http://mybaseurl.de/ tt_content` - this would recursively load all tt_content records from PID 123 down, and create embeddings for the page-title, content-header and content-bodytext. **Check the script before executing and adapt it to your setup and needs!! It makes assumptions about your setup and database connection!!**
- redis-load-news-from-database.php - same as the script before, but for tx_news records: `DBUSER=db DBPASS=db php redis-load-news-from-database.php myt3db  http://mybaseurl.de/detail`
- redis-chat.php - a cli chat tool for accessing the redis-index. Usage: `php redis-chat.php` **Check the script before executing and adapt it to your setup and needs!! It makes assumptions about your setup!!**

> ## ATTENTION
>
> none of these tools and scripts are production-ready!!! There is no boundary checking, no maintenance. This is a proof-of-concept and a boilerplate at best!

A more production ready implementation of a redmine search tool can be found at [https://github.com:sudhaus7/redmine-embedding-search](https://github.com:sudhaus7/redmine-embedding-search)
