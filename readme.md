# IMPanel with Backpack

IMPanel is a ready to use application with all [Backpack for Laravel](https://github.com/Laravel-Backpack) packages.

## Install

1) Run in your terminal:

``` bash
$ git clone https://github.com/iMokhles/IMPanel.git IMPanel
```

2) Set your database information in your .env file (use the .env.example as an example);

3) Run in your IMPanel folder:
``` bash
$ composer install
$ cp .env.example .env
$ ( add your database information in .env )
$ php artisan key:generate
$ php artisan migrate:refresh --seed --force
```

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [FILE].

## Security Vulnerabilities

If you discover a security vulnerability within IMPanel, please send an e-mail to Mokhlas Hussein via [mokhleshussien@aol.com](mailto:mokhleshussien@aol.com). All security vulnerabilities will be promptly addressed.

## Credits

- [iMokhles](http://github.com/imokhles)
- [Backpack for Laravel](https://github.com/Laravel-Backpack)


## License

IMPanel is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
