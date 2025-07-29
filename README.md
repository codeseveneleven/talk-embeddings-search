# Let's Build an AI-Driven Search on Our Website

[Presented by Frank Berger at TYPO3 Developer Days 2025.](https://code711.de/talks/embeddings-the-lesser-known-hero-of-ai)


## Embeddings
Essentially, embeddings are points in a multi-dimensional space, represented as vectors. They encode both semantic and contextual information of a word, phrase, or text, making them highly significant in AI and language processing.


## Tools used
Our examples depend heavily on OpenAI's embedding models. In particular, the 'text-embedding-ada-002' model with its 1536 dimensions normalized to unit length (ranging from 0 and 1) serves our purpose well.

Redis with JSON and Vector Sets plugins enabled

Feel free to explore the code examples and learn more about embeddings.

## Notes

running redis-stack-server in docker:

```shell
docker run --name my-redis-container -p 6378:6379 -v `pwd`/dockerredisdata:/data  -d redis/redis-stack-server:latest
```

The examples expect an OpenAI key in the environment variable OPENAIKEY
