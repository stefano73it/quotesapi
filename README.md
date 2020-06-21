# Quotes API

Get inspirational quotes from famous people. You can use in 3 different ways:

- REST API using the endpoint /shout/[author]?limit=[count]
- Web page available in the project root
- CLI using the command
  ```sh
  php shout.php <author> <limit>
  ```

### Installation

Clone the Github repository.

```sh
$ git clone https://github.com/stefano73it/quotesapi
$ cd quotesapi
```

Edit settings in the `.env` file.

Run composer 
```sh
$ composer install
```

### Examples

Rest API for Mark Twain's quotes:
```sh
http://localhost/quotesapi/shout/mark%20twain?limit=2
http://localhost/quotesapi/shout.php?author=mark%20twain&limit=2
```

Run the project in your browser:
```sh
http://localhost/quotesapi
```

Get quotes from command line:
  ```sh
  php shout.php "Mark TWain" 2
  ```
